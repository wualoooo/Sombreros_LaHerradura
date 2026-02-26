<?php 
error_reporting(E_ALL);
ini_set('display_errors', 0); 
header('Content-Type: application/json');

require('../../Model/conexion.php');

$response = ['success' => false, 'message' => 'Error desconocido'];
$imagenes_subidas = [];

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Acceso no permitido.");
    }

    if (empty($_POST['NombreBotin']) || empty($_POST['PrecioBotin']) || empty($_POST['SKUBotin'])) {
        throw new Exception("Faltan datos obligatorios (SKU, Nombre o Precio).");
    }

    $carpeta_destino = "../../uploads/botines/";
    if (!file_exists($carpeta_destino)) {
        mkdir($carpeta_destino, 0777, true);
    }

    function procesarImagen($key, $destino, &$lista_borrado) {
        if (!isset($_FILES[$key]) || $_FILES[$key]['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir la imagen $key.");
        }
        $ext = strtolower(pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'heif', 'avif'])) {
            throw new Exception("Formato inválido en $key.");
        }
        $nuevo_nombre = uniqid('ImgBotin_') . '.' . $ext;
        $ruta = $destino . $nuevo_nombre;

        if (move_uploaded_file($_FILES[$key]['tmp_name'], $ruta)) {
            $lista_borrado[] = $ruta; 
            return $nuevo_nombre;
        } else {
            throw new Exception("No se pudo mover la imagen $key.");
        }
    }

    $img1 = procesarImagen('imgBotin1', $carpeta_destino, $imagenes_subidas);
    $img2 = procesarImagen('imgBotin2', $carpeta_destino, $imagenes_subidas);
    $img3 = procesarImagen('imgBotin3', $carpeta_destino, $imagenes_subidas);
    $img4 = procesarImagen('imgBotin4', $carpeta_destino, $imagenes_subidas);

    $SKU = trim($_POST['SKUBotin']);
    $Nombre = trim($_POST['NombreBotin']);
    $Talla = $_POST['TallaBotin'];
    $Material = trim($_POST['MaterialBotin']);
    $Suela = $_POST['SuelaBotin'];
    $Precio = $_POST['PrecioBotin'];
    
    // INSERTAR EN BD (Incluyendo SKU y Estado)
    $sql = "INSERT INTO botines (SKU, Nombre, Talla, Material, Suela, Precio, Estado, Img1, Img2, Img3, Img4) 
            VALUES (?, ?, ?, ?, ?, ?, 1, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error en la consulta SQL: " . $conn->error);
    }

    // "ssdiidssss" = 2 String, 1 Double, 2 Int, 1 Double, 4 String
    $stmt->bind_param("ssdiidssss", 
        $SKU, $Nombre, $Talla, $Material, $Suela, $Precio,
        $img1, $img2, $img3, $img4
    );

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Botín registrado correctamente.';
    } else {
        throw new Exception("Error al guardar en BD: " . $stmt->error);
    }

    $stmt->close();

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    foreach ($imagenes_subidas as $ruta_borrar) {
        if (file_exists($ruta_borrar)) {
            unlink($ruta_borrar);
        }
    }
}

$conn->close();
echo json_encode($response);
?>