<?php
require('../../Model/conexion.php');
header('Content-Type: application/json');

// Recibir el JSON desde JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Consulta base (Solo productos activos)
$sql = "SELECT id_cinturon, Img1, Nombre, Precio FROM cinturones WHERE Estado = 1";
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

// 3. Filtro por Copas
if (!empty($data['adornos'])) {
    $placeholders = implode(',', array_fill(0, count($data['adornos']), '?'));
    $whereClausulas[] = "Adorno IN ($placeholders)";
    foreach ($data['adornos'] as $adornoId) {
        $parametros[] = $adornoId;
        $tipos .= "i";
    }
}

// 3. Filtro por Copas
if (!empty($data['materiales'])) {
    $placeholders = implode(',', array_fill(0, count($data['materiales']), '?'));
    $whereClausulas[] = "Material IN ($placeholders)";
    foreach ($data['materiales'] as $materialId) {
        $parametros[] = $materialId;
        $tipos .= "i";
    }
}

// 4. Filtro por Tallas (Buscando en la cadena de la tabla principal)
if (!empty($data['tallas'])) {
    // Si seleccionan varias tallas (ej: 55 y 56), mostramos los que tengan 55 OR 56
    $tallasClausulas = [];
    foreach ($data['tallas'] as $talla) {
        $tallasClausulas[] = "Tallas LIKE ?";
        $parametros[] = "%" . $talla . "%";
        $tipos .= "s";
    }
    // Agrupamos los OR entre paréntesis
    $whereClausulas[] = "(" . implode(" OR ", $tallasClausulas) . ")";
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