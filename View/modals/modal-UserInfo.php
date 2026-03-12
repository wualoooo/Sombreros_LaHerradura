<link rel="stylesheet" href="/LaHerradura/View/css/style-login.css">
<link rel="stylesheet" href="/LaHerradura/View/css/style-UserInfo.css">

<div class="modal" id="modal-UserInfo">
    <div class="modal-content-login" style="height: auto; padding-bottom: 2rem;">
        <span class="close">&times;</span>
        
        <h2 id="login-text" style="text-align: center; margin-bottom: 0;">Mi Perfil</h2>
        
        <div id="cont-form-login" style="text-align: center;">
            
            <label for="upload-profile-pic" class="profile-pic-container" title="Cambiar foto de perfil">
                <?php
                $rutaUserImg = '/LaHerradura/uploads/users/';
                $imgDefault = '/LaHerradura/View/images/avatar.png';
                $fotoActual = $_SESSION['user_foto'] ?? null;

                if ($fotoActual) {
                    if (strpos($fotoActual, 'http://') === 0 || strpos($fotoActual, 'https://') === 0) {
                        $srcImagen = $fotoActual;
                    } else if (file_exists($_SERVER['DOCUMENT_ROOT'] . $rutaUserImg . $fotoActual)) {
                        $srcImagen = $rutaUserImg . $fotoActual;
                    } else {
                        $srcImagen = $imgDefault;
                    }
                } else {
                    $srcImagen = $imgDefault;
                }
                ?>
                <img src="<?php echo htmlspecialchars($srcImagen); ?>" 
                    alt="Foto de perfil" 
                    class="profile-pic-img" 
                    id="user-profile-image" 
                    referrerpolicy="no-referrer">
                
                <!--<div class="profile-pic-overlay">Cambiar foto</div>-->
            </label>

            <input type="file" id="upload-profile-pic" accept="image/png, image/jpeg, image/jpg, image/webp">

            <h3 style="margin-top: 0.5rem; font-size: clamp(1.4rem, 4vw, 1.8rem); color: #333;">
                <?php echo htmlspecialchars($_SESSION['user_nombre'] ?? 'Usuario'); ?>
            </h3>
            
            <p style="color: #666; margin-bottom: 2rem; font-size: clamp(0.9rem, 3vw, 1.1rem);">
                <?php echo htmlspecialchars($_SESSION['user_email'] ?? ''); ?>
            </p>

            <div class="buttons">
                <button type="button" class="botonesUser Botonverde">
                    <a href="/LaHerradura/View/pages/user/UserAccount.php">
                        Cuenta <span class="material-symbols-outlined">open_in_new</span>
                    </a>
                </button>
                <button type="button" class="botonesUser Botonrojo">
                    <a href="/LaHerradura/Controller/cerrarSesion.php">
                        Cerrar Sesion <span class="material-symbols-outlined" id="Logout">logout</span>
                    </a>
                </button>
            </div>
        </div>
    </div>
</div>