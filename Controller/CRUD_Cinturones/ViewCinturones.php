<?php
require('../../Model/conexion.php');
header('Content-Type: application/json');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'No se recibió ningún ID.']);
    exit;
}

$id_cinturon = $_GET['id'];

$sqlQuery = "SELECT 
            c.id_cinturon, 
            c.SKU,
            c.Nombre, 
            c.Precio,
            c.Material AS id_material, 
            m_principal.Nombre AS Nombre_Material,
            c.Adorno AS id_adorno,
            m_adorno.Nombre AS Nombre_Adorno,
            c.Tamaño,   -- Este es el Ancho/Grosor
            c.Tallas,   -- Las tallas disponibles (32, 34, etc.)
            c.Img1,
            c.Img2,
            c.Img3,
            c.Img4
        FROM cinturones c
        LEFT JOIN materiales m_principal ON c.Material = m_principal.id_material
        LEFT JOIN materiales m_adorno ON c.Adorno = m_adorno.id_material
        WHERE c.id_cinturon = ?";

$stmt = $conn->prepare($sqlQuery);

if (!$stmt) {
    echo json_encode(['error' => 'Error al preparar: ' . $conn->error]);
    exit;
}

$stmt->bind_param("i", $id_cinturon);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    
    // --- NUEVO: TRAER EL INVENTARIO Y STOCK ---
    $sku = $data['SKU'];
    $sql_inv = "SELECT talla, stock FROM inventario_tallas WHERE SKU_producto = ? AND tipo_producto = 'cinturones'";
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
    echo json_encode(['error' => 'No se encontró el cinturón con ID: ' . $id_cinturon]);
}

$stmt->close();
$conn->close();
?>