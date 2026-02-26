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

    if (empty($_POST['NombreCinturon']) || empty($_POST['PrecioCinturon']) || empty($_POST['SKUCinturon'])) {
        throw new Exception("Faltan datos obligatorios (SKU, Nombre o Precio).");
    }

    $carpeta_destino = "../../uploads/cinturones/";
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

        $nuevo_nombre = uniqid('ImgCinturon_') . '.' . $ext;
        $ruta = $destino . $nuevo_nombre;

        if (move_uploaded_file($_FILES[$key]['tmp_name'], $ruta)) {
            $lista_borrado[] = $ruta; 
            return $nuevo_nombre;
        } else {
            throw new Exception("No se pudo mover la imagen $key.");
        }
    }

    $img1 = procesarImagen('imgCinturon1', $carpeta_destino, $imagenes_subidas);
    $img2 = procesarImagen('imgCinturon2', $carpeta_destino, $imagenes_subidas);
    $img3 = procesarImagen('imgCinturon3', $carpeta_destino, $imagenes_subidas);
    $img4 = procesarImagen('imgCinturon4', $carpeta_destino, $imagenes_subidas);

    $SKU = trim($_POST['SKUCinturon']);
    $Nombre = trim($_POST['NombreCinturon']);
    $Precio = $_POST['PrecioCinturon'];
    $Material = $_POST['MaterialCinturon'];
    $Adorno = $_POST['AdornoCinturon'];
    $Tamano = !empty($_POST['TamañoCinturon']) ? $_POST['TamañoCinturon'] : 0; // Por si lo dejan vacío

    // PROCESAR TALLAS
    $tallas_texto = "Unitalla";
    if (isset($_POST['tallas_disponibles']) && is_array($_POST['tallas_disponibles'])) {
        $tallas_texto = implode(",", $_POST['tallas_disponibles']); 
    }

    // 12 Columnas en total
    $sql = "INSERT INTO cinturones (SKU, Nombre, Precio, Material, Adorno, Tamaño, Tallas, Estado, Img1, Img2, Img3, Img4) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error en la consulta SQL: " . $conn->error);
    }

    // "ssdiddsssss" => String, String, Double, Int, Int, Double, String, String x 4
    $stmt->bind_param("ssdiidsssss", 
        $SKU, $Nombre, $Precio, $Material, $Adorno, $Tamano, $tallas_texto, 
        $img1, $img2, $img3, $img4
    );

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Cinturón registrado correctamente.';
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