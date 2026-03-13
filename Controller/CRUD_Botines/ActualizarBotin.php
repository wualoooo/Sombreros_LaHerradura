<?php
require('../../Model/conexion.php'); 

header('Content-Type: application/json');
$response = ['success' => false, 'error' => 'Error desconocido.'];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido.');
    }

    $id = $_POST['id_botin'] ?? '';

    if (empty($id)) {
        throw new Exception('Error: ID de botín no encontrado.');
    }

    // OBTENER LOS NUEVOS DATOS
    $sku = trim($_POST['SKUBotin']);
    $nombre = trim($_POST['NombreBotin']);
    $precio = $_POST['PrecioBotin'];
    $talla = $_POST['TallaBotin'];
    $material = $_POST['MaterialBotin'];
    $suela = $_POST['SuelaBotin'];

    // ACTUALIZAR DATOS EN BD
    $sql = "UPDATE botines SET 
                SKU = ?,
                Nombre = ?, 
                Precio = ?,
                Talla = ?,
                Material = ?, 
                Suela = ?
            WHERE id_botin = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparando la consulta: " . $conn->error);
    }

    $stmt->bind_param("sddiiii", $sku, $nombre, $precio, $talla, $material, $suela, $id);

    if (!$stmt->execute()) {
        throw new Exception("Error al actualizar datos: " . $stmt->error);
    }
    $stmt->close(); 

    // ACTUALIZACIÓN DE IMÁGENES
    $ruta_subida = "../../uploads/botines/";
    if (!file_exists($ruta_subida)) {
        mkdir($ruta_subida, 0777, true);
    }

    $imagenes_keys = [
        'imgBotin1' => 'Img1',
        'imgBotin2' => 'Img2',
        'imgBotin3' => 'Img3',
        'imgBotin4' => 'Img4'
    ];

    foreach ($imagenes_keys as $nombre_input => $columna_actual) {
        if (isset($_FILES[$nombre_input]) && $_FILES[$nombre_input]['error'] === UPLOAD_ERR_OK) {
            
            $sql_get_img = "SELECT $columna_actual FROM botines WHERE id_botin = ?";
            $stmt_get = $conn->prepare($sql_get_img);
            $stmt_get->bind_param("i", $id);
            $stmt_get->execute();
            $result_img = $stmt_get->get_result();
            $row_img = $result_img->fetch_assoc();
            $imagen_vieja = $row_img[$columna_actual] ?? '';
            $stmt_get->close();

            $ext = pathinfo($_FILES[$nombre_input]['name'], PATHINFO_EXTENSION);
            $nombre_nuevo = uniqid('ImgBotin_') . '.' . $ext;
            $ruta_destino = $ruta_subida . $nombre_nuevo;

            if (move_uploaded_file($_FILES[$nombre_input]['tmp_name'], $ruta_destino)) {
                
                if (!empty($imagen_vieja)) {
                    $ruta_vieja = $ruta_subida . $imagen_vieja;
                    if (file_exists($ruta_vieja)) {
                        unlink($ruta_vieja);
                    }
                }

                $sql_update_img = "UPDATE botines SET $columna_actual = ? WHERE id_botin = ?";
                $stmt_img = $conn->prepare($sql_update_img);
                $stmt_img->bind_param("si", $nombre_nuevo, $id);
                $stmt_img->execute();
                $stmt_img->close();
            }
        }
    }

    $response['success'] = true;
    $response['message'] = 'Botín actualizado correctamente.';

} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
?>