<?php
session_start();
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '../');
require(ROOT_PATH . 'Model/conexion.php');

header('Content-Type: application/json');

// Verificar sesión
if (!isset($_SESSION['user_email']) || !isset($_SESSION['id_usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No hay sesión activa.']);
    exit;
}

$idUsuario = $_SESSION['id_usuario'];
$uploadDir = ROOT_PATH . 'uploads/users/';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {
    $file = $_FILES['profile_pic'];

    // Validaciones básicas
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'Error al subir el archivo. Código: ' . $file['error']]);
        exit;
    }

    // Validar extensión
    $allowedExts = ['jpg', 'jpeg', 'png', 'webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExts)) {
        echo json_encode(['success' => false, 'message' => 'Formato no permitido. Solo JPG, PNG o WEBP.']);
        exit;
    }

    // Validar tamaño (ej: max 2MB)
    if ($file['size'] > 2 * 1024 * 1024) {
        echo json_encode(['success' => false, 'message' => 'La imagen es muy grande (Máx 2MB).']);
        exit;
    }

    // Procesar archivo
    $newFileName = 'user_' . $idUsuario . '_' . time() . '.' . $ext;
    $destPath = $uploadDir . $newFileName;

    // Asegurar directorio
    if (!file_exists($uploadDir)) { mkdir($uploadDir, 0755, true); }

    if (move_uploaded_file($file['tmp_name'], $destPath)) {
        
        // Borrar imagen anterior si existe
        $sqlOld = "SELECT foto_perfil FROM usuarios WHERE id_usuario = ?";
        $stmtOld = $conn->prepare($sqlOld);
        $stmtOld->bind_param("i", $idUsuario);
        $stmtOld->execute();
        $stmtOld->bind_result($oldPic);
        $stmtOld->fetch();
        $stmtOld->close();
        
        if ($oldPic && file_exists($uploadDir . $oldPic)) {
            unlink($uploadDir . $oldPic);
        }

        // Actualizar BD
        $sqlUpdate = "UPDATE usuarios SET foto_perfil = ? WHERE id_usuario = ?";
        $stmtUp = $conn->prepare($sqlUpdate);
        $stmtUp->bind_param("si", $newFileName, $idUsuario);

        if ($stmtUp->execute()) {
            // Actualizar SESIÓN para que se refleje sin reloguear
            $_SESSION['user_foto'] = $newFileName;

            echo json_encode([
                'success' => true,
                'message' => 'Foto actualizada correctamente.',
                'newSrc' => '/LaHerradura/uploads/users/' . $newFileName
            ]);
        } else {
            unlink($destPath); // Borrar si falló BD
            echo json_encode(['success' => false, 'message' => 'Error al actualizar base de datos.']);
        }
        $stmtUp->close();

    } else {
        echo json_encode(['success' => false, 'message' => 'Error al mover el archivo al servidor.']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud inválida.']);
}
$conn->close();
?>