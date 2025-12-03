<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cinturones</title>
    <link rel="stylesheet" href="../../css/style-Panels.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <?php 
        define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
        include(ROOT_PATH.'View/includes/header-admin.php')
        ?>
    </header>
    <main>
        <h2 class="titleGestion">Gestión de Cinturones</h2>
        <button class="btn btn-agregar" id="btnAgg-Cinturon">Agregar nuevo cinturón</button>
        <table>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Material</th>
            <th>Adorno</th>
            <th>Tamaño</th>
            <th>Acciones</th>
        <tbody id="tabla-cinturones-body">   
            <?php 
            include (ROOT_PATH.'Model/conexion.php');

            $sql = "SELECT id_cinturon, Nombre, Precio, Material, Adorno, Tamaño FROM cinturones";
            $result = $conn -> query($sql);

            if ($result -> num_rows>0){
                while($row = $result -> fetch_assoc()){
                    echo("
                        <tr>
                            <td>".$row["id_cinturon"]."</td>
                            <td>".$row["Nombre"]."</td>
                            <td>".$row["Precio"]. "</td>
                            <td>".$row["Material"]. "</td>
                            <td>".$row["Adorno"]."</td>
                            <td>".$row["Tamaño"]."</td>
                            <td>
                                <button class='btn btn-editarCinturon' data-id='".$row["id_cinturon"]."'>Editar</button>
                                <button class='btn btn-eliminarCinturon' data-id='".$row["id_cinturon"]."'>Eliminar</button>
                            </td>
                        </tr>"
                    );
                }

            }

            else{
                echo("
                    <tr>
                        <td colspan='7'>No hay resultados</td>
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
        include(ROOT_PATH.'View/modals/modals-Editar/modal-EditarCinturon.php');
        include(ROOT_PATH.'View/modals/modals-Agregar/modal-AggCinturon.php')
        ?>
    </main>

    <script src="/LaHerradura/public/ViewProducts/viewImages.js"></script>
    <script src="/LaHerradura/public/AdminProducts/adminCinturones.js"></script>
    <script src="/LaHerradura/public/modals.js"></script>
</body>
</html>