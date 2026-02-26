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
        
        <div class="PanelUp">
            <div class="PanelUpAdd">
                <button class="btn btn-agregar" id="btnAgg-Cinturon">
                <span class="material-symbols-outlined" id="IconAdd">add_2</span>Nuevo cinturón</button>
            </div>
            <div class="PanelUpSeach">
                <input type="text" class="TxtBusquedaAdmin" for="BusquedaCinturonAdmin" id="BusquedaCinturonAdmin" placeholder="Buscador"></input>
                <select name="FiltroBusquedaAdminCinturon" class="FiltroBusquedaAdmin" id="FiltroBusquedaAdminCinturon">
                    <option value="Nombre">Nombre</option>
                    <option value="SKU">SKU</option>
                    <option value="Precio">Precio</option>
                    <option value="Material">Material</option>
                    <option value="Adorno">Adorno</option>
                </select>
            </div> 
        </div>

        <table>
            <th>SKU</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Material</th>
            <th>Adorno</th>
            <th>Tamaño</th>
            <th>Acciones</th>
            <th>Estatus</th> <tbody id="tabla-cinturones-body">   
            <?php 
            include (ROOT_PATH.'Model/conexion.php');

            $sql = "SELECT 
            c.id_cinturon,
            c.SKU,
            c.Nombre,
            c.Precio,
            m_principal.Nombre AS Nombre_Material,
            m_adorno.Nombre AS Nombre_Adorno,
            c.Tamaño,
            c.Tallas,
            c.Estado
            FROM cinturones c
            INNER JOIN materiales m_principal ON c.Material = m_principal.id_material
            INNER JOIN materiales m_adorno ON c.Adorno = m_adorno.id_material
            ORDER BY c.id_cinturon DESC";
        
            $result = $conn->query($sql);

            if ($result -> num_rows>0){
                while($row = $result -> fetch_assoc()){
                    echo("
                        <tr>
                            <td>".$row["SKU"]."</td>
                            <td>".$row["Nombre"]."</td>
                            <td>$".$row["Precio"]. "</td>
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

                            <td>
                                <label class='switch'>
                                    <input type='checkbox' class='btn-estado' 
                                        data-id='".$row['id_cinturon']."'
                                        data-tabla='cinturones' 
                                        data-col-id='id_cinturon'
                                        ".($row['Estado'] == 1 ? 'checked' : '').">
                                    <span class='slider round'></span>
                                </label>
                            </td>
                        </tr>"
                    );
                }
            } else {
                echo("
                    <tr>
                        <td colspan='8'>No hay resultados</td>
                    </tr>
                ");
            }
        ?>
        </tbody>
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
    <script src="/LaHerradura/public/EstadoProductos.js"></script>

    <script>
        const inputBusqueda = document.getElementById('BusquedaCinturonAdmin');
        const filtroColumna = document.getElementById('FiltroBusquedaAdminCinturon');
        const cuerpoTabla = document.getElementById('tabla-cinturones-body');

        function buscarEnBaseDeDatos() {
            const texto = inputBusqueda.value;
            const columna = filtroColumna.value;

            const datos = new FormData();
            datos.append('busqueda', texto);
            datos.append('columna', columna);

            fetch('/LaHerradura/Controller/CRUD_Cinturones/BusquedaCinturones.php', {
                method: 'POST',
                body: datos
            })
            .then(response => response.text()) 
            .then(html => {
                cuerpoTabla.innerHTML = html; 
            })
            .catch(error => console.error('Error:', error));
        }

        if(inputBusqueda && filtroColumna) {
            inputBusqueda.addEventListener('keyup', buscarEnBaseDeDatos);
            filtroColumna.addEventListener('change', buscarEnBaseDeDatos);
        }
    </script>
</body>
</html>