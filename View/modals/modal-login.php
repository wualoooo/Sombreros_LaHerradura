<script src="https://accounts.google.com/gsi/client" async defer></script>
<link rel="stylesheet" href="/LaHerradura/View/css/style-login.css">

<div class="modal" id="modal-Login">
    <div class="modal-content-login">
        <span class="close">&times;</span>
        <img src="/LaHerradura/View/images/herraduraletras.png" alt="Logo Ingresar" id="login-image">
        <div id="cont-form-login">
            <form action="/LaHerradura/Controller/InicioSesion.php" method="POST" id="loginForm">
                <div class="SpaceLogin">
                    <label class="labelLogin" for="correoLogin">Correo Electrónico</label>
                    <input class="input-login" type="email" name="Correo" id="correoLogin" placeholder="Ingresa tu correo" required>
                </div>
                
                <div class="SpaceLogin">
                    <label class="labelLogin" for="passwordLogin">Contraseña</label>
                    <div class="campo-password">
                        <input class="input-login" type="password" name="Password" id="passwordLogin" placeholder="Ingresa tu contraseña" required>
                        <button type="button" class="ButtonEyePassword" onclick="toggleVisibility('passwordLogin')">
                            <span class='material-symbols-outlined' id="buttonEye">visibility</span>
                        </button>
                    </div>
                </div>
                
                <a href="#" id="olv-contra">¿Olvidaste tu contraseña?</a>

                <div id="loginError" style="color: red; margin-top: 10px; text-align: center;"></div>
                
                <div class="buttons">
                    <button type="submit" id="button-iniciar">Iniciar sesión</button>
                    <button type="button" id="buttonCrear">Crear cuenta</button>
                </div>
            </form>
            
            <div class="divisor">
                <span>o</span>
            </div>
        
            <div class="redes-sociales">
                <div id="buttonGoogleContainer" style="width: 100%; display: flex; justify-content: center; margin-top: 5px;"></div>
            </div>

            
        </div>
    </div>
</div>
<?php include(ROOT_PATH . 'View/modals/modal-CrearCuenta.php') ?>

<script>
    function handleCredentialResponse(response) {
        fetch('/LaHerradura/Controller/LoginGoogle.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ token: response.credential })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) { window.location.href = '/LaHerradura/index.php'; } 
            else { document.getElementById('loginError').innerText = "Error al iniciar con Google: " + data.message; }
        })
        .catch(error => console.error('Error:', error));
    }

    window.onload = function () {
        //Inicialización del servicio de Google 
        google.accounts.id.initialize({
            client_id: "143053972635-3supmue5rg7o0o3p32jkmfpl9uv9intv.apps.googleusercontent.com",
            callback: handleCredentialResponse
        });
        //Botón físico en la interfaz
        google.accounts.id.renderButton(
            document.getElementById("buttonGoogleContainer"),
            { theme: "outline", size: "large", width: "100%" } 
        );
    };
</script>