<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guía de Tallas</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cinzel Decorative', serif;
            margin: 0;
            padding: 0;
            text-align: center;
            overflow-y: auto; 
        }

        /* Contenedor principal */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 180px; 
        }

        /* Contenedor de imágenes */
        .images {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap; 
        }

        .images img {
            width: 650px;   
            height: auto;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <header>
        <?php 
        define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
        include(ROOT_PATH . 'View/includes/header.php');
        ?>
    </header>

    <div class="container">
        <!-- Dos imágenes centradas -->
        <div class="images">
            <img src="/LaHerradura/assets/images/talla-sombrero1.jpg" alt="Sombrero 1">
            <img src="/LaHerradura/assets/images/talla-sombrero2.jpg" alt="Sombrero 2">
        </div>
    </div>

    <footer>
        <?php 
        include(ROOT_PATH . 'View/includes/footer.php');
        ?>
    </footer>
</body>
</html>