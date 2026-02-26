document.addEventListener('DOMContentLoaded', function() {
    
    const formulario = document.getElementById('form-AggBotin');
    if (!formulario) return;

    formulario.addEventListener('submit', function(e) {
        e.preventDefault(); 

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

        // 1. Validar Textos (INCLUYE SKU)
        const camposTexto = ['SKUBotin', 'NombreBotin'];
        camposTexto.forEach(name => {
            const input = document.getElementById(name);
            if (input) {
                const valor = input.value.trim();
                const nombreCampo = name.replace('Botin', '');
                if (valor === "") marcarError(input, `El ${nombreCampo} es obligatorio.`);
                else if (name !== 'SKUBotin' && valor.length < 3) marcarError(input, `El ${nombreCampo} es muy corto.`);
            }
        });

        // 2. Validar Talla
        const inputTalla = document.getElementById('TallaBotin');
        if (inputTalla) {
            if (inputTalla.value === "" || isNaN(inputTalla.value)) {
                marcarError(inputTalla, "La Talla debe ser un número válido.");
            }
        }

        // 3. Validar Selects
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

        // 5. Validar Imágenes
        const nombresArchivosVistos = new Set();
        for (let i = 1; i <= 4; i++) {
            const inputImg = document.getElementById(`imgBotin${i}`);
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
            const btnSubmit = document.getElementById('btnGuardarAggBotin');
            const textoOriginal = btnSubmit.textContent; // Cambio a textContent
            btnSubmit.textContent = "Guardando...";
            btnSubmit.disabled = true;

            const formData = new FormData(formulario);

            fetch(formulario.action, { 
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btnSubmit.textContent = textoOriginal;
                btnSubmit.disabled = false;

                if (data.success) {
                    const modal = document.getElementById('modal-AggBotin');
                    if(modal) modal.style.display = "none";

                    Alerta.exito(data.message || 'Botín registrado correctamente.')
                        .then(() => {
                            formulario.reset(); 
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
                btnSubmit.textContent = textoOriginal;
                btnSubmit.disabled = false;
            });
        }
    });
});