<?php
include '../../Model/conexion.php'; 

// Respuesta JSON
header('Content-Type: application/json');
$response = ['success' => false, 'error' => 'Error desconocido.'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 1. OBTENER ID
    $id = $_POST['id_botin'] ?? '';

    if (empty($id)) {
        echo json_encode(['success' => false, 'error' => 'Error: ID no proporcionado.']);
        exit;
    }

    // 2. ACTUALIZAR DATOS DE TEXTO
    $Nombre = $_POST['NombreBotin'];
    $Talla = $_POST['TallaBotin'];
    $Material = $_POST['MaterialBotin'];
    $Suela = $_POST['SuelaBotin'];
    $Precio = $_POST['PrecioBotin'];

    $sql = "UPDATE botines SET 
                Nombre = ?, 
                Talla = ?, 
                Material = ?, 
                Suela = ?, 
                Precio = ?
            WHERE id_botin = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissii", $Nombre, $Talla, $Material, $Suela, $Precio, $id);

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'error' => 'Error al actualizar texto: ' . $stmt->error]);
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();

    // 3. MANEJO DE IMÁGENES (Replicado de Cinturones)
    
    // Inputs del formulario HTML (adminBotines.js)
    $imagenes_form = ['imgBotin1', 'imgBotin2', 'imgBotin3', 'imgBotin4'];
    // Columnas en la Base de Datos
    $columnas_db = ['Img1', 'Img2', 'Img3', 'Img4'];
    
    $ruta_subida = "../../uploads/botines/"; 

    // Asegurar que la carpeta exista
    if (!file_exists($ruta_subida)) {
        mkdir($ruta_subida, 0777, true);
    }

    for ($i = 0; $i < count($imagenes_form); $i++) {
        
        $nombre_input = $imagenes_form[$i]; 
        
        // Verificar si el usuario subió una imagen nueva en este input
        if (isset($_FILES[$nombre_input]) && $_FILES[$nombre_input]['error'] == 0) {
            
            $columna = $columnas_db[$i];

            // A) Obtener nombre de la imagen VIEJA para borrarla
            $sql_vieja = "SELECT $columna FROM botines WHERE id_botin = ?";
            $stmt_v = $conn->prepare($sql_vieja);
            $stmt_v->bind_param("i", $id);
            $stmt_v->execute();
            $stmt_v->bind_result($imagen_vieja);
            $stmt_v->fetch();
            $stmt_v->close();

            // B) Procesar la imagen NUEVA
            $ext = pathinfo($_FILES[$nombre_input]['name'], PATHINFO_EXTENSION);
            
            // Validación básica de extensión (Seguridad)
            if (!in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp'])) {
                $response['warnings'][] = "Formato no permitido en $nombre_input. Solo jpg, png, webp.";
                continue; 
            }

            // Generar nombre único: ImgBotin_ID_Timestamp_Indice.ext
            $nombre_nuevo = 'ImgBotin_' . $id . '_' . time() . "_$i." . $ext;
            $ruta_destino = $ruta_subida . $nombre_nuevo;

            // C) Mover el archivo y Actualizar BD
            if (move_uploaded_file($_FILES[$nombre_input]['tmp_name'], $ruta_destino)) {
                
                // 1. Borrar archivo viejo si existe
                if (!empty($imagen_vieja)) {
                    $ruta_vieja_completa = $ruta_subida . $imagen_vieja;
                    if (file_exists($ruta_vieja_completa)) {
                        unlink($ruta_vieja_completa);
                    }
                }

                // 2. Actualizar registro en BD
                $sql_update_img = "UPDATE botines SET $columna = ? WHERE id_botin = ?";
                $stmt_img = $conn->prepare($sql_update_img);
                $stmt_img->bind_param("si", $nombre_nuevo, $id);
                
                if (!$stmt_img->execute()) {
                    $response['warnings'][] = "Error SQL al guardar $columna";
                }
                $stmt_img->close();

            } else {
                $response['warnings'][] = "No se pudo subir el archivo $nombre_input.";
            }
        }
    }

    $response['success'] = true;
    $response['message'] = 'Botín actualizado correctamente.';

} else {
    $response['error'] = 'Método no permitido.';
}

$conn->close();
echo json_encode($response);
?>