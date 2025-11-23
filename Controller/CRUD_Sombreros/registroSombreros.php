<?php 
// Desactivar salida de errores HTML para no romper el JSON
error_reporting(E_ALL);
ini_set('display_errors', 0); 
header('Content-Type: application/json'); // Decimos que respondemos JSON

require('../../Model/conexion.php');

$response = ['success' => false, 'message' => 'Error desconocido'];
$imagenes_subidas = [];

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Acceso no permitido.");
    }

    // 1. VALIDACIONES BÁSICAS
    if (empty($_POST['NombreSombrero']) || empty($_POST['PrecioSombrero'])) {
        throw new Exception("Faltan datos obligatorios.");
    }

    $carpeta_destino = "../../uploads/sombreros/";
    if (!file_exists($carpeta_destino)) {
        mkdir($carpeta_destino, 0777, true);
    }

    // Función interna para manejar la subida y el rastreo
    function procesarImagen($key, $destino, &$lista_borrado) {
        if (!isset($_FILES[$key]) || $_FILES[$key]['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir la imagen $key.");
        }
        
        $ext = strtolower(pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            throw new Exception("Formato inválido en $key.");
        }

        $nuevo_nombre = uniqid('ImgSombrero_') . '.' . $ext;
        $ruta = $destino . $nuevo_nombre;

        if (move_uploaded_file($_FILES[$key]['tmp_name'], $ruta)) {
            // AGREGAMOS A LA LISTA DE "COSAS POR BORRAR SI FALLA ALGO"
            $lista_borrado[] = $ruta; 
            return $nuevo_nombre;
        } else {
            throw new Exception("No se pudo mover la imagen $key.");
        }
    }

    // 2. INTENTAR SUBIR LAS IMÁGENES
    // Si una falla, el catch atrapará el error y no se insertará nada en la BD
    $img1 = procesarImagen('imgSombrero1', $carpeta_destino, $imagenes_subidas);
    $img2 = procesarImagen('imgSombrero2', $carpeta_destino, $imagenes_subidas);
    $img3 = procesarImagen('imgSombrero3', $carpeta_destino, $imagenes_subidas);
    $img4 = procesarImagen('imgSombrero4', $carpeta_destino, $imagenes_subidas);

    // 3. PREPARAR DATOS PARA BD
    $Nombre = trim($_POST['NombreSombrero']);
    $Color = trim($_POST['ColorSombrero']);
    $Horma = $_POST['HormaSombrero'];
    $Copa = $_POST['CopaSombrero'];
    $Tam_Copa = $_POST['TamañoCopaSombrero'];
    $Tam_Ala = $_POST['TamañoAlaSombrero'];
    $Material = trim($_POST['MaterialSombrero']);
    $Precio = $_POST['PrecioSombrero'];

    // 4. INSERTAR EN BD
    $sql = "INSERT INTO sombreros (Nombre, Color, Horma, Copa, Tam_Copa, Tam_ala, Material, Precio, Img1, Img2, Img3, Img4) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error en la consulta SQL: " . $conn->error);
    }

    $stmt->bind_param("ssssddsdssss", 
        $Nombre, $Color, $Horma, $Copa, $Tam_Copa, $Tam_Ala, $Material, $Precio, 
        $img1, $img2, $img3, $img4
    );

    if ($stmt->execute()) {
        // ¡ÉXITO TOTAL!
        $response['success'] = true;
        $response['message'] = 'Sombrero registrado correctamente.';
    } else {
        throw new Exception("Error al guardar en BD: " . $stmt->error);
    }

    $stmt->close();

} catch (Exception $e) {
    // SI ALGO FALLÓ (En subida o en BD):
    $response['message'] = $e->getMessage();

    // *** ROLLBACK DE IMÁGENES ***
    // Como la BD falló, borramos las imágenes que acabamos de subir para no dejar basura.
    foreach ($imagenes_subidas as $ruta_borrar) {
        if (file_exists($ruta_borrar)) {
            unlink($ruta_borrar);
        }
    }
}

$conn->close();
echo json_encode($response);
?>