<?php

include '../../Model/conexion.php'; 

// Preparamos una respuesta JSON para que JavaScript la entienda
header('Content-Type: application/json');
$response = ['success' => false, 'error' => 'Error desconocido.'];

// --- 2. VERIFICACIÓN ---
// Solo continuamos si los datos se enviaron por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // --- 3. OBTENER DATOS DEL FORMULARIO ---
    // Usamos los 'name' exactos de tu formulario HTML

    // ¡El ID oculto es el más importante!
    $id = $_POST['id_cinturon']; 

    // Campos de texto
    $Nombre = $_POST['NombreCinturon'];
    $Precio = $_POST['PrecioCinturon'];
    $Material = $_POST['MaterialCinturon'];
    $Adorno = $_POST['AdornoCinturon'];
    $Tamaño = $_POST['TamañoCinturon'];

    // Validar que el ID no esté vacío
    if (empty($id)) {
        $response['error'] = 'Error: ID de producto no proporcionado.';
        echo json_encode($response);
        exit;
    }

    // --- 4. ACTUALIZAR DATOS DE TEXTO ---
    // Preparamos la consulta SQL para ACTUALIZAR
    $sql = "UPDATE cinturones SET 
                Nombre = ?, 
                Precio = ?, 
                Material = ?, 
                Adorno = ?, 
                Tamaño = ?
            WHERE id_cinturon = ?";
            
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("sdiidi", 
        $Nombre, 
        $Precio, 
        $Material,
        $Adorno, 
        $Tamaño,
        $id
    );

    // Ejecutamos la actualización de los datos
    if (!$stmt->execute()) {
        $response['error'] = 'Error SQL: ' . $stmt->error;
        echo json_encode($response);
        exit;
    }

    // --- NUEVA VALIDACIÓN ---
    if ($stmt->affected_rows === 0) {
        // Esto pasa si el ID no existe O si enviaste los mismos datos que ya tenía
        $response['warning'] = 'No se realizaron cambios (los datos eran iguales o el ID no existe).';
    }
    $stmt->close(); // Cerramos la primera consulta
    
    $inputs_html = ['imgCinturon1', 'imgCinturon2', 'imgCinturon3', 'imgCinturon4'];
    $cols_db     = ['Img1', 'Img2', 'Img3', 'Img4'];
    
    // IMPORTANTE: Ajusta la ruta a la carpeta de tus cinturones
    $directorio_destino = "../../uploads/cinturones/";

    // Verificamos si la carpeta existe, si no, intentamos crearla (opcional)
    if (!is_dir($directorio_destino)) {
        mkdir($directorio_destino, 0777, true);
    }

    for ($i = 0; $i < count($inputs_html); $i++) {
        
        $nombre_input = $inputs_html[$i]; // Ej: 'imgCinturon1'
        $columna      = $cols_db[$i];     // Ej: 'Img1'

        // Verificar si el usuario subió un archivo en este input
        if (isset($_FILES[$nombre_input]) && $_FILES[$nombre_input]['error'] === UPLOAD_ERR_OK) {
            
            // PASO A: BUSCAR LA IMAGEN VIEJA PARA BORRARLA
            // Hacemos una consulta rápida para saber qué archivo hay actualmente
            $sql_old = "SELECT $columna FROM cinturones WHERE id_cinturon = ?";
            $stmt_old = $conn->prepare($sql_old);
            $stmt_old->bind_param("i", $id);
            $stmt_old->execute();
            $stmt_old->bind_result($imagen_anterior);
            $stmt_old->fetch();
            $stmt_old->close();

            // PASO B: BORRAR EL ARCHIVO DEL SERVIDOR
            if (!empty($imagen_anterior)) {
                $ruta_archivo_anterior = $directorio_destino . $imagen_anterior;
                // Verificamos si el archivo realmente existe antes de intentar borrarlo
                if (file_exists($ruta_archivo_anterior)) {
                    unlink($ruta_archivo_anterior); // <--- ESTO BORRA LA FOTO
                }
            }

            // PASO C: SUBIR LA NUEVA IMAGEN
            $ext = pathinfo($_FILES[$nombre_input]['name'], PATHINFO_EXTENSION);
            // Generamos nombre único: id_cinturon + timestamp + indice . jpg
            $nombre_nuevo = 'Cinturon'.$id . '_' . time() . "_img$i." . $ext;
            $ruta_completa_nueva = $directorio_destino . $nombre_nuevo;

            if (move_uploaded_file($_FILES[$nombre_input]['tmp_name'], $ruta_completa_nueva)) {
                
                // PASO D: ACTUALIZAR EL NOMBRE EN LA BASE DE DATOS
                $sql_update_img = "UPDATE cinturones SET $columna = ? WHERE id_cinturon = ?";
                $stmt_img = $conn->prepare($sql_update_img);
                $stmt_img->bind_param("si", $nombre_nuevo, $id);
                
                if ($stmt_img->execute()) {
                    // Opcional: Agregar mensaje de éxito
                } else {
                    $response['warnings'][] = "Error al actualizar BD para $columna";
                }
                $stmt_img->close();

            } else {
                $response['warnings'][] = "No se pudo mover el archivo subido en $nombre_input";
            }
        }
    }

    // --- 6. ÉXITO ---
    // Si todo salió bien, marcamos como exitoso
    $response['success'] = true;
    $response['error'] = ''; // Limpiamos el error

} else {
    // Si alguien intenta acceder al script sin POST
    $response['error'] = 'Método no permitido.';
}

// Cerramos la conexión
$conn->close();

// Devolvemos la respuesta JSON al JavaScript
echo json_encode($response);
?>