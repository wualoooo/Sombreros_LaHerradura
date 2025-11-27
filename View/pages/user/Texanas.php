<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Texanas</title>
    <link rel="stylesheet" href="/LaHerradura/View/css/style-productos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>
    

    <header>
        <?php 
        define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
        include(ROOT_PATH . 'View/includes/header.php')
        ?>
    </header>
    
    <div class="container">
        <div class="item" id="space"></div>
        <div class="item" id="Productos">
            <div class="container2">
                <?php 
                include (ROOT_PATH . 'Model/conexion.php');

                    $sql = "SELECT id_texana, Img1, Nombre, Precio FROM texana";
                    $result = $conn->query($sql);
                    while ($row = $result -> fetch_assoc()){
                        echo("

                            <div class='card abrir-modal-vp' data-id='" . $row["id_texana"] . "'>
                                <div class='img-producto'>
                                    <img src='/LaHerradura/uploads/texanas/".$row["Img1"]."'>
                                </div>
                                <div class='vista-rapida'>
                                <span>Ver más detalles</span>
                                </div>
                                <div class='text-producto'>
                                    <h4>".$row["Nombre"]."</h4>
                                    <h5>$".$row["Precio"].".00 mxn</h5>
                                </div>
                            </div>
                        ");
                    }
                ?>

            </div>
        </div>

        <?php 
        include(ROOT_PATH . 'View/modals/modal-ViewProduct.php')

        ?>

    <div class="item" id="space">
        <img id="wpp" src="/LaHerradura/View/images/WhatsApp.png" alt="WhatsApp">
    </div>
    <div class="item" id="Filtros">
        
    </div>
    <div class="item" id="Espacio"></div>
    </div>


    <footer>
        <?php 
        include(ROOT_PATH . 'View/includes/footer.php')
        ?>
    </footer>
    <script src="/LaHerradura/public/viewTexanas.js"></script>
</body>
</html>