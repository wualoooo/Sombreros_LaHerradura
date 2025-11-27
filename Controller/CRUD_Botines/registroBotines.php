<?php 
require('../../Model/conexion.php');

function subirImagen($clave_archivo, $carpeta_destino) {
    if (isset($_FILES[$clave_archivo]) && $_FILES[$clave_archivo]['error'] == 0) {
        
        $archivo_temporal = $_FILES[$clave_archivo]['tmp_name'];
        $nombre_original = $_FILES[$clave_archivo]['name'];

        $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
        $nuevo_nombre = uniqid('ImgBotin_') . '.' . $extension;
        
        $ruta_completa = $carpeta_destino . $nuevo_nombre;
        
        if (move_uploaded_file($archivo_temporal, $ruta_completa)) {
            return $nuevo_nombre;
        } else {
            return null;
        }
    } else {
        return null;
    }
}

$Nombre = $_POST['NombreBotin'];
$Talla = $_POST['TallaBotin'];
$Material = $_POST['MaterialBotin'];
$Suela = $_POST['SuelaBotin'];
$Precio = $_POST['PrecioBotin'];
$carpeta_destino = "../../uploads/botines/";

$Img1_nombre_db = subirImagen('imgBotin1', $carpeta_destino);
$Img2_nombre_db = subirImagen('imgBotin2', $carpeta_destino);
$Img3_nombre_db = subirImagen('imgBotin3', $carpeta_destino);
$Img4_nombre_db = subirImagen('imgBotin4', $carpeta_destino);

$sql = "INSERT INTO botines (Nombre, Talla, Material, Suela, Precio, Img1, Img2, Img3, Img4) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$insert = $conn->prepare($sql);

$insert->bind_param(
    "sssssssss",
    $Nombre, $Talla, $Material, $Suela, $Precio, $Img1_nombre_db,  $Img2_nombre_db, $Img3_nombre_db,  $Img4_nombre_db);

if ($insert->execute()) {
    echo "Los datos se insertaron correctamente";
} else {
    echo "Error: " . $insert->error;
}

$insert->close();
$conn->close();

?>