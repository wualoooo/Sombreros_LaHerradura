<?php
require_once '../../Model/conexion.php'; 

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    //Recepción y validación inicial de los datos
    $id = $_POST['id'] ?? null;
    $tipo = $_POST['tipo'] ?? null;

    if ($id && $tipo) {
        
        //Preparación del procedimiento almacenado
        $sql_delete = "CALL EliminarExtra(?, ?)";
        $stmt_delete = $conn->prepare($sql_delete);

        if ($stmt_delete === false) {
            echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta: ' . $conn->error]);
            $conn->close();
            exit;
        }

        //Ejecución y manejo de errores
        $stmt_delete->bind_param("is", $id, $tipo);
        if ($stmt_delete->execute()) {
            echo json_encode(['status' => 'success', 'message' => ucfirst($tipo) . ' eliminado correctamente.']);
        } else {
            if ($stmt_delete->errno == 1451) {
                echo json_encode(['status' => 'error', 'message' => 'No se puede eliminar este ' . $tipo . ' porque ya está siendo usado por un producto.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error de base de datos: ' . $stmt_delete->error]);
            }
        }
        $stmt_delete->close();
        
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Faltan datos para realizar la acción.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
}

$conn->close();
?>