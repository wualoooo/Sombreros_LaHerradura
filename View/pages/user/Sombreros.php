<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sombreros</title>
    <link rel="stylesheet" href="/LaHerradura/View/css/style-productos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="../../images/Logo_Herradura_head3.png" type="image/x-icon">
</head>
<body>
    
    <header>
        <?php 
        define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
        include(ROOT_PATH . 'View/includes/header.php')
        ?>
    </header>
    
    <div class="container">
        
        <div class="item" id="Filtros">
            <div class="item" id="Filtros2">
                <h3>Filtros de Búsqueda</h3>

                <div class="grupo-filtro">
                    <input type="text" id="filtro-nombre" class="filtro-input" placeholder="Buscar sombrero...">
                </div>

                <div class="grupo-filtro">
                    <h4>Precio</h4>
                    <div class="rango-precios">
                        <input type="number" id="filtro-precio-min" class="filtro-input" placeholder="Min $">
                        <input type="number" id="filtro-precio-max" class="filtro-input" placeholder="Max $">
                    </div>
                </div>

                <div class="grupo-filtro">
                    <h4>Tipo de Copa/Horma</h4>
                    <div class="checkbox-list" id="filtro-copas">
                        <?php 
                            $resulthormas = $conn->query("SELECT id_horma, Nombre FROM hormas");
                            while ($row = $resulthormas->fetch_assoc()) echo "<label><input type='checkbox' class='check-copa' value='".$row['id_horma']."'>".$row['Nombre']."</label> ";
                        ?>
                    </div>
                </div>

                <div class="grupo-filtro">
                    <h4>Tallas Disponibles</h4>
                    <div class="checkbox-list" id="filtro-tallas">
                        <label><input type="checkbox" class="check-talla" value="52"> Talla 52</label>
                        <label><input type="checkbox" class="check-talla" value="52"> Talla 53</label>
                        <label><input type="checkbox" class="check-talla" value="54"> Talla 54</label>
                        <label><input type="checkbox" class="check-talla" value="55"> Talla 55</label>
                        <label><input type="checkbox" class="check-talla" value="56"> Talla 56</label>
                        <label><input type="checkbox" class="check-talla" value="57"> Talla 57</label>
                        <label><input type="checkbox" class="check-talla" value="58"> Talla 58</label>
                        <label><input type="checkbox" class="check-talla" value="59"> Talla 59</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="item" id="Productos">
            <div class="container2">
                <?php 
                    $sql = "SELECT id_sombrero, Img1, Nombre, Precio FROM sombreros WHERE Estado = 1";
                    $result = $conn->query($sql);
                    while ($row = $result -> fetch_assoc()){
                        echo("
                            <div class='card abrir-modal-vp' data-id='" . $row["id_sombrero"] . "'>
                                <div class='img-producto'>
                                    <img src='/LaHerradura/uploads/sombreros/".$row["Img1"]."' alt='".$row["Nombre"]."'>
                                </div>
                                <div class='vista-rapida'>
                                    <span>Ver más detalles</span>
                                </div>
                                <div class='text-producto'>
                                    <h4>".$row["Nombre"]."</h4>
                                    <h5>$".$row["Precio"].".00 mxn</h5>
                                </div>
                            </div>"
                        );
                    }
                ?>
            </div>
        </div>

        <div class="item" id="PanelDerecho">
            
            <div class="tarjeta-lateral perfil-usuario" style="text-align: center;">
                <?php if(isset($_SESSION['user_nombre'])): // Validamos si el usuario inició sesión ?>
                    
                    <?php
                    $rutaUserImg = '/LaHerradura/uploads/users/';
                    $imgDefault = '/LaHerradura/View/images/avatar.png';
                    $fotoActual = $_SESSION['user_foto'] ?? null;

                    if ($fotoActual) {
                        if (strpos($fotoActual, 'http://') === 0 || strpos($fotoActual, 'https://') === 0) {
                            $srcImagen = $fotoActual;
                        } else if (file_exists($_SERVER['DOCUMENT_ROOT'] . $rutaUserImg . $fotoActual)) {
                            $srcImagen = $rutaUserImg . $fotoActual;
                        } else {
                            $srcImagen = $imgDefault;
                        }
                    } else {
                        $srcImagen = $imgDefault;
                    }
                    ?>

                    <div class="info-perfil-centrada">
                        <img src="<?php echo htmlspecialchars($srcImagen); ?>" 
                            alt="Foto de perfil" 
                            class="foto-perfil" 
                            style="width: 80px; height: 80px; margin: 0 auto; display: block; border-radius: 50%; object-fit: cover; border: 2px solid #9f7200;" 
                            referrerpolicy="no-referrer">
                        
                        <h4 style="margin: 10px 0 5px 0; color: #333;">
                            <?php echo htmlspecialchars($_SESSION['user_nombre']); ?>
                        </h4>
                        <p style="color: #666; font-size: 0.85rem; margin-top: 0; margin-bottom: 15px;">
                            <?php echo htmlspecialchars($_SESSION['user_email'] ?? ''); ?>
                        </p>

                        <div style="display: flex; gap: 10px; justify-content: center;">
                            <a href="/LaHerradura/View/pages/user/UserAccount.php" class="btn-perfil-ingresar" style="background-color: #4C8F43; flex: 1; text-align: center;">Cuenta</a>
                            <a href="/LaHerradura/Controller/cerrarSesion.php" class="btn-perfil-ingresar" style="background-color: #d32f2f; flex: 1; text-align: center;">Salir</a>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="info-perfil" style="justify-content: center; flex-direction: column; text-align: center;">
                        <div class="icono-invitado" style="margin: 0 auto;">👤</div>
                        <div>
                            <h4 style="margin: 10px 0 5px 0;">Bienvenido</h4>
                            <p style="font-size: 0.85rem; margin: 5px 0 15px 0; color: #666;">Inicia sesión para ver tus pedidos</p>
                            <a href="#" class="btn-perfil-ingresar" id="OpenLogin2">Ingresar</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>


        </div> 
    </div> 
    
    <a href="https://wa.me/527721437028?text=Hola,%20vengo%20de%20la%20tienda%20en%20línea%20y%20necesito%20información." target="_blank" id="wpp-link">
        <img id="wpp" src="/LaHerradura/View/images/WhatsApp.png" alt="WhatsApp">
    </a>

    <?php 
    include(ROOT_PATH . 'View/modals/modals-View/modal-ViewProduct.php');
    ?>

    <footer>
        <?php 
        include(ROOT_PATH . 'View/includes/footer.php')
        ?>
    </footer>
    
    <script src="/LaHerradura/public/ViewProducts/viewSombreros.js"></script>
</body>
</html>