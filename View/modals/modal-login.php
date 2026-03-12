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
                <!--<button type="button" class="BotonFacebook">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" style="margin-right: 10px;">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Continuar con Facebook
                </button> -->

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
        google.accounts.id.initialize({
            client_id: "143053972635-3supmue5rg7o0o3p32jkmfpl9uv9intv.apps.googleusercontent.com",
            callback: handleCredentialResponse
        });
        google.accounts.id.renderButton(
            document.getElementById("buttonGoogleContainer"),
            { theme: "outline", size: "large", width: "100%" } 
        );
    };
</script>