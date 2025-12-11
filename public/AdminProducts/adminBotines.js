document.addEventListener('DOMContentLoaded', () => {

    // ==========================================
    // 1. REFERENCIAS AL DOM
    // ==========================================
    const modalEditar = document.getElementById('modal-EditBotin');
    const formEditar = document.getElementById('form-EditBotin');
    const tablaBody = document.getElementById('tabla-botines-body'); 
    const btnCerrar = modalEditar ? modalEditar.querySelector('.close') : null;

    // Validación de seguridad: Verificar que existan los elementos
    if (!modalEditar || !formEditar || !tablaBody) {
        console.error("ERROR CRÍTICO: No se encontraron elementos del modal o la tabla en adminBotines.js");
        return;
    }

    // ==========================================
    // 2. FUNCIONES AUXILIARES
    // ==========================================

    // Limpia el formulario y resetea estilos de error
    const limpiarModalEditar = () => {
        formEditar.reset();
        
        // Limpiar inputs de archivo y previsualizaciones
        const inputsArchivo = formEditar.querySelectorAll('input[type="file"]');
        inputsArchivo.forEach(input => input.value = '');

        const previews = formEditar.querySelectorAll('.preview');
        previews.forEach(img => {
            img.src = '#';
            img.style.display = 'none';
        });
        
        // Quitar clases de error visuales
        document.querySelectorAll('.input-error, .caja-error').forEach(el => {
            el.classList.remove('input-error', 'caja-error');
        });
    };

    // Muestra la imagen si existe en la BD, o la oculta si es null/vacía
    const cargarPreviewDesdeBD = (nombreArchivo, idImgPreview) => {
        // Asegúrate que esta ruta coincida con tu estructura de carpetas
        const rutaBase = '/LaHerradura/uploads/botines/'; 
        const img = document.getElementById(idImgPreview);
        
        if (img) {
            if (nombreArchivo && nombreArchivo.trim() !== "") {
                img.src = rutaBase + nombreArchivo;
                img.style.display = 'block';
            } else {
                img.src = '#';
                img.style.display = 'none';
            }
        }
    };

    // ==========================================
    // 3. EVENTOS (LOGICA PRINCIPAL)
    // ==========================================

    // Cerrar Modal
    if(btnCerrar) {
        btnCerrar.onclick = () => modalEditar.style.display = 'none';
    }
    window.onclick = (event) => {
        if (event.target == modalEditar) modalEditar.style.display = 'none';
    }

    // --- MANEJO DE CLICS EN LA TABLA (Delegación) ---
    tablaBody.addEventListener('click', (e) => {
        
        // ------------------------------------------------
        // A) BOTÓN EDITAR
        // ------------------------------------------------
        // Usamos .closest para detectar el click incluso si da en el ícono
        const btnEditar = e.target.closest('.btn-editarBotin');
        
        if (btnEditar) {
            limpiarModalEditar();
            const id = btnEditar.dataset.id;
            console.log("Editando Botín ID:", id);

            // Petición AJAX para obtener datos
            fetch(`/LaHerradura/Controller/CRUD_Botines/ViewBotines.php?id=${id}`)
                .then(response => {
                    if (!response.ok) throw new Error("Error de red al obtener datos");
                    return response.json();
                })
                .then(data => {
                    if(data.error){
                        Alerta.error("Error del servidor: " + data.error);
                        return;
                    }

                    // 1. Rellenar campos de texto (Asegúrate que los IDs coincidan con tu HTML)
                    document.getElementById('edit-id-botin').value = data.id_botin; 
                    document.getElementById('edit-NombreBotin').value = data.Nombre;
                    document.getElementById('edit-TallaBotin').value = data.Talla;
                    document.getElementById('edit-PrecioBotin').value = data.Precio;
                    
                    // 2. Rellenar Selects (Manejo de posibles valores nulos)
                    // Si el valor viene de la BD, lo seleccionamos.
                    const selectMaterial = document.getElementById('edit-MaterialBotin');
                    if(selectMaterial) selectMaterial.value = data.id_material || 'Null';

                    const selectSuela = document.getElementById('edit-SuelaBotin');
                    if(selectSuela) selectSuela.value = data.id_suela || 'Null';
                    
                    // 3. Cargar Imágenes
                    cargarPreviewDesdeBD(data.Img1, 'previewEditBotin1');
                    cargarPreviewDesdeBD(data.Img2, 'previewEditBotin2');
                    cargarPreviewDesdeBD(data.Img3, 'previewEditBotin3');
                    cargarPreviewDesdeBD(data.Img4, 'previewEditBotin4');
                    
                    // 4. Mostrar Modal
                    modalEditar.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error al cargar datos:', error);
                    Alerta.error("No se pudieron cargar los datos del botín.");
                });
        }

        // ------------------------------------------------
        // B) BOTÓN ELIMINAR
        // ------------------------------------------------
        const btnEliminar = e.target.closest('.btn-eliminarBotin');
        
        if (btnEliminar) {
            const id = btnEliminar.dataset.id;

            Alerta.confirmar(`¿Estás seguro de eliminar el botín ID ${id}?`, 'Sí, eliminar')
                .then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData();
                        formData.append('id', id);

                        // Nota: Ajusta la ruta si es necesario. Recomiendo usar rutas absolutas desde raíz.
                        fetch('/LaHerradura/Controller/CRUD_Botines/eliminarBotin.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                btnEliminar.closest('tr').remove();
                                Alerta.toast('Botín eliminado correctamente', 'success');
                            } else {
                                Alerta.error('Error al eliminar: ' + data.error);
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            Alerta.error("Error de conexión al intentar eliminar.");
                        });
                    }
                });
        }

    // --- C) LÓGICA DE "VER DETALLES" (EL OJITO) ---
    if (e.target.closest('.btn-verBotin')) {
        const btn = e.target.closest('.btn-verBotin');
        const id = btn.dataset.id;
        
        // Seleccionamos el modal de VISTA (no el de editar)
        const modalVer = document.getElementById('modal-ViewBotines');
        
        // Fetch para obtener los datos (reutilizamos tu controlador existente)
        fetch(`/LaHerradura/Controller/CRUD_Botines/ViewBotines.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                // 1. Llenar textos
                document.getElementById('name-sombrero-vp').textContent = data.Nombre;
                    document.getElementById('precio-vp').textContent = `$${data.Precio}.00 mxn`;
                    document.getElementById('modal-Talla').textContent = `Talla: ${data.Talla}`;
                    document.getElementById('modal-Material').textContent = `Material: ${data.Nombre_Material || data.id_material}`;
                    document.getElementById('modal-Suela').textContent = `Suela: ${data.Nombre_Suela || data.id_suela}`;

                // 2. Generar Galería de Imágenes (Tu lógica mejorada)
                const imgCont = document.getElementById('img-sombrero');
                
                let galeriaHtml = `
                    <div id="vista-foto">
                        <img id="main-image-modal" src="/LaHerradura/uploads/botines/${data.Img1}" alt="${data.Nombre}">
                    </div>
                    <div id="vista-miniaturas">
                `;

                const imagenes = [];
                if (data.Img1) imagenes.push(data.Img1);
                if (data.Img2) imagenes.push(data.Img2);
                if (data.Img3) imagenes.push(data.Img3);
                if (data.Img4) imagenes.push(data.Img4);

                imagenes.forEach(imgSrc => {
                    const rutaCompleta = `/LaHerradura/uploads/botines/${imgSrc}`;
                    galeriaHtml += `<img class="thumbnail-modal" src="${rutaCompleta}" alt="Miniatura ${data.Nombre}">`;
                });

                galeriaHtml += `</div>`;
                imgCont.innerHTML = galeriaHtml;

                // 3. Activar listeners de las miniaturas
                const mainImage = document.getElementById('main-image-modal'); 
                const thumbnails = document.querySelectorAll('#img-sombrero .thumbnail-modal');
                thumbnails.forEach(thumbnail => {
                    thumbnail.addEventListener('click', () => {
                        mainImage.src = thumbnail.src;
                    });
                });

                // 4. Mostrar el modal
                modalVer.style.display = 'block';
                
                // Lógica para cerrar ESTE modal específico
                const spanClose = modalVer.querySelector('.close');
                if(spanClose) {
                    spanClose.onclick = () => {
                        modalVer.style.display = 'none';
                        imgCont.innerHTML = ""; // Limpiar galería
                    }
                }
                
                // Cerrar al dar clic fuera
                window.addEventListener('click', (event) => {
                    if (event.target == modalVer) {
                        modalVer.style.display = "none";
                    }
                });

            })
            .catch(error => console.error('Error:', error));
    }
    });
    

    // ==========================================
    // 4. ENVIAR FORMULARIO DE EDICIÓN (GUARDAR)
    // ==========================================
    formEditar.addEventListener('submit', (e) => {
        e.preventDefault(); 

        // --- A) LIMPIEZA VISUAL DE ERRORES ---
        const limpiarEstilosError = () => {
            formEditar.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
            formEditar.querySelectorAll('.caja-error').forEach(el => el.classList.remove('caja-error'));
        };
        limpiarEstilosError();

        let errores = [];
        let primerError = null;

        // Helper para marcar inputs con error
        const marcarError = (id, mensaje) => {
            const el = document.getElementById(id);
            if (el) {
                el.classList.add('input-error');
                if (!primerError) primerError = el;
            }
            errores.push(mensaje);
        };

        // --- B) VALIDACIONES ---
        
        // 1. Nombre
        const nombreInput = document.getElementById('edit-NombreBotin');
        if (nombreInput && nombreInput.value.trim() === "") {
            marcarError('NombreBotin', "El nombre es obligatorio.");
        }

        // 2. Selects (Material y Suela)
        ['edit-MaterialBotin', 'edit-SuelaBotin'].forEach(id => {
            const input = document.getElementById(id);
            if (input && (input.value === "Null" || input.value === "")) {
                marcarError(id, `Selecciona una opción válida para ${id.replace('Botin', '')}.`);
            }
        });

        // 3. Números (Precio y Talla)
        ['edit-PrecioBotin', 'edit-TallaBotin'].forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                if (input.value === "" || isNaN(input.value) || Number(input.value) <= 0) {
                    marcarError(id, `El campo ${id.replace('Botin', '')} debe ser un número válido.`);
                }
            }
        });

        // 4. Imágenes Duplicadas (Validación en cliente)
        const archivosNuevos = new Set();
        for (let i = 1; i <= 4; i++) {
            const idInput = `imgEditBotin${i}`; // Asegúrate que estos IDs existen en tu HTML
            const input = document.getElementById(idInput);
            
            if (input && input.files.length > 0) {
                const nombreArchivo = input.files[0].name;
                const caja = input.closest('.caja-preview');

                if (archivosNuevos.has(nombreArchivo)) {
                    errores.push(`La imagen "${nombreArchivo}" se ha seleccionado más de una vez.`);
                    if (caja) caja.classList.add('caja-error');
                } else {
                    archivosNuevos.add(nombreArchivo);
                }
            }
        }

        // --- C) MOSTRAR ERRORES ---
        if (errores.length > 0) {
            const mensajeHTML = errores.join("<br>");
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                html: mensajeHTML,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Corregir'
            });
            
            if (primerError) primerError.focus();
            return; // Detener envío
        }

        // --- D) ENVIAR FETCH ---
        const btnSubmit = formEditar.querySelector('input[type="submit"]');
        const textoOriginal = btnSubmit.value;
        btnSubmit.value = "Guardando...";
        btnSubmit.disabled = true;

        const formData = new FormData(formEditar);

        fetch(formEditar.action, { 
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            btnSubmit.value = textoOriginal;
            btnSubmit.disabled = false;

            if (data.success) {
                modalEditar.style.display = 'none';
                
                // Alerta de éxito con recarga al confirmar
                Alerta.exito('Botín actualizado correctamente.')
                    .then(() => {
                        location.reload(); 
                    });
            } else {
                // Mostrar errores del servidor (PHP)
                let mensaje = "Error del servidor:<br>";
                if(data.error) mensaje += data.error + "<br>";
                if(data.warnings) mensaje += data.warnings.join("<br>"); // Si tu PHP devuelve advertencias
                
                Swal.fire({
                    icon: 'error',
                    title: 'Ocurrió un problema',
                    html: mensaje
                });
            }
        })
        .catch(error => {
            console.error('Error update:', error);
            Alerta.error('Error de conexión con el servidor.');
            btnSubmit.value = textoOriginal;
            btnSubmit.disabled = false;
        });
    });

    // ==========================================
    // 5. ACTIVAR PREVIEWS DE IMÁGENES
    // ==========================================
    if (typeof setupImagePreview === 'function') {
        // Previews para el modal EDITAR
        setupImagePreview('imgEditBotin1', 'previewEditBotin1');
        setupImagePreview('imgEditBotin2', 'previewEditBotin2');
        setupImagePreview('imgEditBotin3', 'previewEditBotin3');
        setupImagePreview('imgEditBotin4', 'previewEditBotin4');

        // Previews para el modal AGREGAR (si están en la misma página)
        setupImagePreview('imgBotin1', 'previewBotin1');
        setupImagePreview('imgBotin2', 'previewBotin2');
        setupImagePreview('imgBotin3', 'previewBotin3');
        setupImagePreview('imgBotin4', 'previewBotin4');
    }
});