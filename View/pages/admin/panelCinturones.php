<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cinturones</title>
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
        include(ROOT_PATH.'View/includes/header-admin.php')
        ?>
    </header>
    <main>
        <h2 class="titleGestion">Gestión de Cinturones</h2>
        <button class="btn btn-agregar" id="btnAgg-Cinturon">
            <span class="material-symbols-outlined" id="IconAdd">add_2</span>Nuevo cinturón</button>
        <table>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Material</th>
            <th>Adorno</th>
            <th>Tamaño</th>
            <th>Acciones</th>
        <tbody id="tabla-cinturones-body">   
            <?php 
            include (ROOT_PATH.'Model/conexion.php');

            $sql = "SELECT 
            c.id_cinturon,
            c.Nombre,
            c.Precio,
            m_principal.Nombre AS Nombre_Material,
            m_adorno.Nombre AS Nombre_Adorno,
            c.Tamaño
            FROM cinturones c
            INNER JOIN materiales m_principal ON c.Material = m_principal.id_material
            INNER JOIN materiales m_adorno ON c.Adorno = m_adorno.id_material";
        
            $result = $conn->query($sql);

            if ($result -> num_rows>0){
                while($row = $result -> fetch_assoc()){
                    echo("
                        <tr>
                            <td>".$row["Nombre"]."</td>
                            <td>".$row["Precio"]. "</td>
                            <td>".$row["Nombre_Material"]. "</td>
                            <td>".$row["Nombre_Adorno"]."</td>
                            <td>".$row["Tamaño"]."</td>
                            <td>
                            <button class='btn-editar btn-editarCinturon' data-id='".$row["id_cinturon"]."'>
                                <span class='material-symbols-outlined'>edit</span>
                            </button>
                            <button class='btn-eliminar btn-eliminarCinturon' data-id='".$row["id_cinturon"]."'>
                                <span class='material-symbols-outlined'>delete</span>
                            </button>
                            <button class='btn-ver btn-verCinturon' data-id='".$row["id_cinturon"]."'>
                                <span class='material-symbols-outlined'>visibility</span>
                            </button>
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

        </table>
        <?php 
        include(ROOT_PATH.'View/modals/modals-Editar/modal-EditarCinturon.php');
        include(ROOT_PATH.'View/modals/modals-Agregar/modal-AggCinturon.php');
        include(ROOT_PATH.'View/modals/modals-View/modal-ViewCinturones.php');
        ?>
    </main>

    <script src="/LaHerradura/public/ViewProducts/viewImages.js"></script>
    <script src="/LaHerradura/public/AdminProducts/adminCinturones.js"></script>
    <script src="/LaHerradura/public/modals.js"></script>
    <script src="/LaHerradura/public/Validations/validacionCinturones.js"></script>
    <script src="/LaHerradura/public/alerts.js"></script>
    <script src="/LaHerradura/public/main.js"></script>
</body>
</html>