<?php
require('../../Model/conexion.php');
header('Content-Type: application/json');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'No se recibió ningún ID.']);
    exit;
}

$id_botin = $_GET['id'];

$sqlQuery = "SELECT 
            b.id_botin, 
            b.SKU,
            b.Nombre, 
            b.Precio,
            b.Talla,
            b.Material AS id_material, 
            m_mat.Nombre AS Nombre_Material,
            b.Suela AS id_suela,
            m_suela.Nombre AS Nombre_Suela,
            b.Img1,
            b.Img2,
            b.Img3,
            b.Img4
        FROM botines b
        LEFT JOIN materiales m_mat ON b.Material = m_mat.id_material
        LEFT JOIN materiales m_suela ON b.Suela = m_suela.id_material
        WHERE b.id_botin = ?";

$stmt = $conn->prepare($sqlQuery);

if (!$stmt) {
    echo json_encode(['error' => 'Error al preparar: ' . $conn->error]);
    exit;
}

$stmt->bind_param("i", $id_botin);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'No se encontró el botín con ID: ' . $id_botin]);
}

$stmt->close();
$conn->close();
?>