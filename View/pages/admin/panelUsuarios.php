<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
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
        <h2 class="titleGestion">Usuarios registrados</h2>
        <div class="PanelUp">
            <div class="PanelUpSeach">
                    <input type="text" class="TxtBusquedaAdmin" for="" id="" placeholder="Buscador"></input>
                        <select name="FiltroBusquedaAdminSombrero" class="FiltroBusquedaAdmin" id="">
                            <option value="">Usuario</option>
                            <option value="">Fecha</option>
                            <option value="">Pedido</option>
                            <option value="">Telefono</option>
                            <option value="">Correo</option>
                        </select>
            </div>
        </div>
        <table>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Direccion de envio</th>
            <th>Telefono</th>
            <th>Pedidos relizados</th>

            <?php 
            include (ROOT_PATH.'Model/conexion.php');

            $sql = "SELECT id_usuario, Nombre, Apellidos, Correo FROM usuarios";
            $result = $conn -> query($sql);
            if ($result -> num_rows>0){

                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["Nombre"] . " " . $row["Apellidos"] . "</td>
                            <td>" . $row["Correo"] . "</td>";

                    $idUsuario = $row["id_usuario"];
                    $sqlDir = "SELECT cp, estado, municipio, colonia, calle, numero, referencia, telefono FROM direcciones WHERE id_usuario = '$idUsuario'";
                    $resultDir = $conn->query($sqlDir);

                    if ($resultDir && $resultDir->num_rows > 0) {
                        $rowDir = $resultDir->fetch_assoc();
                        echo "<td> " . $rowDir["colonia"] . ", " . $rowDir["calle"] . " " . $rowDir["numero"] . " <br> " .$rowDir["municipio"] . ", " . $rowDir["estado"] . "</td>
                            <td>" . $rowDir["telefono"] . "</td>";
                    } else {
                        echo "<td>No hay dirección</td><td>---</td>";
                    }

                    $sqlPed = "SELECT codigo_rastreo FROM pedidos WHERE id_usuario = '$idUsuario'";

                    $resultPed = $conn->query($sqlPed);
                    if ($resultPed && $resultPed->num_rows > 0) {
                        echo "<td>";
                        while($rowPed = $resultPed->fetch_assoc()) {
                            echo "* " . $rowPed["codigo_rastreo"] . "<br>";
                        }
                        echo "</td>";
                    } else {
                        echo "<td>No hay Pedidos</td>";
                    }

                    echo "</tr>";

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

    </main>

    <script src="/LaHerradura/public/alerts.js"></script>
    <script src="/LaHerradura/public/main.js"></script> 
    
</body>
</html>