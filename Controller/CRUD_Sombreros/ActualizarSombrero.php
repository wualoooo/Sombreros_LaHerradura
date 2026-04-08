<?php
require('../../Model/conexion.php'); 

header('Content-Type: application/json');
$response = ['success' => false, 'error' => 'Error desconocido.'];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido.');
    }
    $id = $_POST['id_sombrero'] ?? '';

    if (empty($id)) {
        throw new Exception('Error: ID de sombrero no encontrado.');
    }

    $sku = trim($_POST['SKUSombrero']);
    $nombre = trim($_POST['NombreSombrero']);
    $color = $_POST['ColorSombrero'];
    $horma = $_POST['HormaSombrero'];
    $copa = $_POST['CopaSombrero'];
    $tam_copa = $_POST['TamañoCopaSombrero'];
    $tam_ala = $_POST['TamañoAlaSombrero'];
    $material = $_POST['MaterialSombrero'];
    $precio = $_POST['PrecioSombrero'];

    $tallas_texto = "Unitalla";
    if (isset($_POST['tallas_disponibles']) && is_array($_POST['tallas_disponibles'])) {
        $tallas_texto = implode(",", $_POST['tallas_disponibles']); 
    }

    $sql = "UPDATE sombreros SET 
                SKU = ?,
                Nombre = ?, 
                Color = ?, 
                Horma = ?, 
                Copa = ?, 
                Tam_Copa = ?, 
                Tam_ala = ?,
                Material = ?, 
                Precio = ?,
                Tallas = ?
            WHERE id_sombrero = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparando la consulta: " . $conn->error);
    }

    $stmt->bind_param("ssiiiddidsi", $sku, $nombre, $color, $horma, $copa, $tam_copa, $tam_ala, $material, $precio, $tallas_texto, $id);

    if (!$stmt->execute()) {
        throw new Exception("Error al actualizar datos: " . $stmt->error);
    }
    $stmt->close(); // Esta es la línea 46 que ya tienes

    // --- NUEVO: ACTUALIZAR STOCK EN LA TABLA inventario_tallas ---
    
    // 1. Borramos el inventario VIEJO de este SKU específico
    // (Esto es más seguro que intentar hacer UPDATEs uno por uno, nos asegura que quede exactamente como viene en el form)
    $sql_delete_inv = "DELETE FROM inventario_tallas WHERE SKU_producto = ? AND tipo_producto = 'sombreros'";
    $stmt_del = $conn->prepare($sql_delete_inv);
    $stmt_del->bind_param("s", $sku);
    $stmt_del->execute();
    $stmt_del->close();

    // 2. Insertamos el inventario NUEVO
    if (isset($_POST['tallas_disponibles']) && !empty($_POST['tallas_disponibles'])) {
        $sql_inventario = "INSERT INTO inventario_tallas (SKU_producto, tipo_producto, talla, stock) VALUES (?, 'sombreros', ?, ?)";
        $stmt_inv = $conn->prepare($sql_inventario);

        foreach ($_POST['tallas_disponibles'] as $talla) {
            // Buscamos cuánto stock pusieron para esta talla en específico
            $stock = isset($_POST['stock_talla'][$talla]) ? intval($_POST['stock_talla'][$talla]) : 0;

            if ($stock > 0) {
                $stmt_inv->bind_param("ssi", $sku, $talla, $stock);
                $stmt_inv->execute();
            }
        }
        $stmt_inv->close();
    }
    // -----------------------------------------------------------
    
    // LÓGICA DE ACTUALIZACIÓN DE IMÁGENES (Lo que ya tienes abajo)

    // LÓGICA DE ACTUALIZACIÓN DE IMÁGENES
    $ruta_subida = "../../uploads/sombreros/";
    
    if (!file_exists($ruta_subida)) {
        mkdir($ruta_subida, 0777, true);
    }

    $imagenes_keys = [
        'imgSombrero1' => 'Img1',
        'imgSombrero2' => 'Img2',
        'imgSombrero3' => 'Img3',
        'imgSombrero4' => 'Img4'
    ];

    foreach ($imagenes_keys as $nombre_input => $columna_actual) {
        if (isset($_FILES[$nombre_input]) && $_FILES[$nombre_input]['error'] === UPLOAD_ERR_OK) {
            
            $sql_get_img = "SELECT $columna_actual FROM sombreros WHERE id_sombrero = ?";
            $stmt_get = $conn->prepare($sql_get_img);
            $stmt_get->bind_param("i", $id);
            $stmt_get->execute();
            $result_img = $stmt_get->get_result();
            $row_img = $result_img->fetch_assoc();
            $imagen_vieja = $row_img[$columna_actual] ?? '';
            $stmt_get->close();

            $ext = pathinfo($_FILES[$nombre_input]['name'], PATHINFO_EXTENSION);
            $nombre_nuevo = uniqid('ImgSombrero_') . '.' . $ext;
            $ruta_destino = $ruta_subida . $nombre_nuevo;

            if (move_uploaded_file($_FILES[$nombre_input]['tmp_name'], $ruta_destino)) {
                
                if (!empty($imagen_vieja)) {
                    $ruta_vieja = $ruta_subida . $imagen_vieja;
                    if (file_exists($ruta_vieja)) {
                        unlink($ruta_vieja);
                    }
                }

                $sql_update_img = "UPDATE sombreros SET $columna_actual = ? WHERE id_sombrero = ?";
                $stmt_img = $conn->prepare($sql_update_img);
                $stmt_img->bind_param("si", $nombre_nuevo, $id);
                
                if (!$stmt_img->execute()) {
                    $response['warnings'][] = "Error SQL al actualizar imagen $columna_actual";
                }
                $stmt_img->close();

            } else {
                $response['warnings'][] = "No se pudo subir el archivo del input $nombre_input.";
            }
        }
    }

    $response['success'] = true;
    $response['message'] = 'Sombrero actualizado correctamente.';

} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
?>