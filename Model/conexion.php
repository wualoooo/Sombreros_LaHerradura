<?php
    $BD = "LaHerradura";
    $Servidor = "localhost";
    $usuario = "root";
    $pass = "";

    $conn = mysqli_connect($Servidor, $usuario, $pass, $BD);
    /*echo ("La conexion fue establecida");*/

    if ($conn -> connect_error){
        die("Lo siento no hay conexion".mysqli_connect_error());
    }
?>