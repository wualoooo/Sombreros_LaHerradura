<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Texanas</title>
    <link rel="stylesheet" href="../../css/style-Panels.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <?php 
        include('../../includes/header-admin.php')
        ?>
    </header>
    <main>
        <h2 class="titleGestion">Gestión de Texanas</h2>
        <button class="btn btn-agregar" id="btnAgg-Texana">Agregar nueva texana</button>
        <table>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Color</th>
            <th>Horma</th>
            <th>Copa</th>
            <th>Tamaño copa</th>
            <th>Material</th>
            <th>Acciones</th>
        <tbody id="tabla-texana-body">   
            <?php 
            include ('../../../Model/conexion.php');

            $sql = "SELECT id_texana, Nombre, Precio, Color, Horma, Copa, Tam_Copa, Material FROM texana";
            $result = $conn -> query($sql);

            if ($result -> num_rows>0){
                while($row = $result -> fetch_assoc()){
                    echo("
                        <tr>
                            <td>".$row["id_texana"]."</td>
                            <td>".$row["Nombre"]."</td>
                            <td>".$row["Precio"]. "</td>
                            <td>".$row["Color"]. "</td>
                            <td>".$row["Horma"]."</td>
                            <td>".$row["Copa"]."</td>
                            <td>".$row["Tam_Copa"]."</td>
                            <td>".$row["Material"]."</td>
                            <td>
                                <button class='btn btn-editarTexana' data-id='".$row["id_texana"]."'>Editar</button>
                                <button class='btn btn-eliminarTexana' data-id='".$row["id_texana"]."'>Eliminar</button>
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
        include('../../modals/modal-EditarTexana.php');
        include('../../modals/modal-AggTexana.php')
        ?>
    </main>

    <script src="../../../public/viewImages.js"></script>
    <script src="../../../public/adminTexanas.js"></script>
    <script src="../../../public/modals.js"></script>
</body>
</html>