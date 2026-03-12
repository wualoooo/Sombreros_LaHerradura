<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de pedidos</title>
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
        <h2 class="titleGestion">Gestión de Pedidos</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre usuario</th>
                    <th>Dirección de envío</th>
                    <th>Teléfono</th>
                    <th>Código de rastreo</th>
                    <th>Productos</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Estado del pedido</th>
                </tr>
            </thead>
        <tbody id="tabla-pedidos-body">
            
            <?php 
    include (ROOT_PATH.'Model/conexion.php');

    // 1. OBTENEMOS TODOS LOS ESTADOS DESDE TU TABLA 
    $sqlEstados = "SELECT id_status, status FROM estatus"; 
    $resultEstados = $conn->query($sqlEstados);
    
    $lista_estados = [];
    if ($resultEstados && $resultEstados->num_rows > 0) {
        while($rowEst = $resultEstados->fetch_assoc()) {
            
            $lista_estados[$rowEst['id_status']] = $rowEst['status'];
        }
    }
    
    $sqlSELECT = "SELECT
                p.id_pedido,
                p.id_usuario,
                CONCAT (u.Nombre,' ', u.Apellidos) AS Nombre_Usuario, 
                CONCAT ( d.colonia,', ', d.calle,', ', d.numero) AS Direccion_envio1,
                CONCAT ( d.municipio,', ', d.estado,', ', d.cp) AS Direccion_envio2,
                d.referencia,
                d.telefono, 
                p.codigo_rastreo, 
                p.productos, 
                p.total, 
                p.estado_envio ,
                p.fecha,
                e.status
                FROM pedidos as p 
                INNER JOIN usuarios as u 
                ON p.id_usuario = u.id_usuario 
                INNER JOIN direcciones as d 
                ON p.id_direccion = d.id_direccion 
                INNER JOIN estatus as e 
                ON p.estado_envio = e.id_status
                ORDER BY id_pedido DESC;";

    $result = $conn->query($sqlSELECT);

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["Nombre_Usuario"]."</td>";
            echo "<td>
                    ".$row["Direccion_envio1"]."
                    <br>
                    ".$row["Direccion_envio2"]."
                    <br>
                    Ref: ".$row["referencia"]."
                    </td>";
            echo "<td>".$row["telefono"]."</td>";
            echo "<td>".$row["codigo_rastreo"]."</td>";
            
            echo "<td>";
            $lista_productos = json_decode($row["productos"], true);
            if(is_array($lista_productos)){
                echo "<ul style='margin:0; padding-left:20px; text-align:left; font-size: 0.9em;'>";
                foreach($lista_productos as $item) {
                    echo "<li><b>".$item['cantidad']."x</b> ".$item['nombre']." (Talla: ".$item['talla'].") - $".$item['precio']."</li>";
                }
                echo "</ul>";
            } else {
                echo "Error al leer productos";
            }
            echo "</td>";
            
            echo "<td>$".$row["total"]."</td>";
            echo "<td>".$row["fecha"]."</td>";

            echo "<td>";
            echo "<select class='select-estado-pedido' data-id='".$row["id_pedido"]."' style='padding: 5px; border-radius: 5px; font-weight: bold; cursor: pointer;'>";
            
            foreach($lista_estados as $id_status => $nombre_status) {
                
                $selected = ($row["estado_envio"] == $id_status) ? "selected" : "";
                echo "<option value='$id_status' $selected>$nombre_status</option>";
            }
            
            echo "</select>";
            echo "</td>";
        }
    }
    else {
        echo("
            <tr>
                <td colspan='7'>No hay resultados</td>
            </tr>
        ");
    }
?>
        </tbody>
        </table>
    </main>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    
    // Detectamos cualquier cambio en los menús desplegables de la tabla
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('select-estado-pedido')) {
            
            const idPedido = e.target.getAttribute('data-id');
            const nuevoEstado = e.target.value;

            // Desactivamos el select temporalmente para que no den doble clic
            e.target.disabled = true;

            const datos = {
                id_pedido: idPedido,
                estado: nuevoEstado
            };

            // Enviamos el nuevo estado a nuestro archivo PHP
            fetch('/LaHerradura/Controller/ActualizarEstadoPedido.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(datos)
            })
            .then(response => response.json())
            .then(data => {
                e.target.disabled = false; // Reactivamos el menú

                if (data.success) {
                    // Mostrar una notificación "Toast" elegante en la esquina superior derecha
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Estado actualizado',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    Swal.fire('Error', data.message || 'No se pudo actualizar', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                e.target.disabled = false;
                Swal.fire('Error', 'Problema de conexión con el servidor', 'error');
            });
        }
    });
});
</script>
</body>
</html>