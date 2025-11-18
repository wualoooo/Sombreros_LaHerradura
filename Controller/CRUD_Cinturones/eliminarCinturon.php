<?php
// --- 1. CONEXIÓN A LA BD ---
// Asegúrate de que esta ruta sea correcta
include '../../Model/conexion.php'; 

// Preparamos una respuesta JSON
header('Content-Type: application/json');
$response = ['success' => false, 'error' => 'Error desconocido.'];

// --- 2. VERIFICACIÓN ---
// Solo continuamos si los datos se enviaron por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // --- 3. OBTENER EL ID ---
    // El JavaScript envía el ID en un FormData
    $id = $_POST['id'];

    if (empty($id)) {
        $response['error'] = 'Error: No se recibió ningún ID.';
        echo json_encode($response);
        exit;
    }

    // --- 4. (NUEVO) OBTENER NOMBRES DE ARCHIVOS ANTES DE BORRAR ---
    // Preparamos un SELECT para saber qué archivos borrar del servidor
    $sql_select = "SELECT Img1, Img2, Img3, Img4 FROM cinturones WHERE id_cinturon = ?";
    $stmt_select = $conn->prepare($sql_select);
    
    if($stmt_select === false) {
        $response['error'] = 'Error al preparar la consulta SELECT: ' . $conn->error;
        echo json_encode($response);
        $conn->close();
        exit;
    }

    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $row = $result->fetch_assoc();
    $stmt_select->close();

    // --- 5. (NUEVO) BORRAR ARCHIVOS FÍSICOS DEL SERVIDOR ---
    if ($row) { // Solo si se encontró el registro
        
        // IMPORTANTE: Verifica que esta ruta sea correcta
        // Desde /Controller/, debería ser '../' para subir un nivel
        $ruta_base = "../../uploads/cinturones/"; 
        
        // Creamos un array con los nombres de las imágenes
        $imagenes_a_borrar = [
            $row['Img1'], 
            $row['Img2'], 
            $row['Img3'], 
            $row['Img4']
        ];

        foreach ($imagenes_a_borrar as $nombre_img) {
            // Verificamos que el nombre no esté vacío
            if (!empty($nombre_img)) {
                $ruta_completa = $ruta_base . $nombre_img;
                
                // Verificamos si el archivo existe en el servidor
                if (file_exists($ruta_completa)) {
                    unlink($ruta_completa); // ¡Borra el archivo!
                }
            }
        }
    }

    // --- 6. (AHORA ES PASO 6) PREPARAR Y EJECUTAR EL DELETE ---
    // Usamos el nombre de tu tabla "sombreros" y tu columna "id_sombrero"
    $sql_delete = "DELETE FROM cinturones WHERE id_cinturon = ?";
    
    $stmt_delete = $conn->prepare($sql_delete);

    // Verificamos si la preparación falló
    if ($stmt_delete === false) {
        $response['error'] = 'Error al preparar la consulta: ' . $conn->error;
        echo json_encode($response);
        $conn->close();
        exit;
    }

    // 'i' significa que el ID es un tipo 'integer' (entero)
    $stmt_delete->bind_param("i", $id);

    // --- 7. (AHORA ES PASO 7) VERIFICAR ÉXITO ---
    if ($stmt_delete->execute()) {
        // Si el 'DELETE' funcionó
        $response['success'] = true;
        $response['error'] = '';
    } else {
        // Si el 'DELETE' falló
        $response['error'] = 'Error al ejecutar el borrado: ' . $stmt_delete->error;
    }

    $stmt_delete->close();

} else {
    // Si alguien intenta acceder al script sin POST
    $response['error'] = 'Método no permitido.';
}

// --- 8. (AHORA ES PASO 8) ENVIAR RESPUESTA Y CERRAR ---
$conn->close();
echo json_encode($response);
?>