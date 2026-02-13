<?php
session_start();
// Seguridad: Si no hay ID de usuario, para afuera
if (!isset($_SESSION['id_usuario'])) {
    header("Location: /LaHerradura/index.php");
    exit();
}

define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
require(ROOT_PATH . 'Model/conexion.php');

$id_usuario = $_SESSION['id_usuario'];

// --- CONSULTA 1: DATOS DEL USUARIO ---
$sqlUser = "SELECT * FROM usuarios WHERE id_usuario = ?";
$stmt = $conn->prepare($sqlUser);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();


// --- CONSULTA 2: PEDIDOS ---
$sqlPedidos = "SELECT p.*, e.status
                FROM pedidos as p
                JOIN estatus e ON e.id_status = p.estado_envio
                WHERE p.id_usuario = ? 
                ORDER BY fecha DESC";
$stmtP = $conn->prepare($sqlPedidos);
$stmtP->bind_param("i", $id_usuario);
$stmtP->execute();
$resultPedidos = $stmtP->get_result();
// Guardamos en array para recorrer después
$pedidos = [];
while($row = $resultPedidos->fetch_assoc()) { $pedidos[] = $row; }
$stmtP->close();

// --- CONSULTA 3: DIRECCIONES ---
$sqlDir = "SELECT * FROM direcciones WHERE id_usuario = ?";
$stmtD = $conn->prepare($sqlDir);
$stmtD->bind_param("i", $id_usuario);
$stmtD->execute();
$resultDir = $stmtD->get_result();
$direcciones = [];
while($row = $resultDir->fetch_assoc()) { $direcciones[] = $row; }
$stmtD->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Cuenta - La Herradura</title>
    <link rel="stylesheet" href="/LaHerradura/View/css/style-userAccount.css"> <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>
<body>

    <header>
        <?php include(ROOT_PATH . 'View/includes/header.php'); ?>
    </header>

    <?php include(ROOT_PATH . 'View/modals/modal-AggDireccion.php'); ?>
    <div class="perfil-container">
        
        <aside class="perfil-sidebar">
            <?php 
                $rutaImg = '/LaHerradura/uploads/users/';
                $imgDef = '/LaHerradura/View/images/default-user.png';
                $foto = $user['foto_perfil'] ?? null;
                $src = ($foto && file_exists($_SERVER['DOCUMENT_ROOT'].$rutaImg.$foto)) ? $rutaImg.$foto : $imgDef;
            ?>
            <img src="<?php echo $src; ?>" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #8B0000; margin-bottom: 1rem;">
            <h4 style="margin: 0;"><?php echo htmlspecialchars($user['Nombre']); ?></h4>
            <p style="color: #888; font-size: 0.9rem;"><?php echo htmlspecialchars($user['Correo']); ?></p>
            
            <div class="menu-lateral" style="margin-top: 2rem;">
                <button class="active" onclick="mostrarTab('info')">
                    <span class="material-symbols-outlined" style="vertical-align: bottom;">person</span> Mis Datos
                </button>
                <button onclick="mostrarTab('pedidos')">
                    <span class="material-symbols-outlined" style="vertical-align: bottom;">shopping_bag</span> Mis Pedidos
                </button>
                <button onclick="mostrarTab('direcciones')">
                    <span class="material-symbols-outlined" style="vertical-align: bottom;">location_on</span> Direcciones
                </button>
                <a href="/LaHerradura/Controller/cerrarSesion.php" style="text-decoration: none;">
                    <button style="color: #dc3545;">
                        <span class="material-symbols-outlined" style="vertical-align: bottom;">logout</span> Cerrar Sesión
                    </button>
                </a>
            </div>
        </aside>

        <main class="perfil-content">
            
            <div id="info" class="tab-content active">
                <h2 style="border-bottom: 2px solid #8B0000; padding-bottom: 10px;">Información Personal</h2>
                
                <div style="text-align: center; margin: 2rem 0;">
                    <label for="upload-profile-pic" class="profile-pic-container" title="Cambiar foto">
                        <img src="<?php echo $src; ?>" alt="Foto" class="profile-pic-img" id="user-profile-image-big">
                        <div class="profile-pic-overlay">
                            <span class="material-symbols-outlined">photo_camera</span>
                        </div>
                    </label>
                    <input type="file" id="upload-profile-pic" style="display:none;" accept="image/*">
                </div>

                <div class="info-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label style="color: #666; font-size: 0.9rem;">Nombre</label>
                        <p style="font-weight: bold; font-size: 1.1rem; margin-top: 5px;">
                            <?php echo htmlspecialchars($user['Nombre'] . ' ' . $user['Apellido_Pat'] . ' ' . $user['Apellido_Mat']); ?>
                        </p>
                    </div>
                    <div>
                        <label style="color: #666; font-size: 0.9rem;">Correo</label>
                        <p style="font-weight: bold; font-size: 1.1rem; margin-top: 5px;">
                            <?php echo htmlspecialchars($user['Correo']); ?>
                        </p>
                    </div>
                </div>
            </div>

            <div id="pedidos" class="tab-content">
                <h2 style="border-bottom: 2px solid #8B0000; padding-bottom: 10px;">Historial de Pedidos</h2>
                
                <?php if (count($pedidos) > 0): ?>
                    <table class="tabla-perfil">
                        <thead>
                            <tr>
                                <th># Pedido</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($pedidos as $p): 
                                
                            ?>
                            <tr>
                                <td>#<?php echo $p['id_pedido']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($p['fecha'])); ?></td>
                                <td>$<?php echo number_format($p['total'], 2); ?></td>
                                <td><span class=""><?php echo $p['status']; ?></span></td>
                                <td><button class="btn-ver">Ver</button></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div style="text-align: center; padding: 3rem;">
                        <span class="material-symbols-outlined" style="font-size: 3rem; color: #ccc;">shopping_cart_off</span>
                        <p>Aún no has realizado compras.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div id="direcciones" class="tab-content">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #8B0000; padding-bottom: 10px; margin-bottom: 20px;">
                    <h2 style="margin: 0;">Mis Direcciones</h2>
                    <button class="Botonverde" id="AgregarDireccion">
                        + Nueva Dirección
                    </button>
                </div>

                <div class="grid-direcciones">
                    <div class="card-direccion">
                            <p>
                                Recoger en tienda
                                Carretera Ixmiquilpan-Tasquillo km 25
                                Panales, Ixmiquilpan 42326
                            </p>
                        </div>
                    <?php if (count($direcciones) > 0): ?>
                        <?php foreach($direcciones as $dir): ?>
                        <div class="card-direccion">
                            <p>
                                <?php echo htmlspecialchars($dir['colonia'] . ', ' . $dir['calle'].', '.$dir['municipio'].', '.$dir['estado'].', '.$dir['cp']); ?>
                            </p>
                            <button style="color: #dc3545; background: none; border: none; cursor: pointer; margin-top: 10px;">Eliminar</button>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No tienes direcciones guardadas.</p>
                    <?php endif; ?>
                </div>
            </div>

        </main>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/LaHerradura/public/alerts.js"></script>
    <script>
        // Lógica simple para cambiar de pestañas
        function mostrarTab(tabId) {
            // 1. Ocultar todos
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.menu-lateral button').forEach(el => el.classList.remove('active'));
            
            // 2. Mostrar el seleccionado
            document.getElementById(tabId).classList.add('active');
            
            // 3. Activar botón del menú (truco para encontrar el botón que se clickeó)
            // En un caso real, pasaríamos 'this' como argumento, pero para rápido:
            const botones = document.querySelectorAll('.menu-lateral button');
            if(tabId === 'info') botones[0].classList.add('active');
            if(tabId === 'pedidos') botones[1].classList.add('active');
            if(tabId === 'direcciones') botones[2].classList.add('active');
        }

        // Lógica de Foto de Perfil (Versión Inline para esta página)
        document.getElementById('upload-profile-pic').addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('profile_pic', file);

            fetch('/LaHerradura/Controller/updateProfilePic.php', {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    // Actualizar imagen grande y la del sidebar
                    document.getElementById('user-profile-image-big').src = data.newSrc;
                    location.reload(); // Recargar para ver cambios globales
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            });
        });
    </script>

</body>
        <script src="/LaHerradura/public/modals.js" defer></script>
        <script src="/LaHerradura/public/main.js" defer></script>
        <script src="/LaHerradura/public/alerts.js" defer></script>
        <script src="/LaHerradura/public/Validations/ValidacionRegistro.js" defer></script>
        <script src="/LaHerradura/public/Validations/ValidacionDirecciones.js"></script>
        <script src="/LaHerradura/public/userProfile.js"></script>
        <script src="/LaHerradura/public/carrito.js" defer></script>
        <script src="/LaHerradura/public/Checkout.js" defer></script>

</html>