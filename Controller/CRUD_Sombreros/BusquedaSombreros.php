<?php
include '../../Model/conexion.php'; 
$busqueda = isset($_POST['busqueda']) ? $conn->real_escape_string($_POST['busqueda']) : '';
$columna = isset($_POST['columna']) ? $_POST['columna'] : 'nombre';

$sql = "SELECT 
            s.SKU,
            s.id_sombrero,
            s.Nombre,
            s.Precio,
            c.Nombre AS Nombre_Color,
            h.Nombre AS Nombre_Horma,
            cp.Nombre AS Nombre_Copa,
            s.Tam_Copa,
            s.Tam_ala,
            s.Tallas,
            s.Estado,
            m.Nombre AS Nombre_Material
        FROM sombreros s
        INNER JOIN colores c ON s.Color = c.id_color
        INNER JOIN hormas h ON s.Horma = h.id_horma
        INNER JOIN copas cp ON s.Copa = cp.id_copa
        INNER JOIN materiales m ON s.Material = m.id_material";

$where = "";

if ($busqueda != "") {
    switch ($columna) {
        case 'SKU':
            $where = " WHERE s.SKU LIKE '%$busqueda%'";
            break;
        case 'Precio':
            $where = " WHERE s.Precio LIKE '%$busqueda%'";
            break;
        case 'Color':
            $where = " WHERE c.Nombre LIKE '%$busqueda%'";
            break;
        case 'Horma':
            $where = " WHERE h.Nombre LIKE '%$busqueda%'";
            break;
        case 'Copa':
            $where = " WHERE cp.Nombre LIKE '%$busqueda%'";
            break;
        case 'Material':
            $where = " WHERE m.Nombre LIKE '%$busqueda%'";
            break;
        default:
            $where = " WHERE s.Nombre LIKE '%$busqueda%'";
            break;
    }
}

$sqlFinal = $sql . $where . " ORDER BY s.id_sombrero DESC";

$result = $conn->query($sqlFinal);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo("
                    <tr>
                        <td>".$row["SKU"]."</td>
                        <td>".$row["Nombre"]."</td>
                        <td>$".$row["Precio"]."</td>
                        <td>".$row["Nombre_Color"]."</td>    
                        <td>".$row["Nombre_Horma"]."</td>   
                        
                        <td>
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
                        <td>
                            <label class='switch'>
                                <input type='checkbox' class='btn-estado' 
                                    data-id='".$row['id_sombrero']."'
                                    data-tabla='sombreros' 
                                    data-col-id='id_sombrero'
                                    ".($row['Estado'] == 1 ? 'checked' : '').">
                                <span class='slider round'></span>
                            </label>
                        </td>
                    </tr>"
                );
    }
} else {
    echo "<tr><td colspan='7' style='text-align:center;'>No se encontraron sombreros con ese criterio.</td></tr>";
}
?>