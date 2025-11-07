<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Sombreros</title>
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
        <h2 class="titleGestion">Gestión de Sombreros</h2>
        <button class="btn btn-agregar" id="btnAgg-Sombrero">Agregar nuevo sombrero</button>
        <table>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Color</th>
            <th>Copa</th>
            <th>Horma</th>
            <th>Tamaño copa</th>
            <th>Material</th>
            <th>Acciones</th>
        <tbody>
            <tr>
                <td>1</td>
                <td>Sombrero Bangora Natural Ventilado</td>
                <td>$800.00 mxn</td>
                <td>Blanco</td>
                <td>Chihuahua</td>
                <td>Malboro</td>
                <td>21 cm</td>
                <td>Bangora</td>
                <td>
                    <button class="btn btn-editar">Editar</button>
                    <button class="btn btn-eliminar">Eliminar</button>
                </td>
            </tr>
        </tbody>
        </table>
        <?php 
    include('../modals/modal-AggSombrero.php')
    ?>
    </main>
    <script src="../../public/viewImages.js"></script>
    <script src="../../public/modals.js"></script>
</body>
</html>