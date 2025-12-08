    <link rel="stylesheet" href="/LaHerradura/View/css/style-Header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=shopping_cart" />

    <nav class="navbar">
        <div class="logo">
            <a href="/LaHerradura/index.php"><img src="/LaHerradura/View/images/Logo_Herradura.png" alt="Logo Herradura"></a>
            <h1>
                Sombreros <br> La Herradura
            </h1>
        </div>
        <ul class="nav-links">
            <li><a href="/LaHerradura/View/pages/user/Sombreros.php">Sombreros</a></li>
            <li><a href="/LaHerradura/View/pages/user/Texanas.php">Texanas</a></li>
            <li><a href="/LaHerradura/View/pages/user/Cinturones.php">Cinturones</a></li>
            <li><a href="/LaHerradura/View/pages/user/Botines.php">Botines</a></li>
            <li><a href="#" id="openLogin">Mi cuenta</a></li>
            <li><a href="#">Guia de tallas</a></li>
            <li><a href="#">Probador virtual</a></li>
                <li><a href="#"> 
                    <span class="material-symbols-outlined" id="Cart">shopping_cart</span>
            </a></li>
        </ul>
            </div>
            <?php 
            include(ROOT_PATH . 'View/modals/modal-login.php')
            ?>
    </nav>