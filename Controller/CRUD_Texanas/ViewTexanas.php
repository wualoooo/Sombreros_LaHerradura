<?php
require('../../Model/conexion.php');
header('Content-Type: application/json');

// 1. Verificación
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'No se recibió ningún ID.']);
    exit;
}

$id_texana = $_GET['id'];

// 2. Preparar la consulta SQL (Texto)
// ERROR CORREGIDO: Quitamos la comilla simple (') después del ?
$sqlQuery = "SELECT 
            s.id_texana, -- Agregamos el ID principal por si acaso
            s.Nombre, 
            s.Precio,
            s.Color AS id_color,
            c.Nombre AS Nombre_Color,
            s.Horma AS id_horma,
            h.Nombre AS Nombre_Horma, 
            s.Copa AS id_copa,
            cp.Nombre AS Nombre_Copa,    
            s.Tam_Copa,
            s.Tam_ala,
            s.Material AS id_material,
            m.Nombre AS Nombre_Material,
            s.Img1,
            s.Img2,
            s.Img3,
            s.Img4
        FROM texanas s
        LEFT JOIN colores c ON s.Color = c.id_color
        LEFT JOIN hormas h ON s.Horma = h.id_horma
        LEFT JOIN copas cp ON s.Copa = cp.id_copa
        LEFT JOIN materiales m ON s.Material = m.id_material
        WHERE s.id_texana = ?"; // <-- SIN COMILLAS AQUÍ

// 3. Crear el objeto Statement
$stmt = $conn->prepare($sqlQuery);

if (!$stmt) {
    echo json_encode(['error' => 'Error al preparar: ' . $conn->error]);
    exit;
}

// 4. Vincular y Ejecutar
// ERROR CORREGIDO: Usamos $stmt, no $sql
$stmt->bind_param("i", $id_texana);
$stmt->execute();
$result = $stmt->get_result();

// 5. Verificar resultados
if ($result->num_rows === 0) {
    echo json_encode(['error' => 'No encontrado.']);
    exit;
}

$texana = $result->fetch_assoc();
echo json_encode($texana);

$stmt->close();
$conn->close();
?>