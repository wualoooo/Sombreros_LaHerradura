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
        <h2 class="titleGestion">Gestión de Sombreros</h2>
        <button class="btn btn-agregar" id="btnAgg-Sombrero">
            <span class="material-symbols-outlined" id="IconAdd">add_2</span>Nuevo sombrero</button>
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
            $sql = "SELECT 
            s.id_sombrero,
            s.Nombre,              -- Este es el nombre del Sombrero
            s.Precio,
            c.Nombre AS Nombre_Color,    -- Renombramos para que no choque
            h.Nombre AS Nombre_Horma,    -- Renombramos
            cp.Nombre AS Nombre_Copa,    -- Renombramos
            s.Tam_Copa,
            s.Tam_ala,
            m.Nombre AS Nombre_Material  -- Renombramos
            FROM sombreros s
            INNER JOIN colores c ON s.Color = c.id_color
            INNER JOIN hormas h ON s.Horma = h.id_horma
            INNER JOIN copas cp ON s.Copa = cp.id_copa
            INNER JOIN materiales m ON s.Material = m.id_material";
            $result = $conn -> query($sql);

            // MOSTRAR LOS DATOS EN UNA TABLA
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo("
                    <tr>
                        <td>".$row["Nombre"]."</td>
                        <td>".$row["Precio"]."</td>
                        <td>".$row["Nombre_Color"]."</td>   
                        <td>".$row["Nombre_Copa"]."</td>    
                        <td>".$row["Nombre_Horma"]."</td>   
                        <td>".$row["Tam_Copa"]."</td>
                        <td>".$row["Tam_ala"]."</td>
                        
                        <td>".$row["Nombre_Material"]."</td> <td>
                            <button class='btn-editar btn-editarSombrero' data-id='".$row["id_sombrero"]."'>
                                <span class='material-symbols-outlined'>edit</span>
                            </button>
                            <button class='btn-eliminar btn-eliminarSombrero' data-id='".$row["id_sombrero"]."'>
                                <span class='material-symbols-outlined'>delete</span>
                            </button>
                            <button class='btn-ver btn-verSombrero' data-id='".$row["id_sombrero"]."'>
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
                        <td colspan='4'>No hay resultados</td>
                    </tr>
                ");
            }

        ?>

        </table>
        <?php 
        include(ROOT_PATH.'View/modals/modals-Editar/modal-EditarSombrero.php');
        include(ROOT_PATH.'View/modals/modals-Agregar/modal-AggSombrero.php');
        include(ROOT_PATH . 'View/modals/modals-View/modal-ViewProduct.php');
        ?>
    </main>

    <script src="/LaHerradura/public/ViewProducts/viewImages.js"></script>
    <script src="/LaHerradura/public/AdminProducts/adminSombreros.js"></script>
    <script src="/LaHerradura/public/modals.js"></script>
    <script src="/LaHerradura/public/Validations/validacionSombreros.js"></script>
    <script src="/LaHerradura/public/alerts.js"></script>
    <script src="/LaHerradura/public/main.js"></script>
</body>
</html>