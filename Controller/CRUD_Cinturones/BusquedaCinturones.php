<?php
// Asegúrate de incluir tu conexión aquí
include '../../Model/conexion.php'; 

// 1. Recibir datos y limpiarlos
$busqueda = isset($_POST['busqueda']) ? $conn->real_escape_string($_POST['busqueda']) : '';
$columna = isset($_POST['columna']) ? $_POST['columna'] : 'Nombre';

// 2. La consulta BASE
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
        INNER JOIN materiales m_adorno ON c.Adorno = m_adorno.id_material";

// 3. Lógica dinámica del WHERE 
$where = "";

if ($busqueda != "") {
    switch ($columna) {
        case 'SKU':
            $where = " WHERE c.SKU LIKE '%$busqueda%'";
            break;
        case 'Precio':
            $where = " WHERE c.Precio LIKE '%$busqueda%'";
            break;
        case 'Material':
            $where = " WHERE m_principal.Nombre LIKE '%$busqueda%'";
            break;
        case 'Adorno':
            $where = " WHERE m_adorno.Nombre LIKE '%$busqueda%'";
            break;
        default:
            $where = " WHERE c.Nombre LIKE '%$busqueda%'";
            break;
    }
}

// Unimos la consulta base con el filtro y agregamos ordenamiento
$sqlFinal = $sql . $where . " ORDER BY c.id_cinturon DESC";

// 4. Ejecutar la consulta
$result = $conn->query($sqlFinal);

// 5. Generar el HTML (Respetando las 8 columnas)
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
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
    echo "<tr><td colspan='8' style='text-align:center;'>No se encontraron cinturones con ese criterio.</td></tr>";
}
?>