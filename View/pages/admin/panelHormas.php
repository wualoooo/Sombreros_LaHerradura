<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Hormas</title>
    <link rel="stylesheet" href="../../css/style-Panels.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <?php
        define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
        include(ROOT_PATH . 'View/includes/header-admin.php') ;
        ?>
    </header>
    <main>
        <h2 class="titleGestion">Gestión de Hormas</h2>
        <button class="btn btn-agregar" id="btnAgg-Horma">Agregar nueva Horma</button>
        <table>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        <tbody id="tabla-copas-body">   
            <?php 
            include (ROOT_PATH.'Model/conexion.php');

            $sql = "SELECT id_horma, Nombre FROM hormas ORDER BY id_horma";
            $result = $conn -> query($sql);

            if ($result -> num_rows>0){
                while($row = $result -> fetch_assoc()){
                    echo("
                        <tr>
                            <td>".$row["id_horma"]."</td>
                            <td>".$row["Nombre"]."</td>
                            <td>
                                <button class='btn btn-editarCinturon' data-id='".$row["id_horma"]."'>Editar</button>
                                <button class='btn btn-eliminarCinturon' data-id='".$row["id_horma"]."'>Eliminar</button>
                            </td>
                        </tr>"
                    );
                }

            }

            else{
                echo("
                    <tr>
                        <td colspan='2'>No hay resultados</td>
                    </tr>
                ");
            }

        ?>

        </table>
        <?php 
        /*include(ROOT_PATH.'modals/modal-EditarCinturon.php');*/
        include(ROOT_PATH.'View/modals/modal-AggHorma.php')
        ?>
    </main>

    <script src="/LaHerradura/public/crud_extras.js"></script>
    <script src="/LaHerradura/public/modals.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
        
        // Configurar HORMAS
        configurarFormularioExtra(
            'form-AggHorma',
            '/LaHerradura/Controller/CRUD_Extras/CRUD_Hormas/registroHormas.php', 
            'Horma' 
        );
    })
    </script>
</body>
</html>