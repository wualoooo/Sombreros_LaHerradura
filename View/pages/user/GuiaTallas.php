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

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 180px; 
        }

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

        /* Panel lateral de botones */
        .buttons {
            display: flex;
            flex-direction: column; /* uno debajo del otro */
            align-items: flex-end;  /* alineados a la derecha */
            position: fixed;        /* flotando en la pantalla */
            right: 20px;
            top: 200px;             /* ajusta según tu diseño */
            gap: 15px;              /* espacio entre botones */
        }

        /* Estilo de botones */
        .btn-editar {
            width: 180px;           /* mismo tamaño */
            text-align: center;
            color: #fff;            /* letra blanca */
            border-radius: 8px;
            font-size: 1rem;
            padding: 12px 20px;
            border: none;
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            cursor: pointer;
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.1),
                0 2px 4px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            font-weight: 500;
        }

        .btn-editar:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 6px 12px rgba(0, 0, 0, 0.15),
                0 4px 8px rgba(0, 0, 0, 0.1),
                0 0 15px rgba(255, 215, 0, 0.4);
            background: linear-gradient(135deg, #ffc107 0%, #ffd700 100%);
            color: #fff;
        }

        .btn-editar:active {
            transform: translateY(0);
            box-shadow: 
                0 2px 4px rgba(0, 0, 0, 0.1),
                0 1px 2px rgba(0, 0, 0, 0.08);
            background: linear-gradient(135deg, #ffd700 0%, #ffc107 100%);
        }

        .btn-editar::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(255, 255, 255, 0.3), 
                transparent);
            transition: left 0.5s;
        }

        .btn-editar:hover::before {
            left: 100%;
        }

        /* Botón activo */
        .btn-activo {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%); /* verde elegante */
            color: #fff;
            box-shadow: 
                0 6px 12px rgba(0, 0, 0, 0.2),
                0 0 15px rgba(255, 215, 0, 0.4);
        }
    </style>
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