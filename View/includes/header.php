<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//Definir la ruta
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
}
//Conectar con la BD para toda la parte de user
require_once(ROOT_PATH . 'Model/conexion.php'); 
?>

<link rel="stylesheet" href="/LaHerradura/View/css/style-Header.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link rel="stylesheet" href="/LaHerradura/View/css/style-login.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<nav class="navbar">
    <div class="nav-left">
        <button id="btn-menu-movil" class="menu-movil-toggle">
            <span class="material-symbols-outlined" id="menudesp">menu</span>
        </button>
        
        <div class="logo">
            <a href="/LaHerradura/index.php"><img src="/LaHerradura/View/images/Logo_Herradura.png" alt="Logo Herradura" id="ImgLogo"></a>
            <h1>Sombreros <br> La Herradura</h1>
        </div>
    </div>

    <div class="nav-menu-cart-group">
        
        <ul class="nav-links" id="menu-desplegable">
            <li><a href="/LaHerradura/View/pages/user/Sombreros.php">Sombreros</a></li>
            <li><a href="/LaHerradura/View/pages/user/Texanas.php">Texanas</a></li>
            <li><a href="/LaHerradura/View/pages/user/Cinturones.php">Cinturones</a></li>
            <li><a href="/LaHerradura/View/pages/user/Botines.php">Botines</a></li>
            
            <?php if (isset($_SESSION['user_email'])): ?>
                <li class="desktop-user-link"><a href="#" id="openUserInfo">Perfil</a></li>
            <?php else: ?>
                <li class="desktop-user-link"><a href="#" id="openLogin">Iniciar Sesion</a></li>
            <?php endif; ?>

            <li><a href="/LaHerradura/View/pages/user/rv.php">Guía de tallas</a></li>
            <li><a href="#">Probador virtual</a></li>
        </ul>

        <div class="nav-right">
            <?php if (isset($_SESSION['user_email'])): ?>
                <a href="#" id="openUserInfoMobile" class="icono-link mobile-user-icon" title="Mi Perfil">
                    <span class="material-symbols-outlined">person</span>
                </a>
            <?php else: ?>
                <a href="#" id="openLoginMobile" class="icono-link mobile-user-icon" title="Iniciar Sesión">
                    <span class="material-symbols-outlined">person</span>
                </a>
            <?php endif; ?>

            <a href="#" id="btn-open-cart" class="icono-link" style="position: relative; display: flex; align-items: center;">    
                <span class="material-symbols-outlined" id="Cart">shopping_cart</span>
                <span id="cart-count" style="display: none; position: absolute; top: -8px; right: -10px; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px; font-weight: bold;">0</span>
            </a>
        </div>
    </div>
</nav>

<?php 
include(ROOT_PATH . 'View/modals/modal-Checkout.php');

if (isset($_SESSION['user_email'])) {
    include(ROOT_PATH . 'View/modals/modal-UserInfo.php');
} else {
    include(ROOT_PATH . 'View/modals/modal-login.php');
}
?>

<div id="cart-overlay" class="cart-overlay"></div>

<div id="cart-sidebar" class="cart-sidebar">
    <div class="cart-header-side">
        <h2>Tu Carrito</h2>
        <span class="close-cart" id="btn-close-cart">&times;</span>
    </div>
    
    <div id="cart-items-container" class="cart-items-container"></div>

    <div class="cart-footer-side">
        <div class="cart-total-side">
            <span>Total:</span>
            <span id="cart-total-amount">$0.00</span>
        </div>
        <button id="btn-pagar-side" class="btn-checkout-side">Pagar Ahora</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const btnMenu = document.getElementById('btn-menu-movil');
    const menuDesplegable = document.getElementById('menu-desplegable');
    const iconoMenu = btnMenu ? btnMenu.querySelector('span') : null;

    // Abrir/Cerrar menú móvil
    if (btnMenu && menuDesplegable) {
        btnMenu.addEventListener('click', (e) => {
            e.stopPropagation(); // Evita que el click se propague al document
            menuDesplegable.classList.toggle('activo');
            iconoMenu.textContent = menuDesplegable.classList.contains('activo') ? 'close' : 'menu';
        });
    }

    // Cerrar menú al hacer clic fuera de él
    document.addEventListener('click', (e) => {
        if (menuDesplegable && menuDesplegable.classList.contains('activo')) {
            // Si el click NO es dentro del menú
            if (!menuDesplegable.contains(e.target)) {
                menuDesplegable.classList.remove('activo');
                iconoMenu.textContent = 'menu';
            }
        }
    });

    // Vincular iconos móviles con los modales existentes
    const loginMobile = document.getElementById('openLoginMobile');
    const loginDesktop = document.getElementById('openLogin');
    if(loginMobile && loginDesktop) {
        loginMobile.addEventListener('click', (e) => { e.preventDefault(); loginDesktop.click(); });
    }

    const userInfoMobile = document.getElementById('openUserInfoMobile');
    const userInfoDesktop = document.getElementById('openUserInfo');
    if(userInfoMobile && userInfoDesktop) {
        userInfoMobile.addEventListener('click', (e) => { e.preventDefault(); userInfoDesktop.click(); });
    }
});
</script>