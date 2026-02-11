document.addEventListener('DOMContentLoaded', function() {
    
    const formulario = document.getElementById('form-registro');

    if (!formulario) return;

    formulario.addEventListener('submit', function(e) {
        e.preventDefault(); 

        // Limpieza de estilos previos
        const limpiarEstilos = () => {
            formulario.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
        };
        limpiarEstilos();

        let errores = [];
        let primerElementoError = null;

        const marcarError = (id, mensaje) => {
            const elemento = document.getElementById(id);
            if (elemento) {
                elemento.classList.add('input-error');
                if (!primerElementoError) primerElementoError = elemento;
            }
            errores.push(mensaje);
        };

        // --- VALIDACIONES ---

        // 1. Campos Vacíos Básicos
        const campos = ['Nombre', 'Apellido_Pat', 'Apellido_Mat'];
        campos.forEach(id => {
            const input = document.getElementById(id);
            if (!input || input.value.trim() === "") {
                marcarError(id, `El campo ${id.replace('_', ' ')} es obligatorio.`);
            }
        });

        // 2. Validación de Correo
        const emailInput = document.getElementById('CorreoRegistro');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailInput || emailInput.value.trim() === "") {
            marcarError('CorreoRegistro', "El Correo es obligatorio.");
        } else if (!emailRegex.test(emailInput.value.trim())) {
            marcarError('CorreoRegistro', "Ingresa un correo electrónico válido.");
        }

        // 3. Validación de Contraseñas
        const pass1 = document.getElementById('PasswordRegistro1');
        const pass2 = document.getElementById('PasswordRegistro2');

        if (!pass1 || pass1.value.trim() === "") {
            marcarError('PasswordRegistro1', "La contraseña es obligatoria.");
        } else if (pass1.value.length < 8) {
            marcarError('PasswordRegistro1', "La contraseña debe tener al menos 8 caracteres.");
        }

        if (pass1 && pass2 && pass1.value !== pass2.value) {
            marcarError('PasswordRegistro2', "Las contraseñas no coinciden.");
        }

        // --- RESULTADO ---

        if (errores.length > 0) {
            // Asumiendo que tienes configurado SweetAlert2 y alerts.js
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                html: '<ul style="text-align: left;"><li>' + errores.join('</li><li>') + '</li></ul>',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Corregir'
            });
            if (primerElementoError) primerElementoError.focus();

        } else {
            // ENVIAR AL BACKEND
            const btnSubmit = document.getElementById('buttonCrearCuenta');
            const textoOriginal = btnSubmit.value;
            btnSubmit.value = "Registrando...";
            btnSubmit.disabled = true;

            const formData = new FormData(formulario);

            fetch(formulario.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btnSubmit.value = textoOriginal;
                btnSubmit.disabled = false;

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Registro Exitoso!',
                        text: 'Ahora puedes iniciar sesión.',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        formulario.reset();
                        document.getElementById('modal-CrearCuenta').style.display = 'none';
                        // Opcional: Abrir modal de login automáticamente
                        const modalLogin = document.getElementById('modal-Login');
                        if(modalLogin) modalLogin.style.display = 'block';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo contactar con el servidor.'
                });
                btnSubmit.value = textoOriginal;
                btnSubmit.disabled = false;
            });
        }
    });
});