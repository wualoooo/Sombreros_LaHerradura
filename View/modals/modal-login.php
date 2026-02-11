<link rel="stylesheet" href="/LaHerradura/View/css/style-login.css">

<div class="modal" id="modal-Login">
    <div class="modal-content-login">
        <span class="close">&times;</span>
        <h2 id="login-text">Ingresar</h2>
        <div id="cont-form-login">
            <form action="/LaHerradura/Controller/InicioSesion.php" method="POST" id="loginForm">
                <div class="SpaceLogin">
                    <label class="labelLogin" for="email">Correo Electrónico</label>
                    <br>
                    <br>
                    <input class="input-login" type="email" name="Correo" id="correoLogin" placeholder="Ingresa tu usuario" >
                    <br>
                </div>
                <div class="SpaceLogin">
                    <label class="labelLogin" for="contra">Contraseña</label>
                    <br>
                    <br>
                    <div class="campo-password">
                        <input  class="input-login" type="password" name="Password" id="passwordLogin" placeholder="Ingresa tu contraseña" >
                        <button type="button" class="ButtonEyePassword" onclick="toggleVisibility('passwordLogin')">
                            <span class='material-symbols-outlined' id="buttonEye">visibility</span>
                        </button>
                    </div>
                </div>
                <br>
                <span id="olv-contra">¿Olvidaste tu contraseña?</span>
                <br>

                <div id="loginError" style="color: red; margin-top: 10px; text-align: center;"></div>
                
                <div class="buttons">
                    <button type="submit" id="button-iniciar">Iniciar sesión</button>
                    <button type="button" id="buttonCrear">Crear cuenta</button>
                </div>
            </form>
            <?php 
            include(ROOT_PATH . 'View/modals/modal-CrearCuenta.php')
            ?>
        </div>
    </div>
</div>
