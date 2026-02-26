<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Texanas</title>
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
        <h2 class="titleGestion">Gestión de Texanas</h2>
        <div class="PanelUp">
            <div class="PanelUpAdd">
                <button class="btn btn-agregar" id="btnAgg-Texana">
                <span class="material-symbols-outlined" id="IconAdd">add_2</span>Nueva Texana</button>
            </div>
            <div class="PanelUpSeach">
                <input type="text" class="TxtBusquedaAdmin" for="BusquedaTexanaAdmin" id="BusquedaTexanaAdmin" placeholder="Buscador"></input>
                <select name="FiltroBusquedaAdminTexana" class="FiltroBusquedaAdmin" id="FiltroBusquedaAdminTexana">
                    <option value="Nombre">Nombre</option>
                    <option value="SKU">SKU</option>
                    <option value="Precio">Precio</option>
                    <option value="Color">Color</option>
                    <option value="Copa">Copa</option>
                    <option value="Horma">Horma</option>
                    <option value="Material">Material</option>
                </select>
            </div> 
        </div>

        <table>
            <th>SKU</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Color</th>
            <th>Horma</th>
            <th>Acciones</th>
            <th>Estatus</th>

        <tbody id="tabla-texanas-body">
            <?php 
            include (ROOT_PATH.'Model/conexion.php');
            
            // RECOLECTAR LOS DATOS DE LA BASE DE DATOS
            $sql = "SELECT
            t.SKU,
            t.id_texana,
            t.Nombre,  
            t.Precio,
            c.Nombre AS Nombre_Color, 
            h.Nombre AS Nombre_Horma, 
            cp.Nombre AS Nombre_Copa, 
            t.Tam_Copa,
            t.Tam_ala,
            t.Estado,
            t.Tallas,
            m.Nombre AS Nombre_Material 
            FROM texanas t
            INNER JOIN colores c ON t.Color = c.id_color
            INNER JOIN hormas h ON t.Horma = h.id_horma
            INNER JOIN copas cp ON t.Copa = cp.id_copa
            INNER JOIN materiales m ON t.Material = m.id_material
            ORDER BY t.id_texana DESC";
            
            $result = $conn -> query($sql);

            // MOSTRAR LOS DATOS EN UNA TABLA
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo("
                    <tr>
                        <td>".$row["SKU"]."</td>
                        <td>".$row["Nombre"]."</td>
                        <td>$".$row["Precio"]."</td>
                        <td>".$row["Nombre_Color"]."</td>    
                        <td>".$row["Nombre_Horma"]."</td>   
                        
                        <td>
                            <button class='btn-editar btn-editarTexana' data-id='".$row["id_texana"]."'>
                                <span class='material-symbols-outlined'>edit</span>
                            </button>
                            <button class='btn-eliminar btn-eliminarTexana' data-id='".$row["id_texana"]."'>
                                <span class='material-symbols-outlined'>delete</span>
                            </button>
                            <button class='btn-ver btn-verTexana' data-id='".$row["id_texana"]."'>
                                <span class='material-symbols-outlined'>visibility</span>
                            </button>
                        </td>

                        <td>
                            <label class='switch'>
                                <input type='checkbox' class='btn-estado' 
                                    data-id='".$row['id_texana']."'
                                    data-tabla='texanas' 
                                    data-col-id='id_texana'
                                    ".($row['Estado'] == 1 ? 'checked' : '').">
                                <span class='slider round'></span>
                            </label>
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
        </tbody>
        </table>
        <?php 
        include(ROOT_PATH.'View/modals/modals-Editar/modal-EditarTexana.php');
        include(ROOT_PATH.'View/modals/modals-Agregar/modal-AggTexana.php');
        include(ROOT_PATH .'View/modals/modals-View/modal-ViewProduct.php');
        ?>
    </main>

    <script src="/LaHerradura/public/ViewProducts/viewImages.js"></script>
    <script src="/LaHerradura/public/AdminProducts/adminTexanas.js"></script>
    <script src="/LaHerradura/public/modals.js"></script>
    <script src="/LaHerradura/public/Validations/validacionTexanas.js"></script>
    <script src="/LaHerradura/public/alerts.js"></script>
    <script src="/LaHerradura/public/main.js"></script>
    <script src="/LaHerradura/public/EstadoProductos.js"></script>

    <script>
        const inputBusqueda = document.getElementById('BusquedaTexanaAdmin');
        const filtroColumna = document.getElementById('FiltroBusquedaAdminTexana');
        const cuerpoTabla = document.getElementById('tabla-texanas-body');

        function buscarEnBaseDeDatos() {
            const texto = inputBusqueda.value;
            const columna = filtroColumna.value;

            // Preparamos los datos para enviar
            const datos = new FormData();
            datos.append('busqueda', texto);
            datos.append('columna', columna);

            // Hacemos la petición al archivo PHP
            fetch('/LaHerradura/Controller/CRUD_Texanas/BusquedaTexanas.php', {
                method: 'POST',
                body: datos
            })
            .then(response => response.text()) // Esperamos texto HTML de vuelta
            .then(html => {
                cuerpoTabla.innerHTML = html; // Reemplazamos el contenido de la tabla
            })
            .catch(error => console.error('Error:', error));
        }

        // Eventos: buscar al soltar tecla o cambiar filtro
        inputBusqueda.addEventListener('keyup', buscarEnBaseDeDatos);
        filtroColumna.addEventListener('change', buscarEnBaseDeDatos);
    </script>
</body>
</html>