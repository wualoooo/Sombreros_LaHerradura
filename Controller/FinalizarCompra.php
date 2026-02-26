<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0); 
header('Content-Type: application/json');

require('../Model/conexion.php');

try {
    // 1. VALIDAR SESIÓN
    if (!isset($_SESSION['id_usuario'])) {
        throw new Exception("Debes iniciar sesión para finalizar la compra.");
    }
    
    $id_usuario = $_SESSION['id_usuario'];

    // 2. RECIBIR DATOS
    $input = file_get_contents('php://input');
    $datosCompra = json_decode($input, true);

    if (!$datosCompra || empty($datosCompra['carrito'])) {
        throw new Exception("El carrito está vacío o hubo un error al leer los datos.");
    }

    $carrito = $datosCompra['carrito'];
    $id_direccion = intval($datosCompra['id_direccion']);
    $total = floatval($datosCompra['total']);

    // 3. CONVERTIR CARRITO A JSON
    $productos_json = json_encode($carrito, JSON_UNESCAPED_UNICODE);

    // 4. INSERTAR EN LA BASE DE DATOS
    $sql = "INSERT INTO pedidos (id_usuario, id_direccion, total, productos, estado_envio) VALUES (?, ?, ?, ?, 1)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("iids", $id_usuario, $id_direccion, $total, $productos_json);

    if ($stmt->execute()) {
        $id_pedido = $stmt->insert_id;
        
        // 5. GENERAR CÓDIGO DE RASTREO
        $codigo_rastreo = "LH-" . date('Y') . "-" . str_pad($id_pedido, 4, "0", STR_PAD_LEFT);
        
        // -------------------------------------------------------------
        // ¡NUEVO! GUARDAR EL CÓDIGO DE RASTREO EN LA BASE DE DATOS
        // -------------------------------------------------------------
        $sql_update = "UPDATE pedidos SET codigo_rastreo = ? WHERE id_pedido = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("si", $codigo_rastreo, $id_pedido);
        $stmt_update->execute();
        $stmt_update->close();
        
        // 6. ENVIAR RESPUESTA AL USUARIO
        echo json_encode([
            'success' => true, 
            'codigo_rastreo' => $codigo_rastreo,
            'message' => 'Pedido guardado correctamente.'
        ]);
    } else {
        throw new Exception("Error al guardar el pedido en la BD: " . $stmt->error);
    }

    $stmt->close();

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>