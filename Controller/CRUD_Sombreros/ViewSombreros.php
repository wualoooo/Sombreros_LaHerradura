<?php
require('../../Model/conexion.php');
header('Content-Type: application/json');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'No se recibió ningún ID.']);
    exit;
}

$id_sombrero = $_GET['id'];

$sqlQuery = "SELECT 
            s.id_sombrero, 
            s.SKU,           -- AGREGADO
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
            s.Tallas,        -- AGREGADO
            s.Img1,
            s.Img2,
            s.Img3,
            s.Img4
        FROM sombreros s
        LEFT JOIN colores c ON s.Color = c.id_color
        LEFT JOIN hormas h ON s.Horma = h.id_horma
        LEFT JOIN copas cp ON s.Copa = cp.id_copa
        LEFT JOIN materiales m ON s.Material = m.id_material
        WHERE s.id_sombrero = ?";

$stmt = $conn->prepare($sqlQuery);

if (!$stmt) {
    echo json_encode(['error' => 'Error al preparar: ' . $conn->error]);
    exit;
}

$stmt->bind_param("i", $id_sombrero);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    
    // --- NUEVO: TRAER EL INVENTARIO Y STOCK ---
    $sku = $data['SKU'];
    $sql_inv = "SELECT talla, stock FROM inventario_tallas WHERE SKU_producto = ? AND tipo_producto = 'sombreros'";
    $stmt_inv = $conn->prepare($sql_inv);
    $stmt_inv->bind_param("s", $sku);
    $stmt_inv->execute();
    $result_inv = $stmt_inv->get_result();
    
    $inventario = [];
    while ($row_inv = $result_inv->fetch_assoc()) {
        $inventario[] = $row_inv; // Guarda ['talla' => '55', 'stock' => 10]
    }
    $stmt_inv->close();
    
    // Inyectamos el inventario dentro de la respuesta JSON principal
    $data['inventario'] = $inventario; 
    // -----------------------------------------

    echo json_encode($data);
} else {
    echo json_encode(['error' => 'No se encontró el sombrero con ID: ' . $id_sombrero]);
}

$stmt->close();
$conn->close();
?>