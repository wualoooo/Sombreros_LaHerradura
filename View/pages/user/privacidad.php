<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aviso de Privacidad - Sombreros La Herradura</title>
    <link rel="stylesheet" href="/LaHerradura/View/css/style-terminos.css">
    <link rel="shortcut icon" href="../../images/Logo_Herradura_head3.png" type="image/x-icon">
</head>
<body>
    <header>
        <?php 
        define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
        include(ROOT_PATH . 'View/includes/header.php');
        ?>
    </header>

    <main class="contenedor-terminos">
        <h1>Aviso de Privacidad</h1>
        <p class="fecha-actualizacion">Última actualización: Abril de 2026</p>

        <section>
            <h2>1. Información que Recopilamos</h2>
            <p>Para brindarte el mejor servicio, recopilamos información personal cuando creas una cuenta, te suscribes a nuestro boletín o realizas una compra. Esta información incluye, de manera enunciativa más no limitativa: tu nombre completo, dirección de correo electrónico, número de teléfono, y dirección de envío. Si decides registrarte utilizando servicios de terceros (como Google Sign-In), recibiremos tu perfil público básico autorizado por dicha plataforma.</p>
        </section>

        <section>
            <h2>2. Uso de tu Información</h2>
            <p>Los datos que nos proporcionas son utilizados exclusivamente para las siguientes finalidades operativas:</p>
            <ul>
                <li style="color: #444; line-height: 1.6; margin-bottom: 5px;">Procesar y enviar tus pedidos de texanas y sombreros.</li>
                <li style="color: #444; line-height: 1.6; margin-bottom: 5px;">Contactarte en caso de incidencias con tu envío o inventario.</li>
                <li style="color: #444; line-height: 1.6; margin-bottom: 5px;">Gestionar el acceso seguro a tu cuenta de usuario.</li>
                <li style="color: #444; line-height: 1.6;">Atender tus solicitudes a través de nuestros canales de soporte técnico o atención a clientes.</li>
            </ul>
        </section>

        <section>
            <h2>3. Protección de Datos Financieros y Terceros</h2>
            <p><strong>Sombreros La Herradura NO recopila, almacena ni tiene acceso directo a los datos de tu tarjeta de crédito o débito.</strong> Toda transacción financiera se procesa mediante los servidores seguros y encriptados de la pasarela de pago (Mercado Pago). Solo compartimos con terceros la información estrictamente necesaria para cumplir con nuestro servicio.</p>
        </section>

        <section>
            <h2>4. Derechos ARCO</h2>
            <p>Como titular de tus datos personales, tienes derecho a conocer qué información tenemos de ti, solicitar su corrección si está desactualizada, pedir que la eliminemos o negarte al uso de la misma para fines específicos. Para ejercer tus Derechos ARCO, envía una solicitud formal al correo <strong>info@sombreroslaherradura.com</strong>.</p>
        </section>

        <section>
            <h2>5. Uso de Cookies</h2>
            <p>Nuestro sitio web utiliza cookies para mantener activa tu sesión, gestionar los productos de tu carrito de compras y mejorar tu experiencia de navegación. Puedes desactivar el uso de cookies desde la configuración de tu navegador, aunque esto podría limitar ciertas funciones de la tienda.</p>
        </section>
    </main>

    <footer>
        <?php include(ROOT_PATH . 'View/includes/footer.php'); ?>
    </footer>
</body>
</html>