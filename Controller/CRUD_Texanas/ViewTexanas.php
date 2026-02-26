<?php
require('../../Model/conexion.php');
header('Content-Type: application/json');

// 1. Verificación
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'No se recibió ningún ID.']);
    exit;
}

$id_texana = $_GET['id'];

// 2. Preparar la consulta SQL
$sqlQuery = "SELECT 
            t.id_texana, 
            t.SKU,           -- AGREGADO
            t.Nombre, 
            t.Precio,
            t.Color AS id_color,       
            c.Nombre AS Nombre_Color,  
            t.Horma AS id_horma,       
            h.Nombre AS Nombre_Horma, 
            t.Copa AS id_copa,         
            cp.Nombre AS Nombre_Copa,    
            t.Tam_Copa,
            t.Tam_ala,
            t.Material AS id_material, 
            m.Nombre AS Nombre_Material,
            t.Tallas,        -- AGREGADO
            t.Img1,
            t.Img2,
            t.Img3,
            t.Img4
        FROM texanas t
        LEFT JOIN colores c ON t.Color = c.id_color
        LEFT JOIN hormas h ON t.Horma = h.id_horma
        LEFT JOIN copas cp ON t.Copa = cp.id_copa
        LEFT JOIN materiales m ON t.Material = m.id_material
        WHERE t.id_texana = ?";

$stmt = $conn->prepare($sqlQuery);

if (!$stmt) {
    echo json_encode(['error' => 'Error al preparar: ' . $conn->error]);
    exit;
}

$stmt->bind_param("i", $id_texana);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'No se encontró la texana con ID: ' . $id_texana]);
}

$stmt->close();
$conn->close();
?>