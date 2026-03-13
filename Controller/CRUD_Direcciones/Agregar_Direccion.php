<?php
require('../../Model/conexion.php');
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no logueado']);
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

$cp = $_POST['cp'] ?? '';
$estado = $_POST['estado'] ?? '';
$municipio = $_POST['municipio'] ?? '';
$colonia = $_POST['colonia'] ?? '';
$calle = $_POST['calle'] ?? ''; 
$numero = $_POST['numCalle'] ?? '';
$tel = $_POST['numTel'] ?? '';
$ref = $_POST['referencia'] ?? '';

$sql = "INSERT INTO direcciones (id_usuario, cp, estado, municipio, colonia, calle, numero, telefono, referencia) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

$stmt->bind_param("issssssss", $id_usuario, $cp, $estado, $municipio, $colonia, $calle, $numero, $tel, $ref);

if ($stmt->execute()) {
    $nuevoID = $stmt->insert_id;
    echo json_encode([
        'success' => true, 
        'id_direccion' => $nuevoID,
        'mensaje' => 'Dirección guardada correctamente'
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar en BD: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>