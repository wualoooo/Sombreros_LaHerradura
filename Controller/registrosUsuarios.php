<?php
// Configuración para devolver JSON siempre
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

require('../Model/conexion.php');

$response = ['success' => false, 'message' => 'Error desconocido'];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido.');
    }

    // 1. Recibir y limpiar datos
    $Nombre = trim($_POST['Nombre'] ?? '');
    $Ap_Pat = trim($_POST['Apellido_Pat'] ?? '');
    $Ap_Mat = trim($_POST['Apellido_Mat'] ?? '');
    $Correo = trim($_POST['CorreoRegistro'] ?? '');
    
    // OJO: Aquí corregimos el nombre del input que viene del HTML
    $Contra = $_POST['PasswordRegistro1'] ?? ''; 

    // 2. Validaciones básicas en Backend (Doble seguridad)
    if (empty($Nombre) || empty($Ap_Pat) || empty($Correo) || empty($Contra)) {
        throw new Exception('Por favor completa los campos obligatorios.');
    }

    if (!filter_var($Correo, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('El formato del correo no es válido.');
    }

    // 3. Verificar si el correo YA existe
    $checkEmail = $conn->prepare("SELECT id_usuario FROM usuarios WHERE Correo = ?");
    $checkEmail->bind_param("s", $Correo);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        $checkEmail->close();
        throw new Exception('Este correo ya está registrado. Intenta iniciar sesión.');
    }
    $checkEmail->close();

    // 4. Hashear contraseña e Insertar
    $Contra_Hash = password_hash($Contra, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (Nombre, Apellido_Pat, Apellido_Mat, Correo, Contra) VALUES (?, ?, ?, ?, ?)";
    $insert = $conn->prepare($sql);
    
    if (!$insert) {
        throw new Exception("Error en la preparación de la consulta: " . $conn->error);
    }

    $insert->bind_param("sssss", $Nombre, $Ap_Pat, $Ap_Mat, $Correo, $Contra_Hash);

    if ($insert->execute()) {
        $response['success'] = true;
        $response['message'] = 'Usuario registrado exitosamente.';
    } else {
        throw new Exception("Error al guardar en la base de datos.");
    }

    $insert->close();

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>