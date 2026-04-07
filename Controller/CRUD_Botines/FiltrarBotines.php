<?php
require('../../Model/conexion.php');
header('Content-Type: application/json');

// Recibir el JSON desde JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Consulta base (Solo productos activos)
$sql = "SELECT id_botin, Img1, Nombre, Precio FROM botines WHERE Estado = 1";
$whereClausulas = [];
$parametros = [];
$tipos = "";

// 1. Filtro por Nombre (Buscador)
if (!empty($data['nombre'])) {
    $whereClausulas[] = "Nombre LIKE ?";
    $parametros[] = "%" . $data['nombre'] . "%";
    $tipos .= "s";
}

// 2. Filtro por Rango de Precios
if (!empty($data['precioMin'])) {
    $whereClausulas[] = "Precio >= ?";
    $parametros[] = $data['precioMin'];
    $tipos .= "d";
}
if (!empty($data['precioMax'])) {
    $whereClausulas[] = "Precio <= ?";
    $parametros[] = $data['precioMax'];
    $tipos .= "d";
}

// 3. Filtro por materiales
if (!empty($data['materiales'])) {
    $placeholders = implode(',', array_fill(0, count($data['materiales']), '?'));
    $whereClausulas[] = "Material IN ($placeholders)";
    foreach ($data['materiales'] as $materialId) {
        $parametros[] = $materialId;
        $tipos .= "i";
    }
}

// 3. Filtro por suelas
if (!empty($data['suelas'])) {
    $placeholders = implode(',', array_fill(0, count($data['suelas']), '?'));
    $whereClausulas[] = "Suela IN ($placeholders)";
    foreach ($data['suelas'] as $suelaId) {
        $parametros[] = $suelaId;
        $tipos .= "i";
    }
}

// 4. Filtro por Tallas (Valor único exacto en la BD)
if (!empty($data['tallas'])) {
    $placeholders = implode(',', array_fill(0, count($data['tallas']), '?'));
    $whereClausulas[] = "Talla IN ($placeholders)";
    foreach ($data['tallas'] as $talla) {
        $parametros[] = $talla;
        $tipos .= "s"; 
    }
}
// Ensamblar la consulta final
if (count($whereClausulas) > 0) {
    $sql .= " AND " . implode(" AND ", $whereClausulas);
}

// Preparar y ejecutar
$stmt = $conn->prepare($sql);

if ($tipos !== "") {
    $stmt->bind_param($tipos, ...$parametros); 
}

$stmt->execute();
$resultado = $stmt->get_result();

$productos = [];
while ($row = $resultado->fetch_assoc()) {
    $productos[] = $row;
}

echo json_encode($productos);

$stmt->close();
$conn->close();
?>