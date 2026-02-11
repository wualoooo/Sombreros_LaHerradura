<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// 2. CORRECCIÓN DE RUTA (3 Niveles hacia atrás)
$ruta_conexion = '../../../Model/conexion.php';

if (!file_exists($ruta_conexion)) {
    echo json_encode(['success' => false, 'message' => 'Error Crítico: No se encuentra el archivo conexion.php en la ruta: ' . $ruta_conexion]);
    exit;
}

require($ruta_conexion);

$response = ['success' => false, 'message' => 'Error desconocido'];

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Acceso no permitido. Usa POST.");
    }

    if (empty($_POST['NombreColor'])) {
        throw new Exception("El campo Nombre es obligatorio.");
    }

    $nombre = trim($_POST['NombreColor']);
    $producto = trim($_POST['ProductoColor']);

    // Validación de solo letras y espacios
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
        throw new Exception("El nombre solo puede contener letras y espacios.");
    }

    if (strlen($nombre) < 3) {
        throw new Exception("El nombre es muy corto.");
    }

    // Insertar
    $sql = "INSERT INTO colores (Nombre, Producto) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Error SQL: " . $conn->error);
    }

    $stmt->bind_param("ss", $nombre, $producto);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "¡Color registrado con éxito!";
    } else {
        if ($conn->errno == 1062) {
            throw new Exception("Ese Color ya existe.");
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