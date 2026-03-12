<link rel="stylesheet" href="/LaHerradura/View/css/style-CrearCuenta.css">
<link rel="stylesheet" href="/LaHerradura/View/css/style-login.css">

<div class="modal-Cc" id="modal-CrearCuenta">
    <div class="modal-content-cc">
        <span class="close">&times;</span>
        <h2 id="CrearCuenta-text">Crear cuenta</h2>
        
        <div class="indicador-pasos">
            <span class="paso-dot-cc active">1</span>
            <span class="paso-dot-cc">2</span>
        </div>

        <div class="cont-form-cc">
            <form class="resgitrer-form" id="form-registro" action="/LaHerradura/Controller/registrosUsuarios.php" method="POST">
                
                <div class="pasarela-step-cc active" id="step-cc-1">
                    <label class="labelRegistrer" for="Nombre">Nombre</label>
                    <input class="input-register" type="text" name="Nombre" id="Nombre" placeholder="Ingresa tu nombre" required>
                    
                    <label class="labelRegistrer" for="Apellido_Pat">Apellido Paterno</label>
                    <input class="input-register" type="text" name="Apellido_Pat" id="Apellido_Pat" placeholder="Ingresa tu apellido paterno" required>
                    
                    <label class="labelRegistrer" for="Apellido_Mat">Apellido Materno</label>
                    <input class="input-register" type="text" name="Apellido_Mat" id="Apellido_Mat" placeholder="Ingresa tu apellido materno" required>
                    
                    <div class="divButton-pasarela">
                        <button type="button" class="btn-pasarela btn-siguiente" onclick="cambiarPasoCC(1, 2)">Siguiente</button>
                    </div>
                </div>

                <div class="pasarela-step-cc" id="step-cc-2" style="display:none;">
                    <label class="labelRegistrer" for="CorreoRegistro">Correo Electrónico</label>
                    <input class="input-register" type="email" name="CorreoRegistro" id="CorreoRegistro" placeholder="Ingresa tu correo" required>
                    
                    <label class="labelRegistrer" for="PasswordRegistro1">Contraseña</label>
                    <div class="campo-password">
                        <input class="input-register" type="password" name="PasswordRegistro1" id="PasswordRegistro1" placeholder="Ingresa tu contraseña" required>
                        <button type="button" class="ButtonEyePassword" onclick="toggleVisibility('PasswordRegistro1')">
                            <span class='material-symbols-outlined'>visibility</span>
                        </button>
                    </div>

                    <label class="labelRegistrer" for="PasswordRegistro2">Confirmar Contraseña</label>
                    <div class="campo-password">
                        <input class="input-register" type="password" name="PasswordRegistro2" id="PasswordRegistro2" placeholder="Confirma tu contraseña" required>
                        <button type="button" class="ButtonEyePassword" onclick="toggleVisibility('PasswordRegistro2')">
                            <span class='material-symbols-outlined'>visibility</span>
                        </button>
                    </div>

                    <div class="divButton-pasarela">
                        <button type="button" class="btn-pasarela btn-anterior" onclick="cambiarPasoCC(2, 1)">Anterior</button>
                        <button type="submit" id="buttonCrearCuenta">Crear Cuenta</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function cambiarPasoCC(pasoActual, pasoSiguiente) {
    // Validar antes de avanzar
    if (pasoSiguiente > pasoActual) {
        const contenedorPaso = document.getElementById(`step-cc-${pasoActual}`);
        const inputs = contenedorPaso.querySelectorAll('input');
        let valido = true;

        for (let input of inputs) {
            if (!input.checkValidity()) {
                input.reportValidity();
                valido = false;
                break;
            }
        }
        if (!valido) return;
    }

    // Cambiar vista de pasos
    document.getElementById(`step-cc-${pasoActual}`).style.display = 'none';
    document.getElementById(`step-cc-${pasoSiguiente}`).style.display = 'block';

    // Actualizar puntos indicadores
    const dots = document.querySelectorAll('.paso-dot-cc');
    dots.forEach((dot, index) => {
        if (index < pasoSiguiente) dot.classList.add('active');
        else dot.classList.remove('active');
    });
}
</script>