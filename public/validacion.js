document.addEventListener('DOMContentLoaded', function() {
    
    const formulario = document.getElementById('form-AggSom');

    if (!formulario) return;

    formulario.addEventListener('submit', function(e) {
        e.preventDefault(); // Detenemos el envío siempre para validar

        let errores = [];
        let primerElementoError = null;

        // --- HELPERS ---
        const limpiarErrores = () => {
            // Buscamos clases de error SOLO dentro de este formulario
            formulario.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
            formulario.querySelectorAll('.caja-error').forEach(el => el.classList.remove('caja-error'));
            
            const msgBox = document.getElementById('mensaje-error-js');
            if(msgBox) msgBox.style.display = 'none';
        };

        const marcarError = (elemento, mensaje) => {
            if (elemento) {
                elemento.classList.add('input-error');
                if (!primerElementoError) primerElementoError = elemento;
            }
            errores.push(mensaje);
        };

        limpiarErrores();

        // --- VALIDACIÓN ROBUSTA (Busca por name, no por ID) ---

        // 1. Textos (Nombre, Color, Material)
        const camposTexto = ['NombreSombrero', 'ColorSombrero', 'MaterialSombrero'];
        camposTexto.forEach(name => {
            const input = formulario.querySelector(`[name="${name}"]`);
            const nombreCampo = name.replace('Sombrero', ''); // Para que el mensaje diga "Nombre" y no "NombreSombrero"
            
            if (!input) return;

            const valor = input.value.trim();

            // REGLA 1: No puede estar vacío
            if (valor === "") {
                marcarError(input, `El campo ${nombreCampo} es obligatorio.`);
            } 
            // REGLA 2: No puede ser SOLO números (Regex: inicio a fin son dígitos)
            else if (/^\d+$/.test(valor)) {
                marcarError(input, `El ${nombreCampo} no puede ser solo números (ej: "${valor}").`);
            }
            // REGLA 3: Longitud mínima (para evitar "a", "b", etc.)
            else if (valor.length < 3) {
                marcarError(input, `El ${nombreCampo} es muy corto, sé más específico.`);
            }
        });

        // 2. Selects
        const selects = ['HormaSombrero', 'CopaSombrero'];
        selects.forEach(name => {
            const input = formulario.querySelector(`[name="${name}"]`);
            if (!input || input.value === "Null") {
                marcarError(input, `Selecciona una opción para ${name.replace('Sombrero', '')}.`);
            }
        });

        // 3. Números
        const numeros = ['PrecioSombrero', 'TamañoCopaSombrero', 'TamañoAlaSombrero'];
        numeros.forEach(name => {
            const input = formulario.querySelector(`[name="${name}"]`);
            if (!input || input.value === "" || isNaN(input.value) || Number(input.value) <= 0) {
                marcarError(input, `Revisa el valor de ${name.replace('Sombrero', '')}.`);
            }
        });

        // 4. Imágenes (Validación de existencia y duplicados)
        const nombresArchivosVistos = new Set(); // Aquí guardaremos los nombres para detectar clones

        for (let i = 1; i <= 4; i++) {
            const inputImg = formulario.querySelector(`[name="imgSombrero${i}"]`);
            
            if (inputImg) {
                const caja = inputImg.closest('.caja-preview');

                // A) ¿Seleccionó archivo?
                if (inputImg.files.length === 0) {
                    errores.push(`Falta seleccionar la Imagen ${i}`);
                    if (caja) caja.classList.add('caja-error');
                } 
                else {
                    // B) ¿Es un duplicado?
                    const nombreArchivo = inputImg.files[0].name;
                    
                    if (nombresArchivosVistos.has(nombreArchivo)) {
                        // ¡LO ENCONTRAMOS! El usuario trata de subir la misma foto otra vez
                        errores.push(`La Imagen ${i} es igual a una anterior (${nombreArchivo}). No puedes repetir fotos.`);
                        if (caja) caja.classList.add('caja-error');
                    } else {
                        // Si es nuevo, lo guardamos en la lista para comparar con los siguientes
                        nombresArchivosVistos.add(nombreArchivo);
                    }
                }
            }
        }

        // --- RESULTADO ---

        if (errores.length > 0) {
            let msgBox = document.getElementById('mensaje-error-js');
            if (!msgBox) {
                msgBox = document.createElement('div');
                msgBox.id = 'mensaje-error-js';
                // Agregamos el mensaje al contenedor del modal, no al form, para que flote bien
                const modalContent = document.querySelector('.modal-content-AggSom');
                if(modalContent) modalContent.appendChild(msgBox);
            }

            // Mensaje corto para no tapar todo
            msgBox.innerHTML = `<strong>Hay errores:</strong><br>Revisa los campos marcados en rojo.`;
            msgBox.style.display = 'block';

            // Ocultar mensaje automáticamente después de 3 segundos
            setTimeout(() => {
                msgBox.style.display = 'none';
            }, 4000);

        } else {
            // 1. Mostrar indicador de carga (Opcional pero recomendado)
            const btnSubmit = formulario.querySelector('input[type="submit"]');
            const textoOriginal = btnSubmit.value;
            btnSubmit.value = "Guardando...";
            btnSubmit.disabled = true;

            // 2. Preparamos los datos
            const formData = new FormData(formulario);

            // 3. Enviamos con FETCH (Sin recargar pagina)
            fetch(formulario.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // Convertimos la respuesta a objeto JS
            .then(data => {
                
                // Restaurar botón
                btnSubmit.value = textoOriginal;
                btnSubmit.disabled = false;

                if (data.success) {
                    // ÉXITO
                    alert("" + data.message); // O usa una librería bonita como SweetAlert
                    
                    formulario.reset(); // Limpiamos el formulario
                    
                    // Limpiamos las previsualizaciones de imagenes (si tienes esa funcion)
                    document.querySelectorAll('.preview').forEach(img => img.src = '#');
                    document.querySelectorAll('.caja-error, .input-error').forEach(el => el.classList.remove('caja-error', 'input-error'));
                    
                    // Opcional: Cerrar el modal automáticamente
                    const modal = document.getElementById('modal-AggSombrero');
                    if(modal) modal.style.display = "none"; 
                    
                    // Opcional: Recargar la página para ver el nuevo producto en la tabla
                    location.reload(); 

                } else {
                    // ERROR DEL SERVIDOR (PHP)
                    // Mostramos el error en la misma cajita flotante que creamos antes
                    let msgBox = document.getElementById('mensaje-error-js');
                    if (!msgBox) { /* Crear caja si no existe... (mismo código de antes) */ }
                    
                    msgBox.innerHTML = `<strong>Error del servidor:</strong><br>${data.message}`;
                    msgBox.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Hubo un error de conexión con el servidor.");
                btnSubmit.value = textoOriginal;
                btnSubmit.disabled = false;
            });
        }
    });
});