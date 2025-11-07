<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="../css/style-Panels.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
</head>
</head>
<body>
    <header>
        <?php 
        include('../includes/header-admin.php')
        ?>
    </header>
    <main>
        <h2 class="titleGestion">Usuarios registrados</h2>
        <table>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Correo</th>
            <th>Direccion de envio</th>
            <th>Telefono</th>
            <th>Pedidos relizados</th>
        <tbody>
            <tr>
                <td>1</td>
                <td>Osbaldo</td>
                <td>Martínez Martin</td>
                <td>osbaldomtz1505@gmail.com</td>
                <td>Santiago Ixtlahuaca, Tasquillo, <br> Hidalgo CP:42383</td>
                <td>7721042773</td>
                <td><ul>
                        <li>11/06/25</li>
                        <li>11/06/25</li>
                        <li>11/06/25</li>
                    </ul></td>
            </tr>
        </tbody>
        </table>
    </main>
</body>
</html>