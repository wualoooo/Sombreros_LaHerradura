<?php 
include ('../Model/conexion.php');

    // Preparamos la respuesta JSON por defecto
$response = ['status' => 'error', 'message' => 'Correo o contraseña incorrectos.'];

$email = $_POST['Correo'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    $response['message'] = 'Por favor, completa todos los campos.';
    echo json_encode($response);
    $conn->close();
    exit;
}

// --- 1. PRIMERO: Buscar en la tabla de Administradores ---
$sql_admin = "SELECT Contra FROM administradores WHERE Correo = ?";
$stmt_admin = $conn->prepare($sql_admin);
$stmt_admin->bind_param("s", $email);
$stmt_admin->execute();
$result_admin = $stmt_admin->get_result();

if ($result_admin->num_rows === 1) {
    $admin = $result_admin->fetch_assoc();
    
    // Verificamos la contraseña del admin
    if (password_verify($password, $admin['Contra'])) {
        // ¡Es Admin!
        $_SESSION['user_email'] = $email;
        $_SESSION['user_role'] = 'admin';

        $response['status'] = 'success';
        $response['role'] = 'admin';
        unset($response['message']); // Quitamos el mensaje de error

        // Enviamos la respuesta y terminamos el script
        header('Content-Type: application/json');
        echo json_encode($response);
        $stmt_admin->close();
        $conn->close();
        exit; // ¡Importante! Salir aquí
    }
}
$stmt_admin->close(); // Cerramos la consulta de admin


// --- 2. SEGUNDO: Si no es Admin, buscar en la tabla de Usuarios ---
// (Solo llega aquí si no fue un admin exitoso)
$sql_user = "SELECT password FROM usuarios WHERE email = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("s", $email);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows === 1) {
    $user = $result_user->fetch_assoc();

    // Verificamos la contraseña del usuario
    if (password_verify($password, $user['password'])) {
        // ¡Es Usuario!
        $_SESSION['user_email'] = $email;
        $_SESSION['user_role'] = 'user';

        $response['status'] = 'success';
        $response['role'] = 'user';
        unset($response['message']); // Quitamos el mensaje de error
    }
    // Si la contraseña no coincide, se queda el mensaje de error por defecto
}
// Si el email no se encontró, se queda el mensaje de error por defecto

$stmt_user->close();
$conn->close();

// Devolvemos la respuesta JSON final (sea éxito de usuario o error)
header('Content-Type: application/json');
echo json_encode($response);

?>