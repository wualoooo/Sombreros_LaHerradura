<?php 
// 1. ACTIVAR ERRORES (Solo para depurar, luego lo pones en 0)
error_reporting(E_ALL);
ini_set('display_errors', 1); // <--- CAMBIADO A 1 PARA VER EL ERROR SI FALLA
header('Content-Type: application/json');

// 2. CORRECCIÓN DE RUTA (3 Niveles hacia atrás)
// Verifica si tu archivo conexion.php está realmente en Model/conexion.php desde la raíz
$ruta_conexion = '../../../Model/conexion.php';

if (!file_exists($ruta_conexion)) {
    // Si no encuentra el archivo, detiene todo y avisa
    echo json_encode(['success' => false, 'message' => 'Error Crítico: No se encuentra el archivo conexion.php en la ruta: ' . $ruta_conexion]);
    exit;
}

require($ruta_conexion);

$response = ['success' => false, 'message' => 'Error desconocido'];

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Acceso no permitido. Usa POST.");
    }

    if (empty($_POST['NombreCopa'])) {
        throw new Exception("El campo Nombre es obligatorio.");
    }

    $nombre = trim($_POST['NombreCopa']);

    // Validación de solo letras y espacios
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
        throw new Exception("El nombre solo puede contener letras y espacios.");
    }

    if (strlen($nombre) < 3) {
        throw new Exception("El nombre es muy corto.");
    }

    // Insertar
    $sql = "INSERT INTO copas (Nombre) VALUES (?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Error SQL: " . $conn->error);
    }

    $stmt->bind_param("s", $nombre);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "¡Copa registrada con éxito!";
    } else {
        if ($conn->errno == 1062) {
            throw new Exception("Esa Copa ya existe.");
        } else {
            throw new Exception("Error al guardar: " . $stmt->error);
        }
    }

    $stmt->close();

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>