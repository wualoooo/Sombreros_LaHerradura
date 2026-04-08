<?php
session_start();

// 1. Seguridad básica
if (!isset($_SESSION['id_usuario'])) {
    header("Location: /LaHerradura/index.php");
    exit();
}

// 2. Validar que venga el ID por la URL
if (!isset($_GET['id'])) {
    // Si no trae ID, lo regresamos a su perfil (ajusta el nombre si tu archivo se llama diferente)
    header("Location: perfil.php"); 
    exit();
}

define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
require(ROOT_PATH . 'Model/conexion.php');

$id_usuario = $_SESSION['id_usuario'];
$id_pedido = intval($_GET['id']);

// 3. Consulta maestra (Traemos el pedido, el estatus y la dirección de un solo golpe)
$sql = "SELECT p.*, e.status AS nombre_estatus, 
                d.colonia, d.calle, d.numero, d.municipio, d.estado, d.cp, d.referencia, d.telefono
        FROM pedidos p
        LEFT JOIN estatus e ON p.estado_envio = e.id_status
        LEFT JOIN direcciones d ON p.id_direccion = d.id_direccion
        WHERE p.id_pedido = ? AND p.id_usuario = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_pedido, $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

// Si el pedido no existe o no es de este usuario, lo bloqueamos
if ($resultado->num_rows === 0) {
    header("Location: perfil.php");
    exit();
}

$pedido = $resultado->fetch_assoc();
$productos = json_decode($pedido['productos'], true);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Pedido #<?php echo str_pad($pedido['id_pedido'], 5, "0", STR_PAD_LEFT); ?></title>
    <link rel="stylesheet" href="/LaHerradura/View/css/style-userAccount.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
    
    <style>
        .detalle-container {  max-width: 900px; margin: 40px auto; padding: 20px; margin-top: 9.5rem; font-family: 'Montserrat', sans-serif; }
        .cabecera-detalle { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #8B0000; padding-bottom: 15px; margin-bottom: 20px; }
        .btn-volver { display: inline-flex; align-items: center; color: #555; text-decoration: none; font-weight: bold; margin-bottom: 20px; transition: 0.3s; }
        .btn-volver:hover { color: #8B0000; }
        
        .grid-info { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .card-info { background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #eee; }
        .card-info h3 { margin-top: 0; color: #8B0000; font-size: 1.1rem; margin-bottom: 15px; display: flex; align-items: center; gap: 8px; }
        
        .tabla-productos { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .tabla-productos th { background-color: #8B0000; color: white; padding: 12px; text-align: left; }
        .tabla-productos td { padding: 12px; border-bottom: 1px solid #eee; vertical-align: middle; }
        .img-miniatura { width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd; }
        
        .estado-tag { display: inline-block; padding: 5px 10px; border-radius: 4px; font-size: 0.85rem; font-weight: bold; }
        .tag-verde { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .tag-amarillo { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        
        @media (max-width: 768px) {
            .grid-info { grid-template-columns: 1fr; }
        }
    </style>
    <link rel="shortcut icon" href="../../images/Logo_Herradura_head3.png" type="image/x-icon">
</head>
<body>

    <header>
        <?php include(ROOT_PATH . 'View/includes/header.php'); ?>
    </header>

    <div class="detalle-container">
        
        <a href="UserAccount.php" class="btn-volver">
            <span class="material-symbols-outlined" style="margin-right: 5px;">arrow_back</span> 
            Volver a Mis Pedidos
        </a>

        <div class="cabecera-detalle">
            <div>
                <h1 style="margin:0; font-size: 1.8rem;">Pedido <strong>#<?php echo str_pad($pedido['id_pedido'], 5, "0", STR_PAD_LEFT); ?></strong></h1>
                <p style="margin: 5px 0 0 0; color: #666;">Fecha: <?php echo date('d/m/Y H:i', strtotime($pedido['fecha'])); ?></p>
            </div>
            <div>
                <a href="/LaHerradura/Controller/GenerarTicket.php?id_pedido=<?php echo $pedido['id_pedido']; ?>" target="_blank" style="background-color: #8B0000; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-flex; align-items: center; gap: 5px;">
                    <span class="material-symbols-outlined">download</span> Descargar PDF
                </a>
            </div>
        </div>

        <div class="grid-info">
            <div class="card-info">
                <h3><span class="material-symbols-outlined">local_shipping</span> Estado del Pedido</h3>
                <p><strong>Seguimiento:</strong> <?php echo htmlspecialchars($pedido['codigo_rastreo']); ?></p>
                <p style="margin: 15px 0;">
                    <strong>Pago:</strong> 
                    <?php if($pedido['estado_pago'] == 'APROBADO'): ?>
                        <span class="estado-tag tag-verde">Aprobado</span>
                    <?php else: ?>
                        <span class="estado-tag tag-amarillo"><?php echo htmlspecialchars($pedido['estado_pago']); ?></span>
                    <?php endif; ?>
                </p>
                <p>
                    <strong>Envío:</strong> <span style="color: #8B0000; font-weight: bold;"><?php echo htmlspecialchars($pedido['nombre_estatus']); ?></span>
                </p>
            </div>

            <div class="card-info">
                <h3><span class="material-symbols-outlined">location_on</span> Dirección de Envío</h3>
                <?php if($pedido['id_direccion'] == 1): ?>
                    <p><strong>Recoger en Tienda Física</strong></p>
                    <p style="color: #555;">Carretera Ixmiquilpan-Tasquillo km 25<br>Panales, Ixmiquilpan 42326</p>
                <?php else: ?>
                    <p><strong><?php echo htmlspecialchars($pedido['calle'] . ' ' . $pedido['numero']); ?></strong></p>
                    <p style="color: #555;">Colonia <?php echo htmlspecialchars($pedido['colonia']); ?>, C.P. <?php echo htmlspecialchars($pedido['cp']); ?></p>
                    <p style="color: #555;"><?php echo htmlspecialchars($pedido['municipio'] . ', ' . $pedido['estado']); ?></p>
                    <?php if(!empty($pedido['referencia'])): ?>
                        <p style="margin-top: 10px; font-size: 0.9em;"><em>Ref: <?php echo htmlspecialchars($pedido['referencia']); ?></em></p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <h2 style="color: #333; margin-bottom: 15px;">Productos Adquiridos</h2>
        <div style="overflow-x: auto;">
            <table class="tabla-productos">
                <thead>
                    <tr>
                        <th width="80">Imagen</th>
                        <th>Producto</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($productos as $prod): ?>
                    <tr>
                        <td>
                            <?php 
                                $ruta_img = "/LaHerradura/uploads/" . strtolower($prod['tipo']) . "/" . $prod['imagen'];
                            ?>
                            <img src="<?php echo $ruta_img; ?>" alt="Producto" class="img-miniatura" onerror="this.src='/LaHerradura/View/images/default.jpg'">
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($prod['nombre']); ?></strong><br>
                            <span style="color: #777; font-size: 0.9em;">SKU: <?php echo htmlspecialchars($prod['sku']); ?> | Talla: <?php echo htmlspecialchars($prod['talla']); ?></span><br>
                            <span style="color: #444; font-size: 0.9em;">Cantidad: <strong><?php echo $prod['cantidad']; ?></strong></span>
                        </td>
                        <td>$<?php echo number_format($prod['precio'], 2); ?></td>
                        <td><strong>$<?php echo number_format($prod['precio'] * $prod['cantidad'], 2); ?></strong></td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <tr>
                        <td colspan="3" style="text-align: right; border-bottom: none; padding-top: 20px;">
                            <span style="font-size: 1.2rem; color: #555;">Total Pagado:</span>
                        </td>
                        <td style="border-bottom: none; padding-top: 20px;">
                            <span style="font-size: 1.5rem; color: #8B0000; font-weight: 900;">$<?php echo number_format($pedido['total'], 2); ?></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>