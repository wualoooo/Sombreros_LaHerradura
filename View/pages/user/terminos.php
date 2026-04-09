<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Términos y Condiciones - Sombreros La Herradura</title>
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
        <h1>Términos y Condiciones de Servicio</h1>
        <p class="fecha-actualizacion">Última actualización: Abril de 2026</p>

        <section>
            <h2>1. Aceptación de los Términos</h2>
            <p>Bienvenido a Sombreros La Herradura. Al acceder a nuestro sitio web, registrar una cuenta o realizar una compra, aceptas estar legalmente vinculado por estos Términos y Condiciones. Si no estás de acuerdo con alguna de las políticas aquí descritas, te solicitamos amablemente que no utilices nuestra plataforma.</p>
        </section>

        <section>
            <h2>2. Uso de la Cuenta y Registro</h2>
            <p>Para realizar compras puedes navegar como invitado o crear una cuenta (mediante correo electrónico o Google). Eres el único responsable de mantener la confidencialidad de tu contraseña y de todas las actividades que ocurran bajo tu cuenta. La Herradura se reserva el derecho de suspender o cancelar cuentas que muestren actividad fraudulenta o violen estos términos.</p>
        </section>

        <section>
            <h2>3. Productos, Tallas y Disponibilidad</h2>
            <p>Hacemos todo lo posible por mostrar los colores, texturas y detalles de nuestros sombreros y texanas con la mayor precisión. Sin embargo, debido a la naturaleza de los materiales (como lana, pelo o palma) y la configuración de tu pantalla, pueden existir ligeras variaciones. Todo el inventario está sujeto a disponibilidad. En el caso extraordinario de que un producto pagado no tenga stock físico, te notificaremos inmediatamente para ofrecerte un cambio o un reembolso íntegro.</p>
        </section>

        <section>
            <h2>4. Precios y Procesamiento de Pagos</h2>
            <p>Todos los precios se expresan en Pesos Mexicanos (MXN). Nos reservamos el derecho de modificar los precios sin previo aviso, respetando siempre el precio al momento de la confirmación de tu pedido.</p>
            <p>El procesamiento de pagos se realiza de forma segura y encriptada a través de <strong>Mercado Pago</strong>. La Herradura no almacena en sus servidores datos sensibles de tus tarjetas de crédito o débito. La aprobación de la transacción está sujeta a los sistemas de prevención de fraude de la pasarela de pago.</p>
        </section>

        <section>
            <h2>5. Envíos y Tiempos de Entrega</h2>
            <p>Los pedidos son procesados una vez que el pago ha sido aprobado. Los tiempos de tránsito estimados son de 7 a 14 días hábiles dependiendo de tu código postal. La Herradura no se hace responsable por demoras imputables directamente a la empresa de paquetería (clima, bloqueos o direcciones incorrectas proporcionadas por el cliente). Es responsabilidad del comprador proporcionar una dirección de entrega completa y precisa.</p>
        </section>

        <section>
            <h2>6. Propiedad Intelectual</h2>
            <p>Todo el contenido de este sitio, incluyendo pero no limitado a logotipos, textos, fotografías, gráficos, modelos 3D y código fuente, es propiedad exclusiva de Sombreros La Herradura. Queda estrictamente prohibida su reproducción, distribución o uso comercial sin nuestra autorización por escrito.</p>
        </section>

        <section>
            <h2>7. Limitación de Responsabilidad</h2>
            <p>Sombreros La Herradura no será responsable por daños indirectos, incidentales o consecuentes derivados del uso de nuestro sitio web o de la compra de nuestros productos. Nuestra responsabilidad máxima en cualquier reclamo estará limitada al monto exacto pagado por el cliente por el producto en cuestión.</p>
        </section>

        <section>
            <h2>8. Contacto y Atención al Cliente</h2>
            <p>Si tienes alguna duda sobre tu pedido o sobre estos términos, estamos para ayudarte. Contáctanos mediante nuestro botón de atención en WhatsApp o escríbenos a <strong>info@sombreroslaherradura.com</strong>.</p>
        </section>
    </main>


    <footer>
        <?php include(ROOT_PATH . 'View/includes/footer.php'); ?>
    </footer>
</body>
</html>