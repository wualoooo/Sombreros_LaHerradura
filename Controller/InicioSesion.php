<?php 
// 1. CONFIGURACIÓN INICIAL (Obligatoria para JSON y Sesiones)
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 0); // Oculta errores de PHP para que no rompan el JSON
header('Content-Type: application/json'); // Avisamos al navegador que respondemos JSON

include ('../Model/conexion.php');

// Respuesta por defecto
$response = ['status' => 'error', 'message' => 'Correo o contraseña incorrectos.'];

try {
    // 2. RECIBIR DATOS
    // Nota: Usamos $_POST['correo'] (minúscula) porque en el HTML el name="correo"
    // Si tu input HTML tiene name="Correo" con mayúscula, cámbialo aquí.
    $email = $_POST['Correo'] ?? ''; 
    $password = $_POST['Password'] ?? '';

    if (empty($email) || empty($password)) {
        $response['message'] = 'Por favor, completa todos los campos.';
        echo json_encode($response);
        exit;
    }

    // --- 3. PRIMERO: Buscar en ADMINISTRADORES ---
    // Según tu código: Tabla 'administradores', columnas 'Correo' y 'Contra'
    $sql_admin = "SELECT id_admin, Nombre, Contra FROM administradores WHERE Correo = ?";
    $stmt_admin = $conn->prepare($sql_admin);
    
    if($stmt_admin) {
        $stmt_admin->bind_param("s", $email);
        $stmt_admin->execute();
        $result_admin = $stmt_admin->get_result();

        if ($result_admin->num_rows === 1) {
            $admin = $result_admin->fetch_assoc();
            
            // Verificamos contraseña encriptada
            if (password_verify($password, $admin['Contra'])) {
                // ¡Es Admin!
                $_SESSION['id_usuario'] = $admin['id_admin']; // Guardamos ID
                $_SESSION['nombre'] = $admin['Nombre'];
                $_SESSION['user_email'] = $email;
                $_SESSION['user_role'] = 'admin';

                $response['status'] = 'success';
                $response['role'] = 'admin';
                $response['message'] = 'Bienvenido Administrador';
                
                // Responder y salir
                echo json_encode($response);
                $stmt_admin->close();
                $conn->close();
                exit; 
            }
        }
        $stmt_admin->close();
    }

    // --- 4. SEGUNDO: Buscar en USUARIOS ---
    // (Solo llega aquí si no encontró admin)
    // Según tu código: Tabla 'usuarios', columnas 'email' y 'password'
    $sql_user = "SELECT id_usuario, Nombre, password FROM usuarios WHERE email = ?";
    $stmt_user = $conn->prepare($sql_user);

    if($stmt_user) {
        $stmt_user->bind_param("s", $email);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        if ($result_user->num_rows === 1) {
            $user = $result_user->fetch_assoc();

            // Verificamos contraseña encriptada
            if (password_verify($password, $user['password'])) {
                // ¡Es Usuario!
                $_SESSION['id_usuario'] = $user['id_usuario'];
                $_SESSION['nombre'] = $user['Nombre'];
                $_SESSION['user_email'] = $email;
                $_SESSION['user_role'] = 'user';

                $response['status'] = 'success';
                $response['role'] = 'user';
                $response['message'] = 'Bienvenido ' . $user['Nombre'];
                $response['nombre'] = $user['Nombre']; // Para mostrarlo en el JS
            }
        }
        $stmt_user->close();
    }

} catch (Exception $e) {
    $response['message'] = 'Error del servidor: ' . $e->getMessage();
}

$conn->close();

// 5. ENVIAR RESPUESTA FINAL
echo json_encode($response);
?>