<link rel="stylesheet" href="../../css/style-login.css">

<div class="modal" id="modal-Login">
    <div class="modal-content-login">
        <span class="close">&times;</span>
        <h2 id="login-text">Ingresar</h2>
        <div id="cont-form-login">
            <form action="../../../Controller/InicioSesion.php" method="POST" id="loginForm">
                <label for="email">Correo Electrónico</label>
                <br>
                <input class="input-login" type="email" name="Correo" id="Correo" placeholder="Ingresa tu usuario">
                <br>
                <label for="contra">Contraseña</label>
                <br>
                <div class="campo-password">
                    <input  class="input-login" type="password" name="password" id="password" placeholder="Ingresa tu contraseña">
                    <span class="toggle-password" onclick="togglePassword()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                    </span>
                </div>
                <br>
                <span id="olv-contra">¿Olvidaste tu contraseña?</span>
                <br>

                <div id="loginError" style="color: red; margin-top: 10px; text-align: center;"></div>
                
                <div id="buttons">
                    <button type="submit" id="button-iniciar">Iniciar sesión</button>
                    <button type="button" id="buttonCrear">Crear cuenta</button>
                </div>
            </form>
            <?php 
            include('../../modals/modal-CrearCuenta.php')
            ?>
        </div>
    </div>
</div>
<script src="../../../public/iniciosesion.js"></script>