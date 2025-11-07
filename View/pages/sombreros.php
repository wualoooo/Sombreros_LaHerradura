<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sombreros</title>
    <link rel="stylesheet" href="../css/style-Sombreros.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>
    

    <header>
        <?php 
        include ('../includes/header.php');
        ?>
    </header>
    
    <div class="container">
        <div class="item" id="space"></div>
        <div class="item" id="Sombreros">
            <div class="container2">


                <?php 
                include ('../../Model/conexion.php');

                    $sql = "SELECT id_sombrero, Img1, Nombre, Precio FROM sombreros";
                    $result = $conn->query($sql);
                    while ($row = $result -> fetch_assoc()){
                        echo("

                            <div class='card abrir-modal-vp' data-id='" . $row["id_sombrero"] . "'>
                                <div class='img-sombrero'>
                                    <img src='../../uploads/sombreros/".$row["Img1"]."'>
                                </div>
                                <div class='vista-rapida'>
                                <span>Ver más detalles</span>
                                </div>
                                <div class='text-sombrero'>
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
        include('../modals/modal-ViewProduct.php')
        /*include('../../uploads/sombreros/')*/
        ?>

    <div class="item" id="space">
        <img id="wpp" src="../images/WhatsApp.png" alt="WhatsApp">
    </div>
    <div class="item" id="Filtros">
        
    </div>
    <div class="item" id="Espacio"></div>
    </div>


    <footer>
        <?php 
        include('../includes/footer.php')
        ?>
    </footer>
    <script src="../../public/viewSombreros.js"></script>
</body>
</html>