<link rel="stylesheet" href="/LaHerradura/View/css/style-CrearCuenta.css">
<link rel="stylesheet" href="/LaHerradura/View/css/style-login.css">

<div class="modal-Cc" id="modal-CrearCuenta">
    <div class="modal-content-cc">
        <span class="close">&times;</span>
        <h2 id="CrearCuenta-text">Crear cuenta</h2>
        <div class="cont-form-cc">
            <form class="resgitrer-form" id="form-registro" action="/LaHerradura/Controller/registrosUsuarios.php" method="POST">
                <label class="labelRegistrer" for="name">Nombre</label>
                <br>
                <input class="input-register" type="text" name="Nombre" id="Nombre" placeholder="Ingresa tu nombre">
                <br>
                <label class="labelRegistrer" for="ap_pat">Apellido Paterno</label>
                <br>
                <input class="input-register" type="text" name="Apellido_Pat" id="Apellido_Pat" placeholder="Ingresa tu apellido paterno">
                <br>
                <label class="labelRegistrer" for="ap_mat"> Apellido Materno</label>
                <br>
                <input class="input-register" type="text" name="Apellido_Mat" id="Apellido_Mat" placeholder="Ingresa tu apellido materno">
                <label class="labelRegistrer" for="email">Correo Electrónico</label>
                <br>
                <input class="input-register" type="email" name="CorreoRegistro" id="CorreoRegistro" placeholder="Ingresa tu correo">
                <br>
                <label class="labelRegistrer" for="contra">Contraseña</label>
                <br>
                <div class="campo-password">
                        <input  class="input-register" type="password" name="PasswordRegistro1" id="PasswordRegistro1" placeholder="Ingresa tu contraseña" >
                        <button type="button" class="ButtonEyePassword" onclick="toggleVisibility('PasswordRegistro1')">
                            <span class='material-symbols-outlined' id="buttonEye">visibility</span>
                        </button>
                    </div>
                <label class="labelRegistrer" for="contra">Confirmar Contraseña</label>
                <br>
                <div class="campo-password">
                        <input  class="input-register" type="password" name="PasswordRegistro2" id="PasswordRegistro2" placeholder="Ingresa tu contraseña" >
                        <button type="button" class="ButtonEyePassword" onclick="toggleVisibility('PasswordRegistro2')">
                            <span class='material-symbols-outlined' id="buttonEye">visibility</span>
                        </button>
                    </div>
                <div class="divButton">
                    <input type="submit" id="buttonCrearCuenta" value="Crear Cuenta">
                </div>
                
            </form>
        </div>
    </div>
</div>
