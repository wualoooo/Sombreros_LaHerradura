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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=delete,edit" />
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
            
            // RECOLECTAR LOS DATOS DE LA BASE DE DATOS
            $sql = "SELECT id_sombrero, Nombre, Precio, Color, Horma, Copa, Tam_Copa, Tam_ala, Material FROM sombreros";
            $result = $conn -> query($sql);

            // MOSTRAR LOS DATOS EN UNA TABLA
            if ($result -> num_rows>0){
                while($row = $result -> fetch_assoc()){
                    echo("
                        <tr>
                            <td>".$row["Nombre"]."</td>
                            <td>".$row["Precio"]. "</td>
                            <td>".$row["Color"]. "</td>
                            <td>".$row["Horma"]."</td>
                            <td>".$row["Copa"]."</td>
                            <td>".$row["Tam_Copa"]."</td>
                            <td>".$row["Tam_ala"]."</td>
                            <td>".$row["Material"]."</td>
                            <td>
                                <button class='btn btn-editarSombrero' data-id='".$row["id_sombrero"]."'>
                                    <span class='material-symbols-outlined'>edit</span>
                                </button>
                                <button class='btn btn-eliminarSombrero' data-id='".$row["id_sombrero"]."'>
                                    <span class='material-symbols-outlined'>delete</span>
                                </button>
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
        include(ROOT_PATH.'View/modals/modals-Editar/modal-EditarSombrero.php');
        include(ROOT_PATH.'View/modals/modals-Agregar/modal-AggSombrero.php')
        ?>
    </main>

    <script src="/LaHerradura/public/ViewProducts/viewImages.js"></script>
    <script src="/LaHerradura/public/AdminProducts/adminSombreros.js"></script>
    <script src="/LaHerradura/public/modals.js"></script>
    <script src="/LaHerradura/public/Validations/validacionSombreros.js"></script>
</body>
</html>