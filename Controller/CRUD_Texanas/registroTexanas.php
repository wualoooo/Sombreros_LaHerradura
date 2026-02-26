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

    // 1. VALIDACIONES BÁSICAS (Agregamos SKU)
    if (empty($_POST['NombreTexana']) || empty($_POST['PrecioTexana']) || empty($_POST['SKUTexana'])) {
        throw new Exception("Faltan datos obligatorios (SKU, Nombre o Precio).");
    }

    $carpeta_destino = "../../uploads/texanas/";
    if (!file_exists($carpeta_destino)) {
        mkdir($carpeta_destino, 0777, true);
    }

    // Función interna para manejar la subida y el rastreo
    function procesarImagen($key, $destino, &$lista_borrado) {
        if (!isset($_FILES[$key]) || $_FILES[$key]['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir la imagen $key.");
        }
        
        $ext = strtolower(pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'heif', 'avif'])) {
            throw new Exception("Formato inválido en $key.");
        }

        $nuevo_nombre = uniqid('ImgTexana_') . '.' . $ext;
        $ruta = $destino . $nuevo_nombre;

        if (move_uploaded_file($_FILES[$key]['tmp_name'], $ruta)) {
            $lista_borrado[] = $ruta; 
            return $nuevo_nombre;
        } else {
            throw new Exception("No se pudo mover la imagen $key.");
        }
    }

    // INTENTAR SUBIR LAS 4 IMÁGENES
    $img1 = procesarImagen('imgTexana1', $carpeta_destino, $imagenes_subidas);
    $img2 = procesarImagen('imgTexana2', $carpeta_destino, $imagenes_subidas);
    $img3 = procesarImagen('imgTexana3', $carpeta_destino, $imagenes_subidas);
    $img4 = procesarImagen('imgTexana4', $carpeta_destino, $imagenes_subidas);

    // PREPARAR DATOS PARA BD
    $SKU = trim($_POST['SKUTexana']);
    $Nombre = trim($_POST['NombreTexana']);
    $Color = $_POST['ColorTexana'];
    $Horma = $_POST['HormaTexana'];
    $Copa = $_POST['CopaTexana'];
    $Tam_Copa = $_POST['TamañoCopaTexana'];
    $Tam_Ala = $_POST['TamañoAlaTexana'];
    $Material = trim($_POST['MaterialTexana']);
    $Precio = $_POST['PrecioTexana'];

    // PROCESAR TALLAS
    $tallas_texto = "Unitalla";
    if (isset($_POST['tallas_disponibles']) && is_array($_POST['tallas_disponibles'])) {
        $tallas_texto = implode(",", $_POST['tallas_disponibles']); 
    }

    // INSERTAR EN BD (15 Columnas = 14 variables dinámicas + el "1" directo en Estado)
    // Asumimos que la tabla "texanas" tiene la misma estructura que "sombreros"
    $sql = "INSERT INTO texanas (SKU, Nombre, Color, Horma, Copa, Tam_Copa, Tam_ala, Material, Precio, Tallas, Estado, Img1, Img2, Img3, Img4) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error en la consulta SQL: " . $conn->error);
    }

    // Vincular variables (ssiiiddidsssss = 14 parámetros exactos para los '?')
    $stmt->bind_param("ssiiiddidsssss", 
        $SKU, $Nombre, $Color, $Horma, $Copa, $Tam_Copa, $Tam_Ala, $Material, $Precio, $tallas_texto, 
        $img1, $img2, $img3, $img4
    );

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Texana registrada correctamente.';
    } else {
        throw new Exception("Error al guardar en BD: " . $stmt->error);
    }

    $stmt->close();

} catch (Exception $e) {
    // SI ALGO FALLÓ (En subida o en BD)
    $response['message'] = $e->getMessage();

    // ROLLBACK DE IMÁGENES
    foreach ($imagenes_subidas as $ruta_borrar) {
        if (file_exists($ruta_borrar)) {
            unlink($ruta_borrar);
        }
    }
}

$conn->close();
echo json_encode($response);
?>