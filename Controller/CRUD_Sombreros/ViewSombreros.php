<?php
require('../../Model/conexion.php');
header('Content-Type: application/json'); // Siempre envía JSON

// 1. Verifica si el ID llegó
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Si no llegó ID, envía un error
    echo json_encode(['error' => 'No se recibió ningún ID.']);
    exit;
}

$id_sombrero = $_GET['id'];

// 2. Prepara la consulta (¡ASEGÚRATE que tu columna se llama 'id_sombrero'!)
$sql = $conn->prepare("SELECT * FROM sombreros WHERE id_sombrero = ?");

if (!$sql) {
    // Si la preparación falla (ej. error de sintaxis SQL)
    echo json_encode(['error' => 'Error al preparar la consulta: ' . $conn->error]);
    exit;
}

// 3. Vincula el parámetro (asumimos que es un entero "i")
$sql->bind_param("i", $id_sombrero);
$sql->execute();
$result = $sql->get_result();

// 4. Verifica si la consulta encontró algo
if ($result->num_rows === 0) {
    // Si no encontró filas, este es tu problema
    echo json_encode(['error' => 'Consulta vacía. No se encontró ningún producto con el ID: ' . $id_sombrero]);
    exit;
}

// 5. Si todo salió bien, obtén los datos y envíalos
$sombrero = $result->fetch_assoc();
echo json_encode($sombrero);

$sql->close();
$conn->close();
?>
