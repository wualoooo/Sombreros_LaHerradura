<link rel="stylesheet" href="../css/style-CrearCuenta.css">

<div class="modal-ra" id="modal-RegAdmin">
    <div class="modal-content-cc">
        <span class="close">&times;</span>
        <h2 id="RegAdmin-text">Agregar Administrador</h2>
        <div class="cont-form-cc">
            <form class="resgitrer-form" id="form-registroAdmin" action="../../Controller/registroAdmin.php" method="POST">
                <label for="name">Nombre</label>
                <br>
                <input class="input-admin" type="text" name="NombreAdmin" id="NombreAdmin" placeholder="Ingresa tu nombre">
                <br>
                <label for="ap_pat">Apellido Paterno</label>
                <br>
                <input class="input-admin" type="text" name="Apellido_PatAdmin" id="Apellido_PatAdmin" placeholder="Ingresa tu apellido paterno">
                <br>
                <label for="ap_mat"> Apellido Materno</label>
                <br>
                <input class="input-admin" type="text" name="Apellido_MatAdmin" id="Apellido_MatAdmin" placeholder="Ingresa tu apellido materno">
                <label for="email">Correo Electrónico</label>
                <br>
                <input class="input-admin" type="email" name="CorreoRegistroAdmin" id="CorreoRegistrAdmino" placeholder="Ingresa tu correo">
                <br>
                <label for="contra">Contraseña</label>
                <br>
                <div class="campo-password">
                    <input class="input-admin" type="password" name="passwordAdmin1" id="passwordAdmin1" placeholder="Ingresa tu contraseña">
                    <span class="toggle-password" onclick="togglePassword4()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                    </span>
                </div>
                <label for="contra">Confirmar Contraseña</label>
                <br>
                <div class="campo-password">
                    <input class="input-admin" type="password" name="passwordAdmin2" id="passwordAdmin2" placeholder="Ingresa tu contraseña">
                    <span class="toggle-password" onclick="togglePassword5()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                    </span>
                </div>
                <p id="mensajeError" class="mensaje-error" aria-live="polite"></p>
                <div id="spaceRol">
                    <label for="RolAdmin">Elige el rol</label>
                    <select name="RolAdmin" id="RolAdmin">
                        <option value="NULL">Selecciona una opcion</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Empleado">Empleado</option>
                        <option value="Desarrollador">Desarrollador</option>
                    </select>
                </div>

                <div id="divButton">
                    <input type="submit" id="buttonCrearCuentaAdmin" value="Registrar Administrador">
                </div>
                
            </form>
        </div>
    </div>
</div>
