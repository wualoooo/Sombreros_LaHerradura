document.addEventListener('DOMContentLoaded', function() {
    
    const formulario = document.getElementById('Form-AgregarDirección');

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
        const campos = ['cp', 'calle', 'referencia'];
        campos.forEach(id => {
            const input = document.getElementById(id);
            if (!input || input.value.trim() === "") {
                marcarError(id, `El campo ${id.replace('_', ' ')} es obligatorio.`);
            }
        });

        const numeros = ['numTel'];
        numeros.forEach(name => {
            const input = formulario.querySelector(`[name="${name}"]`);
            if (!input || input.value === "" || Number(input.length) < 10) {
                marcarError(input, `Ingresa un número de teléfono válido.`);
            }
        });


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
            const btnSubmit = document.getElementById('ButtonGuardarDireccion');
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