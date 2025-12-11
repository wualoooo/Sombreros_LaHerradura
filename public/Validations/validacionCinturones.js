document.addEventListener('DOMContentLoaded', function() {
    
    // ID del formulario de AGREGAR Cinturones
    const formulario = document.getElementById('form-AggCinturon');

    if (!formulario) return;

    formulario.addEventListener('submit', function(e) {
        e.preventDefault(); 

        // --- A) LIMPIEZA VISUAL ---
        const limpiarEstilos = () => {
            formulario.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
            formulario.querySelectorAll('.caja-error').forEach(el => el.classList.remove('caja-error'));
        };
        limpiarEstilos();

        let errores = [];
        let primerElementoError = null;

        const marcarError = (elemento, mensaje) => {
            if (elemento) {
                elemento.classList.add('input-error');
                if (!primerElementoError) primerElementoError = elemento;
            }
            errores.push(mensaje);
        };

        // --- B) VALIDACIONES ---

        // 1. Nombre
        const inputNombre = document.getElementById('NombreCinturon');
        if (inputNombre) {
            const valor = inputNombre.value.trim();
            if (valor === "") marcarError(inputNombre, "El Nombre es obligatorio.");
            else if (valor.length < 3) marcarError(inputNombre, "El Nombre es muy corto.");
        }

        // 2. Selects (Material y Adorno)
        const selects = ['MaterialCinturon', 'AdornoCinturon'];
        selects.forEach(id => {
            const input = document.getElementById(id);
            // Validamos que exista y que no sea la opción por defecto
            if (input && (input.value === "Null" || input.value === "")) {
                marcarError(input, `Selecciona una opción para ${id.replace('Cinturon', '')}.`);
            }
        });

        // 3. Tamaño (Input Texto/Número)
        const inputTamano = document.getElementById('TamañoCinturon');
        if (inputTamano && inputTamano.value.trim() === "") {
            marcarError(inputTamano, "El Tamaño es obligatorio.");
        }

        // 4. Precio
        const inputPrecio = document.getElementById('PrecioCinturon');
        if (inputPrecio) {
            if (inputPrecio.value === "" || Number(inputPrecio.value) <= 0) {
                marcarError(inputPrecio, "El Precio debe ser mayor a 0.");
            }
        }

        // 5. Imágenes
        const nombresArchivosVistos = new Set();
        for (let i = 1; i <= 4; i++) {
            const inputImg = document.getElementById(`imgCinturon${i}`);
            
            if (inputImg) {
                const caja = inputImg.closest('.caja-preview');

                if (inputImg.files.length === 0) {
                    errores.push(`Falta seleccionar la Imagen ${i}`);
                    if (caja) caja.classList.add('caja-error');
                } else {
                    const nombreArchivo = inputImg.files[0].name;
                    if (nombresArchivosVistos.has(nombreArchivo)) {
                        errores.push(`La Imagen ${i} está repetida (${nombreArchivo}).`);
                        if (caja) caja.classList.add('caja-error');
                    } else {
                        nombresArchivosVistos.add(nombreArchivo);
                    }
                }
            }
        }

        // --- C) RESULTADO ---

        if (errores.length > 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                html: '<ul style="text-align: left;"><li>' + errores.join('</li><li>') + '</li></ul>',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Corregir'
            });

            if (primerElementoError) primerElementoError.focus();

        } else {
            // --- D) ENVIAR ---
            const btnSubmit = document.getElementById('btnGuardarAggCinturon');
            const textoOriginal = btnSubmit.value;
            btnSubmit.value = "Guardando...";
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
                    const modal = document.getElementById('modal-AggCinturon');
                    if(modal) modal.style.display = "none";

                    Alerta.exito(data.message || 'Cinturón registrado correctamente.')
                        .then(() => {
                            formulario.reset(); 
                            document.querySelectorAll('#form-AggCinturon .preview').forEach(img => {
                                img.src = '#';
                                img.style.display = 'none';
                            });
                            location.reload(); 
                        });

                } else {
                    Alerta.error(data.message || "Error desconocido del servidor.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Alerta.error("Hubo un error de conexión con el servidor.");
                btnSubmit.value = textoOriginal;
                btnSubmit.disabled = false;
            });
        }
    });
});