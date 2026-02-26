<?php
include '../../Model/conexion.php'; 

$busqueda = isset($_POST['busqueda']) ? $conn->real_escape_string($_POST['busqueda']) : '';
$columna = isset($_POST['columna']) ? $_POST['columna'] : 'Nombre';

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
        INNER JOIN materiales m_suela ON b.Suela = m_suela.id_material";

$where = "";

if ($busqueda != "") {
    switch ($columna) {
        case 'SKU':
            $where = " WHERE b.SKU LIKE '%$busqueda%'";
            break;
        case 'Talla':
            $where = " WHERE b.Talla LIKE '%$busqueda%'";
            break;
        case 'Precio':
            $where = " WHERE b.Precio LIKE '%$busqueda%'";
            break;
        case 'Material':
            $where = " WHERE m_principal.Nombre LIKE '%$busqueda%'";
            break;
        case 'Suela':
            $where = " WHERE m_suela.Nombre LIKE '%$busqueda%'";
            break;
        default:
            $where = " WHERE b.Nombre LIKE '%$busqueda%'";
            break;
    }
}

$sqlFinal = $sql . $where . " ORDER BY b.id_botin DESC";

$result = $conn->query($sqlFinal);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
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
    echo "<tr><td colspan='8' style='text-align:center;'>No se encontraron botines con ese criterio.</td></tr>";
}
?>