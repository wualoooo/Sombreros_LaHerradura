document.addEventListener('DOMContentLoaded', function() {
    
    const formulario = document.getElementById('form-AggTexana');
    if (!formulario) return;

    formulario.addEventListener('submit', function(e) {
        e.preventDefault(); 

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

        // 1. Textos (¡AGREGAMOS EL SKU AQUÍ!)
        const camposTexto = ['SKUTexana', 'NombreTexana'];
        camposTexto.forEach(name => {
            const input = formulario.querySelector(`[name="${name}"]`);
            const nombreCampo = name.replace('Texana', ''); 
            
            if (!input) return;
            const valor = input.value.trim();

            if (valor === "") {
                marcarError(input, `El campo ${nombreCampo} es obligatorio.`);
            } else if (name !== 'SKUTexana' && /^\d+$/.test(valor)) {
                marcarError(input, `El ${nombreCampo} no puede ser solo números.`);
            } else if (valor.length < 3) {
                marcarError(input, `El ${nombreCampo} es muy corto.`);
            }
        });

        // 2. Selects
        const selects = ['HormaTexana', 'CopaTexana', 'ColorTexana', 'MaterialTexana'];
        selects.forEach(name => {
            const input = formulario.querySelector(`[name="${name}"]`);
            if (!input || input.value === "Null" || input.value === "") {
                marcarError(input, `Selecciona una opción para ${name.replace('Texana', '')}.`);
            }
        });

        // 3. Números
        const numeros = ['PrecioTexana', 'TamañoCopaTexana', 'TamañoAlaTexana'];
        numeros.forEach(name => {
            const input = formulario.querySelector(`[name="${name}"]`);
            if (!input || input.value === "" || isNaN(input.value) || Number(input.value) <= 0) {
                marcarError(input, `Revisa el valor numérico de ${name.replace('Texana', '')}.`);
            }
        });

        // 4. Imágenes
        const nombresArchivosVistos = new Set();
        for (let i = 1; i <= 4; i++) {
            const inputImg = formulario.querySelector(`[name="imgTexana${i}"]`);
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
            
            // CORREGIMOS EL BOTÓN A .textContent
            const btnSubmit = document.getElementById('btnGuardarAggTexana');
            const textoOriginal = btnSubmit.textContent;
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
                    const modal = document.getElementById('modal-AggTexana');
                    if(modal) modal.style.display = "none";

                    Alerta.exito(data.message || 'Texana registrada correctamente.')
                        .then(() => {
                            formulario.reset(); 
                            document.querySelectorAll('.preview').forEach(img => {
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