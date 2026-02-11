<?php
require('../Model/conexion.php');
session_start();
header('Content-Type: application/json');

// 1. Verificar sesión
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no logueado']);
    exit;
}

// 2. Recibir datos del Frontend (JSON)
$input = json_decode(file_get_contents('php://input'), true);

$id_usuario = $_SESSION['id_usuario'];
$id_direccion = $input['id_direccion'] ?? null;
$carrito = $input['carrito'] ?? []; // Array de productos
$total = $input['total'] ?? 0;

// Validaciones básicas
if (!$id_direccion || empty($carrito)) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos (dirección o carrito vacío)']);
    exit;
}

// 3. FUNCIÓN PARA GENERAR CÓDIGO ÚNICO (10 DÍGITOS)
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

// --- INICIO DE LA TRANSACCIÓN ---
// Esto asegura que si algo falla, no se guarde nada a medias
$conn->begin_transaction();

try {
    // A. Generar el código
    $codigoRastreo = generarCodigoRastreo($conn);

    // B. Insertar el Pedido (Cabecera)
    $sqlPedido = "INSERT INTO pedidos (id_usuario, id_direccion, total, codigo_rastreo, estado_pago) 
                VALUES (?, ?, ?, ?, 'Aprobado')";
    $stmt = $conn->prepare($sqlPedido);
    $stmt->bind_param("iids", $id_usuario, $id_direccion, $total, $codigoRastreo);
    $stmt->execute();
    $id_pedido = $conn->insert_id; // Obtenemos el ID generado
    $stmt->close();

    // C. Insertar los Detalles (Productos)
    $sqlDetalle = "INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario, talla) 
                VALUES (?, ?, ?, ?, ?)";
    $stmtDetalle = $conn->prepare($sqlDetalle);

    foreach ($carrito as $prod) {
        $stmtDetalle->bind_param("iiids", 
            $id_pedido, 
            $prod['id'], 
            $prod['cantidad'], 
            $prod['precio'], 
            $prod['talla'] // ¡Aquí guardamos la talla que hicimos antes!
        );
        $stmtDetalle->execute();
        
        // OPCIONAL: Aquí podrías restar el stock de la tabla productos
        // $conn->query("UPDATE sombreros SET Stock = Stock - {$prod['cantidad']} WHERE id_sombrero = {$prod['id']}");
    }
    $stmtDetalle->close();

    // D. Confirmar todo (Commit)
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