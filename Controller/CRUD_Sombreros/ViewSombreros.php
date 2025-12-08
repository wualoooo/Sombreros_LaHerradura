<?php
require('../../Model/conexion.php');
header('Content-Type: application/json');

// 1. Verificación
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'No se recibió ningún ID.']);
    exit;
}

$id_sombrero = $_GET['id'];

// 2. Preparar la consulta SQL (Texto)
// ERROR CORREGIDO: Quitamos la comilla simple (') después del ?
$sqlQuery = "SELECT 
            s.id_sombrero, -- Agregamos el ID principal por si acaso
            s.Nombre, 
            s.Precio,
            s.Color AS id_color,       -- NECESARIO PARA EDITAR (El ID)
            c.Nombre AS Nombre_Color,  -- (El Texto)
            s.Horma AS id_horma,       -- NECESARIO PARA EDITAR
            h.Nombre AS Nombre_Horma, 
            s.Copa AS id_copa,         -- NECESARIO PARA EDITAR
            cp.Nombre AS Nombre_Copa,    
            s.Tam_Copa,
            s.Tam_ala,
            s.Material AS id_material, -- NECESARIO PARA EDITAR
            m.Nombre AS Nombre_Material,
            s.Img1,
            s.Img2,
            s.Img3,
            s.Img4
        FROM sombreros s
        LEFT JOIN colores c ON s.Color = c.id_color
        LEFT JOIN hormas h ON s.Horma = h.id_horma
        LEFT JOIN copas cp ON s.Copa = cp.id_copa
        LEFT JOIN materiales m ON s.Material = m.id_material
        WHERE s.id_sombrero = ?"; // <-- SIN COMILLAS AQUÍ

// 3. Crear el objeto Statement
$stmt = $conn->prepare($sqlQuery);

if (!$stmt) {
    echo json_encode(['error' => 'Error al preparar: ' . $conn->error]);
    exit;
}

// 4. Vincular y Ejecutar
// ERROR CORREGIDO: Usamos $stmt, no $sql
$stmt->bind_param("i", $id_sombrero);
$stmt->execute();
$result = $stmt->get_result();

// 5. Verificar resultados
if ($result->num_rows === 0) {
    echo json_encode(['error' => 'No encontrado.']);
    exit;
}

$sombrero = $result->fetch_assoc();
echo json_encode($sombrero);

$stmt->close();
$conn->close();
?>