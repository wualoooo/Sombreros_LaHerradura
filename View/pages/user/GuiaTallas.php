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
    <link rel="stylesheet" href="../../css/style-guiaTallas.css">
    <link rel="shortcut icon" href="../../images/Logo_Herradura_head3.png" type="image/x-icon">
</head>
<body>
    <header>
        <?php 
        define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
        include(ROOT_PATH . 'View/includes/header.php');
        ?>
    </header>

    <!-- Panel lateral de botones -->
    <div class="buttons">
        <button class="btn-editar" id="btn-sombreros" onclick="mostrarImagenes('sombreros', this)">Sombreros</button>
        <button class="btn-editar" id="btn-cinturones" onclick="mostrarImagenes('cinturones', this)">Cinturones</button>
        <button class="btn-editar" id="btn-botines" onclick="mostrarImagenes('botines', this)">Botines</button>
    </div>

    <div class="container">
        <!-- Contenedor de imágenes -->
        <div class="images" id="galeria"></div>
    </div>

    <a href="https://wa.me/527721437028?text=Hola,%20vengo%20de%20la%20tienda%20en%20línea%20y%20necesito%20información." target="_blank" id="wpp-link">
        <img id="wpp" src="/LaHerradura/View/images/WhatsApp.png" alt="WhatsApp">
        </a>

    <footer>
        <?php 
        include(ROOT_PATH . 'View/includes/footer.php');
        ?>
    </footer>

    <script>
        const imagenes = {
            sombreros: [
                "/LaHerradura/assets/images/talla-sombrero1.jpg",
                "/LaHerradura/assets/images/talla-sombrero2.jpg"
            ],
            cinturones: [
                "/LaHerradura/assets/images/talla-cinturon1.jpg",
                "/LaHerradura/assets/images/talla-cinturon2.jpg"
            ],
            botines: [
                "/LaHerradura/assets/images/talla-botin1.jpg",
                "/LaHerradura/assets/images/talla-botin2.jpg"
            ]
        };

        function mostrarImagenes(categoria, boton) {
            const galeria = document.getElementById("galeria");
            galeria.innerHTML = "";
            imagenes[categoria].forEach(src => {
                const img = document.createElement("img");
                img.src = src;
                galeria.appendChild(img);
            });

            // Quitar activo de todos
            document.querySelectorAll(".btn-editar").forEach(btn => btn.classList.remove("btn-activo"));
            // Activar el botón actual
            boton.classList.add("btn-activo");
        }

        // Mostrar sombreros por defecto y marcar botón activo
        mostrarImagenes("sombreros", document.getElementById("btn-sombreros"));
    </script>
</body>
</html>