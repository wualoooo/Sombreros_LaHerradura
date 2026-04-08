<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Copas</title>
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
        <h2 class="titleGestion">Gestión de Copas</h2>
        <div class="PanelUp">
            <div class="PanelUpAdd">
                <button class="btn btn-agregar" id="btnAgg-Copa">
                    <span class="material-symbols-outlined" id="IconAdd">add_2</span>Nueva Copa</button>
            </div>
            <div class="PanelUpSeach">
                <input type="text" class="TxtBusquedaAdmin" for="" id="" placeholder="Buscador"></input>
                    <select name="FiltroBusquedaAdminSombrero" class="FiltroBusquedaAdmin" id="">
                        <option value="">Nombre Copa</option>
                        <option value="">Sombreros</option>
                        <option value="">Texanas</option>
                        <option value="">Cinturones</option>
                        <option value="">Botines</option>
                    </select>
            </div>
        </div>

        <table>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        <tbody id="tabla-copas-body">   
            <?php 
            include (ROOT_PATH.'Model/conexion.php');

            $sql = "SELECT id_copa, Nombre FROM copas ORDER BY id_copa";
            $result = $conn -> query($sql);

            if ($result -> num_rows>0){
                while($row = $result -> fetch_assoc()){
                    echo("
                        <tr>
                            <td>".$row["id_copa"]."</td>
                            <td>".$row["Nombre"]."</td>
                            <td>
                                <button class='btn-editar btn-editarCopa' data-id='".$row["id_copa"]."'>
                                    <span class='material-symbols-outlined'>edit</span>
                                </button>
                                <button class='btn-eliminar btn-eliminarCopa' data-id='".$row["id_copa"]."'>
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
        include(ROOT_PATH.'View/modals/modals-Agregar/modal-AggCopa.php')
        ?>
    </main>

    <script src="/LaHerradura/public/crud_extras.js"></script>
    <script src="/LaHerradura/public/modals.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
        
        // Configurar HORMAS
        configurarFormularioExtra(
            'form-AggCopa',
            '/LaHerradura/Controller/CRUD_Extras/CRUD_Copas/registroCopas.php', 
            'Copa' 
        );
    })
    </script>
</body>
</html>