<?php
require('../../Model/conexion.php'); 

// Respuesta JSON
header('Content-Type: application/json');
$response = ['success' => false, 'error' => 'Error desconocido.'];

try {
    //VERIFICACIÓN
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido.');
    }

    // OBTENER DATOS
    $id = $_POST['id_sombrero'] ?? '';

    // VALIDACIÓN DEL ID
    if (empty($id)) {
        throw new Exception('Error: ID de sombrero no encontrado.');
    }

    // OBTENER LOS DATOS DE TEXTO ACTUALIZADOS
    $nombre = $_POST['NombreSombrero'];
    $color = $_POST['ColorSombrero'];
    $horma = $_POST['HormaSombrero'];
    $copa = $_POST['CopaSombrero'];
    $tam_copa = $_POST['TamañoCopaSombrero'];
    $tam_ala = $_POST['TamañoAlaSombrero'];
    $material = $_POST['MaterialSombrero'];
    $precio = $_POST['PrecioSombrero'];

    // ACTUALIZAR DATOS DE TEXTO
    $sql = "UPDATE sombreros SET 
                Nombre = ?, 
                Color = ?, 
                Horma = ?, 
                Copa = ?, 
                Tam_Copa = ?, 
                Tam_ala = ?,
                Material = ?, 
                Precio = ? 
            WHERE id_sombrero = ?";
            
    $stmt = $conn->prepare($sql);
    if (!$stmt) throw new Exception("Error en prepare SQL texto: " . $conn->error);

    $stmt->bind_param("ssssddsii", 
        $nombre, $color, $horma, $copa, $tam_copa, $tam_ala, $material, $precio, $id
    );

    if (!$stmt->execute()) {
        throw new Exception('Error al actualizar texto: ' . $stmt->error);
    }
    $stmt->close();

    //MANEJO DE IMÁGENES 
    $imagenes_form = ['imgSombrero1', 'imgSombrero2', 'imgSombrero3', 'imgSombrero4'];
    $columnas_bd = ['Img1', 'Img2', 'Img3', 'Img4'];
    $ruta_subida = "../../uploads/sombreros/"; 

    // Asegurar que la carpeta exista
    if (!file_exists($ruta_subida)) mkdir($ruta_subida, 0777, true);

    for ($i = 0; $i < count($imagenes_form); $i++) {
        
        $nombre_input = $imagenes_form[$i]; 
        $columna_actual = $columnas_bd[$i];
        
        if (isset($_FILES[$nombre_input]) && $_FILES[$nombre_input]['error'] == 0) {
            
            // OBTENER EL NOMBRE DE LA IMAGEN VIEJA
            $sql_get_old = "SELECT $columna_actual FROM sombreros WHERE id_sombrero = ?";
            $stmt_get = $conn->prepare($sql_get_old);
            $stmt_get->bind_param("i", $id);
            $stmt_get->execute();
            $stmt_get->bind_result($imagen_vieja);
            $stmt_get->fetch();
            $stmt_get->close();

            //SUBIR LA NUEVA IMAGEN
            $ext = pathinfo($_FILES[$nombre_input]['name'], PATHINFO_EXTENSION);
            $nombre_nuevo = uniqid('ImgSombrero_') . '.' . $ext;
            $ruta_destino = $ruta_subida . $nombre_nuevo;

            if (move_uploaded_file($_FILES[$nombre_input]['tmp_name'], $ruta_destino)) {
                
                // BORRAR LA IMAGEN VIEJA 
                if (!empty($imagen_vieja)) {
                    $ruta_vieja = $ruta_subida . $imagen_vieja;
                    if (file_exists($ruta_vieja)) {
                        unlink($ruta_vieja);
                    }
                }

                //ACTUALIZAR LA BD CON EL NOMBRE NUEVO
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
    $response['success'] = false;
    $response['error'] = $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>