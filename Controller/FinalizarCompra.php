<?php
require('../Model/conexion.php');
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no logueado']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$id_usuario = $_SESSION['id_usuario'];
$id_direccion = $input['id_direccion'] ?? null;
$carrito = $input['carrito'] ?? [];
$total = $input['total'] ?? 0;

if (!isset($id_direccion) || empty($carrito)) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos (dirección o carrito vacío)']);
    exit;
}

// FUNCIÓN PARA GENERAR CÓDIGO ÚNICO (10 DÍGITOS)
function generarCodigoRastreo($conn) {
    $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $codigo = '';
    
    // Intentar generar hasta encontrar uno único
    do {
        $codigo = '';
        for ($i = 0; $i < 10; $i++) {
            $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
        
        // Verificar si ya existe en la BD
        $sql = "SELECT id_pedido FROM pedidos WHERE codigo_rastreo = '$codigo'";
        $result = $conn->query($sql);
    } while ($result->num_rows > 0); // Si existe, repite el bucle
    
    return $codigo;
}

$conn->begin_transaction();

try {
    $codigoRastreo = generarCodigoRastreo($conn);

    $sqlPedido = "INSERT INTO pedidos (id_usuario, id_direccion, total, estado_pago, estado_envio, codigo_rastreo ) 
                VALUES (?, ?, ?, '5', '1', ?)";
    $stmt = $conn->prepare($sqlPedido);
    $stmt->bind_param("iids", $id_usuario, $id_direccion, $total, $codigoRastreo);
    $stmt->execute();
    $id_pedido = $conn->insert_id;
    $stmt->close();

    $sqlDetalle = "INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario, talla) 
                VALUES (?, ?, ?, ?, ?)";
    $stmtDetalle = $conn->prepare($sqlDetalle);

    foreach ($carrito as $prod) {
        $stmtDetalle->bind_param("iiids", 
            $id_pedido, 
            $prod['id'], 
            $prod['cantidad'], 
            $prod['precio'], 
            $prod['talla']
        );
        $stmtDetalle->execute();
    }
    $stmtDetalle->close();

    $conn->commit();

    echo json_encode([
        'success' => true, 
        'message' => 'Compra realizada con éxito',
        'codigo_rastreo' => $codigoRastreo,
        'id_pedido' => $id_pedido
    ]);

} catch (Exception $e) {
    // Si algo falla, deshacer todo (Rollback)
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Error al procesar: ' . $e->getMessage()]);
}

$conn->close();
?>