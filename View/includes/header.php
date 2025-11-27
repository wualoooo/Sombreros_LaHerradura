    <link rel="stylesheet" href="/LaHerradura/View/css/style-Header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/LaHerradura/View/css/style-login.css">

    <nav class="navbar">
        <div class="logo">
            <a href="/LaHerradura/View/pages/index.php"><img src="/LaHerradura/View/images/Logo_Herradura.png" alt="Logo Herradura"></a>
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
                <li><a href="#">    <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi-cart-fill" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                </svg>
            </a></li>
        </ul>
    
            </div>

            <?php 
            include(ROOT_PATH . 'View/modals/modal-login.php')
            ?>
    </nav>

    

