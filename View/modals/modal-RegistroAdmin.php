<link rel="stylesheet" href="/LaHerradura/View/css/style-CrearCuenta.css">
<link rel="stylesheet" href="/LaHerradura/View/css/style-login.css">

<div class="modal-ra" id="modal-RegAdmin">
    <div class="modal-content-cc">
        <span class="close">&times;</span>
        <h2 id="RegAdmin-text">Agregar Administrador</h2>
        
        <div class="indicador-pasos">
            <span class="paso-dot-cc active">1</span>
            <span class="paso-dot-cc">2</span>
        </div>

        <div class="cont-form-cc">
            <form class="resgitrer-form" id="form-registroAdmin" action="/LaHerradura/Controller/registroAdmin.php" method="POST">
                
                <div class="pasarela-step-cc active" id="step-ra-1">
                    <label for="NombreAdmin">Nombre</label>
                    <input class="input-admin" type="text" name="NombreAdmin" id="NombreAdmin" placeholder="Ingresa tu nombre" required>
                    
                    <label for="Apellido_PatAdmin">Apellido Paterno</label>
                    <input class="input-admin" type="text" name="Apellido_PatAdmin" id="Apellido_PatAdmin" placeholder="Ingresa tu apellido paterno" required>
                    
                    <label for="Apellido_MatAdmin">Apellido Materno</label>
                    <input class="input-admin" type="text" name="Apellido_MatAdmin" id="Apellido_MatAdmin" placeholder="Ingresa tu apellido materno" required>
                    
                    <div class="divButton-pasarela">
                        <button type="button" class="btn-pasarela btn-siguiente" onclick="cambiarPasoRA(1, 2)">Siguiente</button>
                    </div>
                </div>

                <div class="pasarela-step-cc" id="step-ra-2" style="display:none;">
                    <label for="CorreoRegistroAdmin">Correo Electrónico</label>
                    <input class="input-admin" type="email" name="CorreoRegistroAdmin" id="CorreoRegistroAdmin" placeholder="Ingresa el correo" required>
                    
                    <label for="passwordAdmin1">Contraseña</label>
                    <div class="campo-password">
                        <input class="input-register" type="password" name="passwordAdmin1" id="passwordAdmin1" placeholder="Ingresa la contraseña" required>
                        <button type="button" class="ButtonEyePassword" onclick="toggleVisibility('passwordAdmin1')">
                            <span class='material-symbols-outlined' id="buttonEye">visibility</span>
                        </button>
                    </div>
                    
                    <label for="passwordAdmin2">Confirmar Contraseña</label>
                    <div class="campo-password">
                        <input class="input-register" type="password" name="passwordAdmin2" id="passwordAdmin2" placeholder="Confirma la contraseña" required>
                        <button type="button" class="ButtonEyePassword" onclick="toggleVisibility('passwordAdmin2')">
                            <span class='material-symbols-outlined' id="buttonEye">visibility</span>
                        </button>
                    </div>

                    <div id="spaceRol">
                        <label for="RolAdmin">Elige el rol</label>
                        <select name="RolAdmin" id="RolAdmin" style="margin-bottom: 15px;" required>
                            <option value="" selected disabled hidden>Selecciona una opcion</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Empleado">Empleado</option>
                            <option value="Desarrollador">Desarrollador</option>
                        </select>
                    </div>

                    <div class="divButton-pasarela">
                        <button type="button" class="btn-pasarela btn-anterior" onclick="cambiarPasoRA(2, 1)">Anterior</button>
                        <button type="submit" id="buttonCrearCuentaAdmin" style="flex: 2; margin-top: 0;">Registrar</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>

<script>
function cambiarPasoRA(pasoActual, pasoSiguiente) {
    // Validar antes de avanzar
    if (pasoSiguiente > pasoActual) {
        const contenedorPaso = document.getElementById(`step-ra-${pasoActual}`);
        const inputs = contenedorPaso.querySelectorAll('input, select');
        let valido = true;

        for (let input of inputs) {
            // Validamos que todos los campos requeridos estén llenos
            if (!input.checkValidity()) {
                input.reportValidity();
                valido = false;
                break;
            }
        }
        if (!valido) return;
    }

    // Cambiar vista de pasos
    document.getElementById(`step-ra-${pasoActual}`).style.display = 'none';
    document.getElementById(`step-ra-${pasoSiguiente}`).style.display = 'block';

    // Actualizar puntos indicadores específicamente para este modal
    const modalAdmin = document.getElementById('modal-RegAdmin');
    const dots = modalAdmin.querySelectorAll('.paso-dot-cc');
    
    dots.forEach((dot, index) => {
        if (index < pasoSiguiente) dot.classList.add('active');
        else dot.classList.remove('active');
    });
}
</script>