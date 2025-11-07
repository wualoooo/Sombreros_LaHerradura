<?php
require('../Model/conexion.php');

$Nombre = $_POST['Nombre'];
$Ap_Pat = $_POST['Apellido_Pat'];
$Ap_Mat = $_POST['Apellido_Mat'];
$Correo = $_POST['CorreoRegistro'];
$Contra = $_POST['password3'];

$Contra_Hash = password_hash($Contra, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuario (Nombre, Apellido_Pat, Apellido_Mat, Correo, Contra) VALUES (?, ?, ?, ?, ?)";
$insert = $conn->prepare($sql);

$insert->bind_param("sssss", $Nombre, $Ap_Pat, $Ap_Mat, $Correo, $Contra_Hash);

if ($insert->execute()) {
    echo "Los datos se insertaron correctamente";
} else {
    echo "Error: " . $insert->error;
}

$insert->close();
$conn->close();

?>