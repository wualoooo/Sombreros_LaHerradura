<?php
include '../../Model/conexion.php'; 

header('Content-Type: application/json');
$response = ['success' => false, 'error' => 'Error desconocido.'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'];

    if (empty($id)) {
        $response['error'] = 'Error: No se recibió ningún ID.';
        echo json_encode($response);
        exit;
    }

    //OBTENER NOMBRES DE ARCHIVOS A BORRAR
    $sql_select = "SELECT Img1, Img2, Img3, Img4 FROM sombreros WHERE id_sombrero = ?";
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

    // BORRAR ARCHIVOS
    if ($row) {
        $ruta_base = "../../uploads/sombreros/"; 

        // ARRAY DE LAS IMAGENES
        $imagenes_a_borrar = [
            $row['Img1'], 
            $row['Img2'], 
            $row['Img3'], 
            $row['Img4']
        ];

        foreach ($imagenes_a_borrar as $nombre_img) {
            if (!empty($nombre_img)) {
                $ruta_completa = $ruta_base . $nombre_img;
                if (file_exists($ruta_completa)) {
                    unlink($ruta_completa);
                }
            }
        }
    }

    // PREPARAR LA CONSULTA PARA ELIMINAR
    $sql = "DELETE FROM sombreros WHERE id_sombrero = ?";
    
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $response['error'] = 'Error al preparar la consulta: ' . $conn->error;
        echo json_encode($response);
        $conn->close();
        exit;
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['error'] = '';
    } else {
        $response['error'] = 'Error al ejecutar el borrado: ' . $stmt->error;
    }

    $stmt->close();

} else {
    $response['error'] = 'Método no permitido.';
}
$conn->close();
echo json_encode($response);
?>