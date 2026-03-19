<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Materiales</title>
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
        include(ROOT_PATH . 'View/includes/header-admin.php') ;
        ?>
    </header>
    <main>
        <h2 class="titleGestion">Gestión de Materiales</h2>
        <button class="btn btn-agregar" id="btnAgg-Material">
            <span class="material-symbols-outlined" id="IconAdd">add_2</span>Agregar nueva Material</button>
        <table>
            <th>Producto</th>
            <th>Nombre material</th>
            <th>Acciones</th>
        <tbody id="tabla-copas-body">   
            <?php 
            include (ROOT_PATH.'Model/conexion.php');

            $sql = "SELECT id_material, Nombre, Producto FROM materiales ORDER BY Producto";
            $result = $conn -> query($sql);

            if ($result -> num_rows>0){
                while($row = $result -> fetch_assoc()){
                    echo("
                        <tr>
                            <td>".$row["Producto"]."</td>
                            <td>".$row["Nombre"]."</td>
                            <td>
                                <button class='btn btn-editarCinturon' data-id='".$row["id_material"]."'>
                                <span class='material-symbols-outlined'>edit</span>
                                </button>
                                <button class='btn btn-eliminarCinturon' data-id='".$row["id_material"]."'>
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
                        <td colspan='2'>No hay resultados</td>
                    </tr>
                ");
            }

        ?>

        </table>
        <?php 
        /*include(ROOT_PATH.'modals/modal-EditarCinturon.php');*/
        include(ROOT_PATH.'View/modals/modals-Agregar/modal-AggMaterial.php')
        ?>
    </main>

    <script src="/LaHerradura/public/crud_extras.js"></script>
    <script src="/LaHerradura/public/modals.js"></script>
    <script src="/LaHerradura/public/alerts.js"></script>
    <script src="/LaHerradura/public/main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
        
        // Configurar HORMAS
        configurarFormularioExtra(
            'form-AggMaterial',
            '/LaHerradura/Controller/CRUD_Extras/CRUD_Materiales/registroMateriales.php', 
            'Material' 
        );
    })
    </script>
</body>
</html>