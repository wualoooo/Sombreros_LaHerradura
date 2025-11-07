<?php
require('../Model/conexion.php');

$Nombre = $_POST['NombreAdmin'];
$Ap_Pat = $_POST['Apellido_PatAdmin'];
$Ap_Mat = $_POST['Apellido_MatAdmin'];
$Correo = $_POST['CorreoRegistroAdmin'];
$Contra = $_POST['passwordAdmin2'];
$Rol = $_POST['RolAdmin'];

$Contra_Hash = password_hash($Contra, PASSWORD_DEFAULT);

$sql = "INSERT INTO administradores (Nombre, Apellido_Pat, Apellido_Mat, Correo, Contra, Rol) VALUES (?, ?, ?, ?, ?, ?)";
$insert = $conn->prepare($sql);

$insert->bind_param("ssssss", $Nombre, $Ap_Pat, $Ap_Mat, $Correo, $Contra_Hash, $Rol);

if ($insert->execute()) {
    echo "Los datos se insertaron correctamente";
} else {
    echo "Error: " . $insert->error;
}

$insert->close();
$conn->close();

?>