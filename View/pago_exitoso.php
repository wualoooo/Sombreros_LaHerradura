<?php
session_start();
header('Content-Type: text/html');

// Ajusta la ruta a tu conexión
require_once '../Model/conexion.php'; 

// Recibir parámetros de Mercado Pago por URL
$id_pedido = $_GET['external_reference'] ?? null;
$status = $_GET['status'] ?? null;
$payment_id = $_GET['payment_id'] ?? null;

if ($id_pedido && $status === 'approved') {
    
    // ACTUALIZAR BASE DE DATOS
    $sql = "UPDATE pedidos SET estado_pago = 'PAGADO', folio_pago = ? WHERE id_pedido = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $payment_id, $id_pedido);
    $exito = $stmt->execute();

    if ($exito) {
        $mensaje_titulo = "¡Compra Exitosa!";
        $mensaje_texto = "Tu pedido #" . htmlspecialchars($id_pedido) . " ha sido confirmado. El folio de tu pago es: " . htmlspecialchars($payment_id);
    } else {
        $mensaje_titulo = "Error de actualización";
        $mensaje_texto = "El pago se cobró, pero hubo un error actualizando el sistema. Contáctanos con tu folio: " . htmlspecialchars($payment_id);
    }
} else {
    $mensaje_titulo = "Error de validación";
    $mensaje_texto = "No se pudo validar la información del pago.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago Exitoso - La Herradura</title>
    <link rel="stylesheet" href="/LaHerradura/View/css/style.css"> </head>
<body style="text-align: center; padding: 50px; font-family: sans-serif;">

    <h1 style="color: #28a745;"><?php echo $mensaje_titulo; ?></h1>
    <p><?php echo $mensaje_texto; ?></p>
    <br>
    <a href="/LaHerradura/index.php" style="padding: 10px 20px; background: #8B0000; color: white; text-decoration: none; border-radius: 5px;">Volver a la tienda</a>

    <script>
        localStorage.removeItem('laherradura_carrito');
    </script>
</body>
</html>