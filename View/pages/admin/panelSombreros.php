<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Sombreros</title>
    <link rel="stylesheet" href="/LaHerradura/View/css/style-Panels.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
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
            <th>Tamaño ala</th>
            <th>Material</th>
            <th>Acciones</th>
        <tbody id="tabla-sombreros-body">
            <?php 
            include (ROOT_PATH.'Model/conexion.php');

            $sql = "SELECT id_sombrero, Nombre, Precio, Color, Horma, Copa, Tam_Copa, Tam_ala, Material FROM sombreros";
            $result = $conn -> query($sql);

            if ($result -> num_rows>0){
                while($row = $result -> fetch_assoc()){
                    echo("
                        <tr>
                            <td>".$row["id_sombrero"]."</td>
                            <td>".$row["Nombre"]."</td>
                            <td>".$row["Precio"]. "</td>
                            <td>".$row["Color"]. "</td>
                            <td>".$row["Horma"]."</td>
                            <td>".$row["Copa"]."</td>
                            <td>".$row["Tam_Copa"]."</td>
                            <td>".$row["Tam_ala"]."</td>
                            <td>".$row["Material"]."</td>
                            <td>
                                <button class='btn btn-editarSombrero' data-id='".$row["id_sombrero"]."'>Editar</button>
                                <button class='btn btn-eliminarSombrero' data-id='".$row["id_sombrero"]."'>Eliminar</button>
                            </td>
                        </tr>"
                    );
                }

            }

            else{
                echo("
                    <tr>
                        <td colspan='4'>No hay resultados</td>
                    </tr>
                ");
            }

        ?>

        <!--</tbody>
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
        </tbody>-->

        </table>
        <?php 
        include(ROOT_PATH.'View/modals/modal-EditarSombrero.php');
        include(ROOT_PATH.'View/modals/modal-AggSombrero.php')
        ?>
    </main>

    <script src="/LaHerradura/public/viewImages.js"></script>
    <script src="/LaHerradura/public/adminSombreros.js"></script>
    <script src="/LaHerradura/public/modals.js"></script>
    <script src="/LaHerradura/public/validacion.js"></script>
    <script src="/LaHerradura/View/alerts/alerts.js"></script>
</body>
</html>