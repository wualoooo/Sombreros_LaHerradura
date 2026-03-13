<?php
session_start();
header('Content-Type: application/json');

require "../Model/conexion.php";

$input = json_decode(file_get_contents('php://input'), true);
$id_token = $input['token'] ?? '';

if (empty($id_token)) {
    echo json_encode(['success' => false, 'message' => 'No se recibió el token.']);
    exit();
}

// Validar el token con la API de Google
$url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . $id_token;
$response = file_get_contents($url);
$user_data = json_decode($response, true);

$clientId = "143053972635-3supmue5rg7o0o3p32jkmfpl9uv9intv.apps.googleusercontent.com";

// Verificar que el token sea para tu aplicación
if (isset($user_data['aud']) && $user_data['aud'] === $clientId) {
    
    // Extraer los datos que nos dio Google
    $email = $user_data['email'];
    $nombre = $user_data['given_name'] ?? $user_data['name'];
    $apellido = $user_data['family_name'] ?? ''; // Google suele dar los apellidos juntos
    $foto_google = $user_data['picture'] ?? ''; // Extraemos la foto de Google

    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión a la BD.']);
        exit();
    }

    // Verificar si el correo ya está registrado en tu tabla de usuarios
    $stmt = $conn->prepare("SELECT id_usuario, Nombre, foto_perfil FROM usuarios WHERE Correo = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // 4a. El usuario YA EXISTE: Le damos acceso directamente
        $usuario_db = $resultado->fetch_assoc();
        
        // CORRECCIÓN: Usamos $usuario_db y nombramos las sesiones igual que en InicioSesion.php
        $_SESSION['id_usuario'] = $usuario_db['id_usuario'];
        $_SESSION['user_nombre'] = $usuario_db['Nombre'];
        $_SESSION['user_email'] = $email;
        $_SESSION['user_role'] = 'user';
        
        // Si el usuario tiene foto en la BD la usamos, si no, usamos la de Google
        $_SESSION['user_foto'] = !empty($usuario_db['foto_perfil']) ? $usuario_db['foto_perfil'] : $foto_google;
        
    } else {
        // 4b. El usuario NO EXISTE: Lo registramos automáticamente
        $password_vacia = ""; 

        // CORRECCIÓN: 4 columnas (Nombre, Apellidos, Correo, Contra) = 4 signos (?) = 4 letras "s"
        $stmt_insert = $conn->prepare("INSERT INTO usuarios (Nombre, Apellidos, Correo, Contra) VALUES (?, ?, ?, ?)");
        $stmt_insert->bind_param("ssss", $nombre, $apellido, $email, $password_vacia);
        
        if ($stmt_insert->execute()) {
            // Guardar variables de sesión
            $_SESSION['id_usuario'] = $conn->insert_id;
            $_SESSION['user_nombre'] = $nombre;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = 'user';
            $_SESSION['user_foto'] = $foto_google;
        } else {
            // Mostrar error real
            echo json_encode(['success' => false, 'message' => 'Error MySQL: ' . $stmt_insert->error]);
            exit();
        }
        $stmt_insert->close();
    }

    $stmt->close();
    $conn->close();

    // 5. Enviar respuesta de éxito al JavaScript
    echo json_encode(['success' => true]);

} else {
    // Si el token fue alterado o no es de tu app
    echo json_encode(['success' => false, 'message' => 'Token inválido o no autorizado.']);
}
?>