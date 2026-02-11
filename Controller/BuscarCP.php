<?php
require "../Model/conexion.php";

    $cp = $_GET['cp'] ?? '';

    if (!preg_match('/^[0-9]{5}$/', $cp)) {
        echo json_encode(["error" => true]);
        exit;
    }

    $stmt = $conn->prepare(
        "SELECT estado, municipio, colonia 
        FROM sepomex 
        WHERE codigo_postal = ?"
    );

    $stmt->bind_param("s", $cp);
    $stmt->execute();

    $result = $stmt->get_result();

    $colonias = [];
    $estado = '';
    $municipio = '';

    while ($row = $result->fetch_assoc()) {
        $estado = $row['estado'];
        $municipio = $row['municipio'];
        $colonias[] = $row['colonia'];
    }

    if (empty($colonias)) {
        echo json_encode(["error" => true]);
        exit;
    }

    echo json_encode([
        "estado" => $estado,
        "municipio" => $municipio,
        "colonias" => $colonias
    ]);
