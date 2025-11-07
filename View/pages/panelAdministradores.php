<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administradores</title>
    <link rel="stylesheet" href="../css/style-Panels.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
</head>
</head>
<body>
    <header>
        <?php 
        include('../includes/header-admin.php')
        ?>
    </header>
    <main>
        <h2 class="titleGestion">Gestión de Administradores</h2>
        <button class="btn btn-agregar" id="btnAgg-Admin">Agregar nuevo administrador</button>
        <table>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Correo</th>
            <th>Fecha de adidción</th>
            <th>Rol</th>
            <th>Acciones</th>
        <tbody>
            <?php 
        include ('../../Model/conexion.php');

            $sql = "SELECT id_admin, Nombre, Apellido_Pat, Apellido_Mat, Correo, Fecha_Adicion, Rol FROM administradores";
            $result = $conn -> query($sql);

            if ($result -> num_rows>0){

                while($row = $result -> fetch_assoc()){
                    echo("
                        <tr>
                            <td>".$row["id_admin"]."</td>
                            <td>".$row["Nombre"]."</td>
                            <td>".$row["Apellido_Pat"]. " ".$row["Apellido_Mat"]."</td>
                            <td>".$row["Correo"]."</td>
                            <td>".$row["Fecha_Adicion"]."</td>
                            <td>".$row["Rol"]."</td>
                            <td>
                                <button class='btn btn-editar'>Editar</button>
                                <button class='btn btn-eliminar'>Eliminar</button>
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
        </tbody>
        </table>
        <?php 
        include('../modals/modal-RegistroAdmin.php')
        ?>
    </main>
    <script src="../../public/modals.js"></script>
    <script src="../../public/mostrar-password.js"></script>
</body>
</html>