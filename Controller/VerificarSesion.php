<?php
session_start();
header('Content-Type: application/json');

// Verificamos si existe la variable de sesión del usuario
if (isset($_SESSION['id_usuario']) && !empty($_SESSION['id_usuario'])) {
    echo json_encode(['logueado' => true]);
} else {
    echo json_encode(['logueado' => false]);
}
?>