<link rel="stylesheet" href="/LaHerradura/View/css/style-CrearCuenta.css">
<link rel="stylesheet" href="/LaHerradura/View/css/style-login.css">

<div class="modal-ra" id="modal-RegAdmin">
    <div class="modal-content-cc">
        <span class="close">&times;</span>
        <h2 id="RegAdmin-text">Agregar Administrador</h2>
        <div class="cont-form-cc">
            <form class="resgitrer-form" id="form-registroAdmin" action="/LaHerradura/Controller/registroAdmin.php" method="POST">
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
                    <input  class="input-register" type="password" name="passwordAdmin1" id="passwordAdmin1" placeholder="Ingresa tu contraseña" >
                        <button type="button" class="ButtonEyePassword" onclick="toggleVisibility('passwordAdmin1')">
                            <span class='material-symbols-outlined' id="buttonEye">visibility</span>
                        </button>
                </div>
                <label for="contra">Confirmar Contraseña</label>
                <br>
                <div class="campo-password">
                    <input  class="input-register" type="password" name="passwordAdmin2" id="passwordAdmin2" placeholder="Ingresa tu contraseña" >
                        <button type="button" class="ButtonEyePassword" onclick="toggleVisibility('passwordAdmin2')">
                            <span class='material-symbols-outlined' id="buttonEye">visibility</span>
                        </button>
                </div>
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
                    <button type="submit" id="buttonCrearCuentaAdmin">Registrar Administrador</button>
                </div>
                
            </form>
        </div>
    </div>
</div>
