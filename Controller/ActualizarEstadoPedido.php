<?php
// ActualizarEstadoPedido.php
require('../Model/conexion.php');
header('Content-Type: application/json');

// Recibir los datos enviados por JS
$input = file_get_contents('php://input');
$datos = json_decode($input, true);

if(!isset($datos['id_pedido']) || !isset($datos['estado'])) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos']);
    exit;
}

$id_pedido = intval($datos['id_pedido']);
$estado = intval($datos['estado']);

// Hacemos el UPDATE en la tabla pedidos
$sql = "UPDATE pedidos SET estado_envio = ? WHERE id_pedido = ?";
$stmt = $conn->prepare($sql);

if(!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Error SQL: ' . $conn->error]);
    exit;
}

// "si" = string (estado), integer (id_pedido)
$stmt->bind_param("ii", $estado, $id_pedido);

if($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>