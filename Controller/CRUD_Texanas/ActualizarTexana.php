<?php
require('../../Model/conexion.php'); 

header('Content-Type: application/json');
$response = ['success' => false, 'error' => 'Error desconocido.'];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido.');
    }

    $id = $_POST['id_texana'] ?? '';

    if (empty($id)) {
        throw new Exception('Error: ID de texana no encontrado.');
    }

    $sku = trim($_POST['SKUTexana']);
    $nombre = trim($_POST['NombreTexana']);
    $color = $_POST['ColorTexana'];
    $horma = $_POST['HormaTexana'];
    $copa = $_POST['CopaTexana'];
    $tam_copa = $_POST['TamañoCopaTexana'];
    $tam_ala = $_POST['TamañoAlaTexana'];
    $material = $_POST['MaterialTexana'];
    $precio = $_POST['PrecioTexana'];

    $tallas_texto = "Unitalla";
    if (isset($_POST['tallas_disponibles']) && is_array($_POST['tallas_disponibles'])) {
        $tallas_texto = implode(",", $_POST['tallas_disponibles']); 
    }

    $sql = "UPDATE texanas SET 
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
            WHERE id_texana = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparando la consulta: " . $conn->error);
    }

    $stmt->bind_param("ssiiiddidsi", $sku, $nombre, $color, $horma, $copa, $tam_copa, $tam_ala, $material, $precio, $tallas_texto, $id);

    if (!$stmt->execute()) {
        throw new Exception("Error al actualizar datos: " . $stmt->error);
    }
    $stmt->close();

    $ruta_subida = "../../uploads/texanas/";
    if (!file_exists($ruta_subida)) {
        mkdir($ruta_subida, 0777, true);
    }

    $imagenes_keys = [
        'imgTexana1' => 'Img1',
        'imgTexana2' => 'Img2',
        'imgTexana3' => 'Img3',
        'imgTexana4' => 'Img4'
    ];

    foreach ($imagenes_keys as $nombre_input => $columna_actual) {
        if (isset($_FILES[$nombre_input]) && $_FILES[$nombre_input]['error'] === UPLOAD_ERR_OK) {

            $sql_get_img = "SELECT $columna_actual FROM texanas WHERE id_texana = ?";
            $stmt_get = $conn->prepare($sql_get_img);
            $stmt_get->bind_param("i", $id);
            $stmt_get->execute();
            $result_img = $stmt_get->get_result();
            $row_img = $result_img->fetch_assoc();
            $imagen_vieja = $row_img[$columna_actual] ?? '';
            $stmt_get->close();

            $ext = pathinfo($_FILES[$nombre_input]['name'], PATHINFO_EXTENSION);
            $nombre_nuevo = uniqid('ImgTexana_') . '.' . $ext;
            $ruta_destino = $ruta_subida . $nombre_nuevo;

            if (move_uploaded_file($_FILES[$nombre_input]['tmp_name'], $ruta_destino)) {
                
                if (!empty($imagen_vieja)) {
                    $ruta_vieja = $ruta_subida . $imagen_vieja;
                    if (file_exists($ruta_vieja)) {
                        unlink($ruta_vieja);
                    }
                }

                $sql_update_img = "UPDATE texanas SET $columna_actual = ? WHERE id_texana = ?";
                $stmt_img = $conn->prepare($sql_update_img);
                $stmt_img->bind_param("si", $nombre_nuevo, $id);
                $stmt_img->execute();
                $stmt_img->close();
            }
        }
    }

    $response['success'] = true;
    $response['message'] = 'Texana actualizada correctamente.';

} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
?>