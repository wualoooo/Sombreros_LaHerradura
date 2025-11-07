<link rel="stylesheet" href="../css/style-CrearCuenta.css">

<div class="modal-Cc" id="modal-CrearCuenta">
    <div class="modal-content-cc">
        <span class="close">&times;</span>
        <h2 id="CrearCuenta-text">Crear cuenta</h2>
        <div class="cont-form-cc">
            <form class="resgitrer-form" id="form-registro" action="../../Controller/registrosUsuarios.php" method="POST">
                <label for="name">Nombre</label>
                <br>
                <input class="input-register" type="text" name="Nombre" id="Nombre" placeholder="Ingresa tu nombre">
                <br>
                <label for="ap_pat">Apellido Paterno</label>
                <br>
                <input class="input-register" type="text" name="Apellido_Pat" id="Apellido_Pat" placeholder="Ingresa tu apellido paterno">
                <br>
                <label for="ap_mat"> Apellido Materno</label>
                <br>
                <input class="input-register" type="text" name="Apellido_Mat" id="Apellido_Mat" placeholder="Ingresa tu apellido materno">
                <label for="email">Correo Electrónico</label>
                <br>
                <input class="input-register" type="email" name="CorreoRegistro" id="CorreoRegistro" placeholder="Ingresa tu correo">
                <br>
                <label for="contra">Contraseña</label>
                <br>
                <div class="campo-password">
                    <input class="input-register" type="password" name="password2" id="password2" placeholder="Ingresa tu contraseña">
                    <span class="toggle-password" onclick="togglePassword2()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                    </span>
                </div>
                <label for="contra">Confirmar Contraseña</label>
                <br>
                <div class="campo-password">
                    <input class="input-register" type="password" name="password3" id="password3" placeholder="Ingresa tu contraseña">
                    <span class="toggle-password" onclick="togglePassword3()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                    </span>
                </div>
                <div id="divButton">
                    
                    <input type="submit" id="buttonCrearCuenta" value="Crear Cuenta">
                </div>
                
            </form>
        </div>
    </div>
</div>
