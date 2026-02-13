<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de pedidos</title>
    <link rel="stylesheet" href="/LaHerradura/View/css/style-Panels.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header>
        <?php 
        define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
        include(ROOT_PATH.'View/includes/header-admin.php')
        ?>
    </header>
    <main>
        <h2 class="titleGestion">Gestión de Pedidos</h2>
        <table>
            <th>Nombre usuario</th>
            <th>Dirección de envío</th>
            <th>Teléfono</th>
            <th>Código de rastreo</th>
            <th>Productos</th>
            <th>Total</th>
            <th>Fecha</th>
            <th>Estado del pedido</th>
        <tbody id="tabla-pedidos-body">
            <!--<tr>
                <td>1</td>
                <td>Osbaldo Martínez Martin</td>
                <td>7721042773</td>
                <td>
                    <ul>
                        <li>Sombrero bangora</li>
                        <li>Botin negro</li>
                        <li>Cinturon</li>
                    </ul>
                </td>
                <td>$1900.00</td>
                <td>Pago con tarjeta</td>
                <td>Santiago Ixtlahuaca, Tasquillo, <br> Hidalgo CP:42383</td>
                <td>01/11/25</td>
                <td>
                    <Select id="StatePedido">
                        <option value="">Revision de pago</option>
                        <option value="">En proceso</option>
                        <option value="">Enviado</option>
                        <option value="">Completado</option>
                    </Select>
                </td>
            </tr>-->
            <tr>
                <?php 
                include (ROOT_PATH.'Model/conexion.php');
                $sqlSELECT = "SELECT 
                                u.Nombre,
                                u.Apellido_Pat,
                                u.Apellido_Mat,
                                d.cp,
                                d.estado,
                                d.municipio,
                                d.colonia,
                                d.calle,
                                d.numero,
                                d.referencia,
                                u.Telefono,
                                p.codigo_rastreo,
                                dp.
                                "

                ?>
            </tr>
        </tbody>
        </table>
    </main>
</body>
</html>