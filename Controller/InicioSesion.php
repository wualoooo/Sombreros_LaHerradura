<?php 
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 0); 
header('Content-Type: application/json');

include ('../Model/conexion.php');

$response = ['status' => 'error', 'message' => 'Correo o contraseña incorrectos.'];

try {
    $email = $_POST['Correo'] ?? ''; 
    $password = $_POST['Password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Por favor, completa todos los campos.']);
        exit;
    }

    // --- 1. BUSCAR EN ADMINISTRADORES ---
    $sql_admin = "SELECT id_admin, Nombre, Contra FROM administradores WHERE Correo = ?";
    $stmt_admin = $conn->prepare($sql_admin);
    
    if($stmt_admin) {
        $stmt_admin->bind_param("s", $email);
        $stmt_admin->execute();
        $result_admin = $stmt_admin->get_result();

        if ($result_admin->num_rows === 1) {
            $admin = $result_admin->fetch_assoc();
            
            if (password_verify($password, $admin['Contra'])) {
                // SESIÓN ADMIN
                $_SESSION['id_usuario'] = $admin['id_admin']; 
                $_SESSION['user_nombre'] = $admin['Nombre'];
                $_SESSION['user_email'] = $email;
                $_SESSION['user_role'] = 'admin';

                echo json_encode(['status' => 'success', 'role' => 'admin']);
                exit; 
            }
        }
        $stmt_admin->close();
    }

    // --- 2. BUSCAR EN USUARIOS (CLIENTES) ---
    $sql_user = "SELECT id_usuario, Nombre, Contra, foto_perfil FROM usuarios WHERE Correo = ?";
    $stmt_user = $conn->prepare($sql_user);

    if($stmt_user) {
        $stmt_user->bind_param("s", $email);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        if ($result_user->num_rows === 1) {
            $user = $result_user->fetch_assoc();

            if (password_verify($password, $user['Contra'])) {
                // SESIÓN USUARIO
                $_SESSION['id_usuario'] = $user['id_usuario'];
                $_SESSION['user_nombre'] = $user['Nombre'];
                $_SESSION['user_email'] = $email;
                $_SESSION['user_role'] = 'user';
                $_SESSION['user_foto'] = $user['foto_perfil'];

                echo json_encode(['status' => 'success', 'role' => 'user']);
                exit;
            }
        }
        $stmt_user->close();
    }

} catch (Exception $e) {
    $response['message'] = 'Error del servidor: ' . $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>