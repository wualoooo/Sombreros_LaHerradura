<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<link rel="stylesheet" href="/LaHerradura/View/css/style-Header.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link rel="stylesheet" href="/LaHerradura/View/css/style-login.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        
        <?php if (isset($_SESSION['user_email'])): ?>
            <li><a href="#" id="openUserInfo">
                Perfil
            </a></li>
        <?php else: ?>
            <li><a href="#" id="openLogin">Iniciar Sesion</a></li>
        <?php endif; ?>

        <li><a href="/LaHerradura/View/pages/user/rv.php">Guia de tallas</a></li>
        <li><a href="#">Probador virtual</a></li>
        <li><a href="#" id="btn-open-cart" style="position: relative;">    
            <span class="material-symbols-outlined" id="Cart">shopping_cart</span>
            <span id="cart-count" style="display: none; position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px; font-weight: bold;">0</span>
        </a></li>
    </ul>
</nav>

<?php
//Iniciar sesión
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
    
    <div id="cart-items-container" class="cart-items-container">
        </div>

    <div class="cart-footer-side">
        <div class="cart-total-side">
            <span>Total:</span>
            <span id="cart-total-amount">$0.00</span>
        </div>
        <button id="btn-pagar-side" class="btn-checkout-side">Pagar Ahora</button>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>