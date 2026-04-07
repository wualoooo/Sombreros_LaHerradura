<?php
session_start();
require_once '../../../Model/conexion.php';

// 1. Validar que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

// 2. Capturar los datos (AHORA RECIBIMOS EL CÓDIGO DE RASTREO)
$codigo_rastreo = isset($_GET['external_reference']) ? trim($_GET['external_reference']) : '';
$payment_id = isset($_GET['payment_id']) ? $_GET['payment_id'] : '';
$status_mp = isset($_GET['status']) ? $_GET['status'] : '';

if (!empty($codigo_rastreo)) {
    // 3. ACTUALIZAR LA BD BUSCANDO POR CÓDIGO DE RASTREO
    $sql_update = "UPDATE pedidos SET estado_pago = 'APROBADO', estado_envio = 8, folio_pago = ? WHERE codigo_rastreo = ? AND id_usuario = ?";
    $stmt = $conn->prepare($sql_update);
    // Nota: "ssi" porque ahora son String (folio), String (codigo), Entero (id_usuario)
    $stmt->bind_param("ssi", $payment_id, $codigo_rastreo, $_SESSION['id_usuario']);
    $stmt->execute();

    // 4. CONSULTAR LOS DATOS PARA EL RESUMEN
    // Necesitamos traernos el id_pedido también para poder generar el PDF
    $sql_pedido = "SELECT id_pedido, total, productos, fecha FROM pedidos WHERE codigo_rastreo = ?";
    $stmt_p = $conn->prepare($sql_pedido);
    $stmt_p->bind_param("s", $codigo_rastreo);
    $stmt_p->execute();
    $pedido = $stmt_p->get_result()->fetch_assoc();
    $items = json_decode($pedido['productos'], true);
    
    // Guardamos el ID real para usarlo en el botón de "Descargar PDF" de más abajo
    $id_pedido = $pedido['id_pedido'];
    
} else {
    // Si alguien entra sin código a la página, lo pateamos al index
    header("Location: ../../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¡Pago Exitoso! - La Herradura</title>
    <link rel="stylesheet" href="css/estilos.css"> <style>
        .success-container { max-width: 600px; margin: 50px auto; text-align: center; padding: 20px; border: 1px solid #ddd; border-radius: 10px; }
        .icon-check { font-size: 50px; color: #28a745; }
        .resumen-tabla { width: 100%; margin: 20px 0; border-collapse: collapse; }
        .resumen-tabla td { padding: 10px; border-bottom: 1px solid #eee; text-align: left; }
        .btn-descargar { display: inline-block; background: #8B0000; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; margin-top: 20px; font-weight: bold; }
        .btn-descargar:hover { background: #a00000; }
    </style>
    <link rel="shortcut icon" href="../../images/Logo_Herradura_head3.png" type="image/x-icon">
</head>
<body>

    <div class="success-container">
        <div class="icon-check">✔</div>
        <h1>¡Gracias por tu compra!</h1>
        <p>Tu pago ha sido procesado con éxito. El pedido <strong><?php echo ($codigo_rastreo); ?></strong> está siendo preparado.</p>
        
        <hr>
        
        <h3>Resumen del Pedido</h3>
        <table class="resumen-tabla">
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?php echo $item['nombre']; ?> (x<?php echo $item['cantidad']; ?>)</td>
                <td align="right">$<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td><strong>Total Pagado</strong></td>
                <td align="right"><strong>$<?php echo number_format($pedido['total'], 2); ?></strong></td>
            </tr>
        </table>

        <a href="../../../Controller/GenerarTicket.php?id_pedido=<?php echo $id_pedido; ?>" target="_blank" class="btn-descargar">
            Descargar Comprobante (PDF)
        </a>

        <br><br>
        <a href="UserAccount.php" style="color: #666;">Ver MI CUENTA</a>
    </div>

</body>
</html>