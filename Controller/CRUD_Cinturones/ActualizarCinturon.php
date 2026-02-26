<?php
require('../../Model/conexion.php'); 

header('Content-Type: application/json');
$response = ['success' => false, 'error' => 'Error desconocido.'];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido.');
    }

    $id = $_POST['id_cinturon'] ?? '';

    if (empty($id)) {
        throw new Exception('Error: ID de cinturón no encontrado.');
    }

    // OBTENER LOS NUEVOS DATOS
    $sku = trim($_POST['SKUCinturon']);
    $nombre = trim($_POST['NombreCinturon']);
    $precio = $_POST['PrecioCinturon'];
    $material = $_POST['MaterialCinturon'];
    $adorno = $_POST['AdornoCinturon'];
    $tamano = !empty($_POST['TamañoCinturon']) ? $_POST['TamañoCinturon'] : 0;

    // PROCESAR TALLAS
    $tallas_texto = "Unitalla";
    if (isset($_POST['tallas_disponibles']) && is_array($_POST['tallas_disponibles'])) {
        $tallas_texto = implode(",", $_POST['tallas_disponibles']); 
    }

    // ACTUALIZAR DATOS EN BD
    $sql = "UPDATE cinturones SET 
                SKU = ?,
                Nombre = ?, 
                Precio = ?,
                Material = ?, 
                Adorno = ?,
                Tamaño = ?,
                Tallas = ?
            WHERE id_cinturon = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparando la consulta: " . $conn->error);
    }

    // ssdidsi = String, String, Double, Int, Int, Double, String, Int
    $stmt->bind_param("ssdiidsi", $sku, $nombre, $precio, $material, $adorno, $tamano, $tallas_texto, $id);

    if (!$stmt->execute()) {
        throw new Exception("Error al actualizar datos: " . $stmt->error);
    }
    $stmt->close();

    // ----------------------------------------------------
    // ACTUALIZACIÓN DE IMÁGENES
    // ----------------------------------------------------
    $ruta_subida = "../../uploads/cinturones/";
    if (!file_exists($ruta_subida)) {
        mkdir($ruta_subida, 0777, true);
    }

    $imagenes_keys = [
        'imgCinturon1' => 'Img1',
        'imgCinturon2' => 'Img2',
        'imgCinturon3' => 'Img3',
        'imgCinturon4' => 'Img4'
    ];

    foreach ($imagenes_keys as $nombre_input => $columna_actual) {
        if (isset($_FILES[$nombre_input]) && $_FILES[$nombre_input]['error'] === UPLOAD_ERR_OK) {
            
            // Obtener imagen vieja
            $sql_get_img = "SELECT $columna_actual FROM cinturones WHERE id_cinturon = ?";
            $stmt_get = $conn->prepare($sql_get_img);
            $stmt_get->bind_param("i", $id);
            $stmt_get->execute();
            $result_img = $stmt_get->get_result();
            $row_img = $result_img->fetch_assoc();
            $imagen_vieja = $row_img[$columna_actual] ?? '';
            $stmt_get->close();

            $ext = pathinfo($_FILES[$nombre_input]['name'], PATHINFO_EXTENSION);
            $nombre_nuevo = uniqid('ImgCinturon_') . '.' . $ext;
            $ruta_destino = $ruta_subida . $nombre_nuevo;

            if (move_uploaded_file($_FILES[$nombre_input]['tmp_name'], $ruta_destino)) {
                
                if (!empty($imagen_vieja)) {
                    $ruta_vieja = $ruta_subida . $imagen_vieja;
                    if (file_exists($ruta_vieja)) {
                        unlink($ruta_vieja);
                    }
                }

                $sql_update_img = "UPDATE cinturones SET $columna_actual = ? WHERE id_cinturon = ?";
                $stmt_img = $conn->prepare($sql_update_img);
                $stmt_img->bind_param("si", $nombre_nuevo, $id);
                $stmt_img->execute();
                $stmt_img->close();
            }
        }
    }

    $response['success'] = true;
    $response['message'] = 'Cinturón actualizado correctamente.';

} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
?>