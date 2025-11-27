<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de pedidos</title>
    <link rel="stylesheet" href="../../css/style-Panels.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
</head>
</head>
<body>
    <header>
        <?php 
        include('../../includes/header-admin.php')
        ?>
    </header>
    <main>
        <h2 class="titleGestion">Gestión de Pedidos</h2>
        <table>
            <th>ID</th>
            <th>Nombre usuario</th>
            <th>Teléfono</th>
            <th>Productos</th>
            <th>Cantidad</th>
            <th>Método de pago</th>
            <th>Dirección de envío</th>
            <th>Fecha</th>
            <th>Estado del pedido</th>
        <tbody>
            <tr>
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
            </tr>
        </tbody>
        </table>
    </main>
</body>
</html>