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
    $id = $_POST['id_Texana']; 

    // Campos de texto
    $nombre = $_POST['NombreTexana'];
    $color = $_POST['ColorTexana'];
    $horma = $_POST['HormaTexana'];
    $copa = $_POST['CopaTexana'];
    $tam_copa = $_POST['TamañoCopaTexana'];
    $material = $_POST['MaterialTexana'];
    $precio = $_POST['PrecioTexana'];

    // Validar que el ID no esté vacío
    if (empty($id)) {
        $response['error'] = 'Error: ID de producto no proporcionado.';
        echo json_encode($response);
        exit;
    }

    // --- 4. ACTUALIZAR DATOS DE TEXTO ---
    // Preparamos la consulta SQL para ACTUALIZAR
    // Usamos '?' para prevenir inyección SQL
    $sql = "UPDATE texana SET 
                Nombre = ?, 
                Color = ?, 
                Horma = ?, 
                Copa = ?, 
                Tam_Copa = ?, 
                Material = ?, 
                Precio = ? 
            WHERE id_texana = ?";
            
    $stmt = $conn->prepare($sql);
    
    // 's' = string, 'd' = double (para precio), 'i' = integer (para id)
    $stmt->bind_param("ssssssdi", 
        $nombre, 
        $color, 
        $horma, 
        $copa, 
        $tam_copa, 
        $material,
        $precio,
        $id
    );

    // Ejecutamos la actualización de los datos
    if (!$stmt->execute()) {
        $response['error'] = 'Error al actualizar los datos: ' . $stmt->error;
        echo json_encode($response);
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close(); // Cerramos la primera consulta

    // --- 5. MANEJO DE IMÁGENES ---
    // (Esta parte es opcional pero muy recomendada)
    // Revisa si se subió una NUEVA imagen para reemplazar alguna de las existentes
    
    $imagenes_form = ['imgTexana1', 'imgTexana2', 'imgTexana3', 'imgTexana4'];
    $columnas_db = ['Img1', 'Img2', 'Img3', 'Img4'];
    
    // La ruta donde guardas tus imágenes (¡debe tener permisos de escritura!)
    $ruta_subida = "../../uploads/texanas/"; 

    for ($i = 0; $i < count($imagenes_form); $i++) {
        
        $nombre_input_file = $imagenes_form[$i]; // ej: 'imgTexana1'
        
        // Verificamos si se subió un archivo para este input
        if (isset($_FILES[$nombre_input_file]) && $_FILES[$nombre_input_file]['error'] == 0) {
            
            // (Opcional: Borrar la imagen antigua del servidor aquí)

            // Creamos un nombre único para la nueva imagen
            $nombre_archivo_nuevo = uniqid() . '-' . basename($_FILES[$nombre_input_file]['name']);
            $ruta_completa = $ruta_subida . $nombre_archivo_nuevo;

            // Movemos el archivo
            if (move_uploaded_file($_FILES[$nombre_input_file]['tmp_name'], $ruta_completa)) {
                
                // Si se movió bien, actualizamos la BD con el nuevo nombre
                $columna_db = $columnas_db[$i]; // ej: 'Img1'
                $sql_img = "UPDATE productos SET $columna_db = ? WHERE ID_Producto = ?";
                $stmt_img = $conn->prepare($sql_img);
                $stmt_img->bind_param("si", $nombre_archivo_nuevo, $id);
                $stmt_img->execute();
                $stmt_img->close();
            } else {
                $response['warnings'][] = "Error al mover el archivo $nombre_input_file.";
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