document.addEventListener('DOMContentLoaded', function() {
    
    // ID del formulario de AGREGAR Botines
    const formulario = document.getElementById('form-AggBotin');

    if (!formulario) return;

    formulario.addEventListener('submit', function(e) {
        e.preventDefault(); // Detenemos el envío para validar

        // --- A) LIMPIEZA VISUAL PREVIA ---
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

        // --- B) VALIDACIONES ROBUSTAS ---

        // 1. Validar Nombre
        const inputNombre = document.getElementById('NombreBotin');
        if (inputNombre) {
            const valor = inputNombre.value.trim();
            if (valor === "") marcarError(inputNombre, "El Nombre es obligatorio.");
            else if (valor.length < 3) marcarError(inputNombre, "El Nombre es muy corto.");
        }

        // 2. Validar Talla (Número)
        const inputTalla = document.getElementById('TallaBotin');
        if (inputTalla) {
            if (inputTalla.value === "" || isNaN(inputTalla.value)) {
                marcarError(inputTalla, "La Talla debe ser un número válido.");
            }
        }

        // 3. Validar Selects (Material y Suela)
        const selects = ['MaterialBotin', 'SuelaBotin'];
        selects.forEach(id => {
            const input = document.getElementById(id);
            if (!input || input.value === "Null" || input.value === "") {
                marcarError(input, `Selecciona una opción para ${id.replace('Botin', '')}.`);
            }
        });

        // 4. Validar Precio
        const inputPrecio = document.getElementById('PrecioBotin');
        if (inputPrecio) {
            if (inputPrecio.value === "" || Number(inputPrecio.value) <= 0) {
                marcarError(inputPrecio, "El Precio debe ser mayor a 0.");
            }
        }

        // 5. Validar Imágenes (Existencia y Duplicados)
        const nombresArchivosVistos = new Set();
        for (let i = 1; i <= 4; i++) {
            const inputImg = document.getElementById(`imgBotin${i}`); // Usamos ID directo porque es único en el modal de agregar
            
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

        // --- C) RESULTADO DE VALIDACIÓN ---

        if (errores.length > 0) {
            // Mostrar lista de errores
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                html: '<ul style="text-align: left;"><li>' + errores.join('</li><li>') + '</li></ul>',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Corregir'
            });

            if (primerElementoError) primerElementoError.focus();

        } else {
            // --- D) SI TODO ESTÁ BIEN: ENVIAR FETCH ---
            const btnSubmit = document.getElementById('btnGuardarAggBotin');
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
                    // Cerrar modal
                    const modal = document.getElementById('modal-AggBotin');
                    if(modal) modal.style.display = "none";

                    // Alerta de éxito y recarga
                    Alerta.exito(data.message || 'Botín registrado correctamente.')
                        .then(() => {
                            formulario.reset(); 
                            // Limpiar previews
                            document.querySelectorAll('#form-AggBotin .preview').forEach(img => {
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