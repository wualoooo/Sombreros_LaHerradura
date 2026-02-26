<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Botines</title>
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
        <h2 class="titleGestion">Gestión de Botines</h2>
        
        <div class="PanelUp">
            <div class="PanelUpAdd">
                <button class="btn btn-agregar" id="btnAgg-Botin">
                <span class="material-symbols-outlined" id="IconAdd">add_2</span>Nuevo botín</button>
            </div>
            <div class="PanelUpSeach">
                <input type="text" class="TxtBusquedaAdmin" for="BusquedaBotinAdmin" id="BusquedaBotinAdmin" placeholder="Buscador"></input>
                <select name="FiltroBusquedaAdminBotin" class="FiltroBusquedaAdmin" id="FiltroBusquedaAdminBotin">
                    <option value="Nombre">Nombre</option>
                    <option value="SKU">SKU</option>
                    <option value="Talla">Talla</option>
                    <option value="Precio">Precio</option>
                    <option value="Material">Material</option>
                    <option value="Suela">Suela</option>
                </select>
            </div> 
        </div>

        <table>
            <th>SKU</th>
            <th>Nombre</th>
            <th>Talla</th>
            <th>Material</th>
            <th>Suela</th>
            <th>Precio</th>
            <th>Acciones</th>
            <th>Estatus</th>

        <tbody id="tabla-botines-body">   
            <?php 
            include (ROOT_PATH. 'Model/conexion.php');

            $sql = "SELECT 
            b.id_botin,
            b.SKU,
            b.Nombre,
            b.Talla,
            b.Precio,
            b.Estado,
            m_principal.Nombre AS Nombre_Material,
            m_suela.Nombre AS Nombre_Suela
            FROM botines b
            INNER JOIN materiales m_principal ON b.Material = m_principal.id_material
            INNER JOIN materiales m_suela ON b.Suela = m_suela.id_material
            ORDER BY b.id_botin DESC";
            
            $result = $conn -> query($sql);

            if ($result -> num_rows>0){
                while($row = $result -> fetch_assoc()){
                    echo("
                        <tr>
                            <td>".$row["SKU"]."</td>
                            <td>".$row["Nombre"]."</td>
                            <td>".$row["Talla"]. "</td>
                            <td>".$row["Nombre_Material"]. "</td>
                            <td>".$row["Nombre_Suela"]."</td>
                            <td>$".$row["Precio"]."</td>
                            <td>
                                <button class='btn-editar btn-editarBotin' data-id='".$row["id_botin"]."'>
                                <span class='material-symbols-outlined'>edit</span>
                            </button>
                            <button class='btn-eliminar btn-eliminarBotin' data-id='".$row["id_botin"]."'>
                                <span class='material-symbols-outlined'>delete</span>
                            </button>
                            <button class='btn-ver btn-verBotin' data-id='".$row["id_botin"]."'>
                                <span class='material-symbols-outlined'>visibility</span>
                            </button>
                            </td>
                            <td>
                                <label class='switch'>
                                    <input type='checkbox' class='btn-estado' 
                                        data-id='".$row['id_botin']."'
                                        data-tabla='botines' 
                                        data-col-id='id_botin'
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
        include(ROOT_PATH.'View/modals/modals-Editar/modal-EditarBotin.php');
        include(ROOT_PATH.'View/modals/modals-Agregar/modal-AggBotin.php');
        include(ROOT_PATH.'View/modals/modals-View/modal-ViewBotines.php');
        ?>
    </main>

    <script src="/LaHerradura/public/ViewProducts/viewImages.js"></script>
    <script src="/LaHerradura/public/AdminProducts/adminBotines.js"></script>
    <script src="/LaHerradura/public/modals.js"></script>
    <script src="/LaHerradura/public/Validations/validacionBotines.js"></script>
    <script src="/LaHerradura/public/alerts.js"></script>
    <script src="/LaHerradura/public/main.js"></script>
    <script src="/LaHerradura/public/EstadoProductos.js"></script>

    <script>
        const inputBusqueda = document.getElementById('BusquedaBotinAdmin');
        const filtroColumna = document.getElementById('FiltroBusquedaAdminBotin');
        const cuerpoTabla = document.getElementById('tabla-botines-body');

        function buscarEnBaseDeDatos() {
            const texto = inputBusqueda.value;
            const columna = filtroColumna.value;

            const datos = new FormData();
            datos.append('busqueda', texto);
            datos.append('columna', columna);

            fetch('/LaHerradura/Controller/CRUD_Botines/BusquedaBotines.php', {
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