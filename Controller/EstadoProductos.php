<?php
require('../Model/conexion.php'); // Asegúrate que la ruta sea correcta

header('Content-Type: application/json');

// Recibir datos (ID, Tabla y Nuevo Estado)
$input = json_decode(file_get_contents('php://input'), true);

$id = $input['id'] ?? null;
$tabla = $input['tabla'] ?? null;
$estado = $input['estado'] ?? null; // 1 o 0
$columnaID = $input['columnaID'] ?? null; // ej: 'id_sombrero'

if (!$id || !$tabla || !isset($estado) || !$columnaID) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

// Lista blanca de tablas permitidas por seguridad
$tablasPermitidas = ['sombreros', 'texanas', 'botines', 'cinturones'];
if (!in_array($tabla, $tablasPermitidas)) {
    echo json_encode(['success' => false, 'message' => 'Tabla no permitida']);
    exit;
}

// Actualizar el estado
// OJO: Prevenimos inyección SQL en el nombre de la tabla/columna validando antes
$sql = "UPDATE $tabla SET Estado = ? WHERE $columnaID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $estado, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'nuevo_estado' => $estado]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
}

$stmt->close();
$conn->close();
?>