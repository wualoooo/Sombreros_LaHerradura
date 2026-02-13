<?php
// Asegúrate de incluir tu conexión aquí
include '../../Model/conexion.php'; 

// 1. Recibir datos y limpiarlos para evitar errores de comillas
$busqueda = isset($_POST['busqueda']) ? $conn->real_escape_string($_POST['busqueda']) : '';
$columna = isset($_POST['columna']) ? $_POST['columna'] : 'nombre';

// 2. La consulta BASE (Copiada exactamente de tu Imagen 1)
// Nota: Dejamos el espacio al final de la cadena para que no se pegue con el WHERE
$sql = "SELECT 
            s.id_sombrero,
            s.Nombre,
            s.Precio,
            c.Nombre AS Nombre_Color,
            h.Nombre AS Nombre_Horma,
            cp.Nombre AS Nombre_Copa,
            s.Tam_Copa,
            s.Tam_ala,
            m.Nombre AS Nombre_Material
        FROM sombreros s
        INNER JOIN colores c ON s.Color = c.id_color
        INNER JOIN hormas h ON s.Horma = h.id_horma
        INNER JOIN copas cp ON s.Copa = cp.id_copa
        INNER JOIN materiales m ON s.Material = m.id_material ";

// 3. Lógica dinámica del WHERE (Usando concatenación con punto '.')
// IMPORTANTE: Usamos 'c.Nombre' en lugar de 'Nombre_Color' para filtrar
$where = "";

if ($busqueda != "") {
    switch ($columna) {
        case 'Precio':
            $where = "WHERE s.Precio LIKE '%$busqueda%'";
            break;
        case 'Color':
            $where = "WHERE c.Nombre LIKE '%$busqueda%'";
            break;
        case 'Horma':
            $where = "WHERE h.Nombre LIKE '%$busqueda%'";
            break;
        case 'Material':
            $where = "WHERE m.Nombre LIKE '%$busqueda%'";
            break;
        default:
            $where = "WHERE s.Nombre LIKE '%$busqueda%'";
            break;
    }
}

// Unimos la consulta base con el filtro
$sqlFinal = $sql . $where;

// 4. Ejecutar la consulta (Estilo MySQLi compatible con tu Imagen 1)
$result = $conn->query($sqlFinal);

// 5. Generar el HTML (Idéntico a tu Imagen 1)
if ($result && $result->num_rows > 0) {
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
} else {
    // Si no hay resultados, mostramos un mensaje bonito
    echo "<tr><td colspan='10' style='text-align:center;'>No se encontraron sombreros con ese criterio.</td></tr>";
}
?>