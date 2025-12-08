document.addEventListener('DOMContentLoaded', () => {

    // ==========================================
    // 1. REFERENCIAS AL DOM
    // ==========================================
    const modalEditar = document.getElementById('modal-EditSombrero');
    const formEditar = document.getElementById('form-EditSom');
    const tablaBody = document.getElementById('tabla-sombreros-body'); 
    const btnCerrar = modalEditar ? modalEditar.querySelector('.close') : null;

    if (!modalEditar || !formEditar || !tablaBody) {
        console.error("ERROR CRÍTICO: No se encontraron elementos del modal o la tabla.");
        return;
    }

    // ==========================================
    // 2. FUNCIONES AUXILIARES
    // ==========================================

    const limpiarModalEditar = () => {
        formEditar.reset();
        const inputsArchivo = formEditar.querySelectorAll('input[type="file"]');
        inputsArchivo.forEach(input => input.value = '');
        const previews = formEditar.querySelectorAll('.preview');
        previews.forEach(img => {
            img.src = '#';
            img.style.display = 'none';
        });
        document.querySelectorAll('.input-error, .caja-error').forEach(el => {
            el.classList.remove('input-error', 'caja-error');
        });
    };

    const cargarPreviewDesdeBD = (nombreArchivo, idImgPreview) => {
        const rutaBase = '/LaHerradura/uploads/sombreros/'; 
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

    if(btnCerrar) {
        btnCerrar.onclick = () => modalEditar.style.display = 'none';
    }
    window.onclick = (event) => {
        if (event.target == modalEditar) modalEditar.style.display = 'none';
    }

    // CLIC EN LA TABLA
    tablaBody.addEventListener('click', (e) => {
        
        // --- A) BOTÓN EDITAR ---
        if (e.target.classList.contains('btn-editarSombrero')) {
            limpiarModalEditar();
            const id = e.target.dataset.id;
            console.log("Editando ID:", id);

            fetch(`/LaHerradura/Controller/CRUD_Sombreros/ViewSombreros.php?id=${id}`)
                .then(response => {
                    if (!response.ok) throw new Error("Error de red");
                    return response.json();
                })
                .then(data => {
                    if(data.error){
                        Alerta.error("Error del servidor: " + data.error); // CAMBIO: Alerta visual
                        return;
                    }

                    // Rellenar formulario (sin cambios)
                    document.getElementById('edit-id-sombrero').value = data.id_sombrero; 
                    document.getElementById('edit-NombreSombrero').value = data.Nombre;
                    document.getElementById('edit-ColorSombrero').value = data.id_color;
                    document.getElementById('edit-MaterialSombrero').value = data.id_material;
                    document.getElementById('edit-PrecioSombrero').value = data.Precio;
                    document.getElementById('edit-HormaSombrero').value = data.id_horma;
                    document.getElementById('edit-CopaSombrero').value = data.id_copa;
                    document.getElementById('edit-TamañoCopaSombrero').value = data.Tam_Copa;
                    document.getElementById('edit-TamañoAlaSombrero').value = data.Tam_ala;
                    
                    cargarPreviewDesdeBD(data.Img1, 'previewEditSombrero1');
                    cargarPreviewDesdeBD(data.Img2, 'previewEditSombrero2');
                    cargarPreviewDesdeBD(data.Img3, 'previewEditSombrero3');
                    cargarPreviewDesdeBD(data.Img4, 'previewEditSombrero4');
                    
                    modalEditar.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error al cargar datos:', error);
                    Alerta.error("No se pudieron cargar los datos."); // CAMBIO
                });
        }

        // --- B) BOTÓN ELIMINAR (GRAN CAMBIO AQUÍ) ---
        if (e.target.classList.contains('btn-eliminarSombrero')) {
            const id = e.target.dataset.id;

            // Usamos Alerta.confirmar en lugar de confirm()
            Alerta.confirmar(`¿Estás seguro de eliminar el sombrero ID ${id}?`, 'Sí, eliminar')
                .then((result) => {
                    // Solo si el usuario dio click en "Sí, eliminar"
                    if (result.isConfirmed) {
                        const formData = new FormData();
                        formData.append('id', id);

                        fetch('/LaHerradura/Controller/CRUD_Sombreros/eliminarSombreros.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                e.target.closest('tr').remove();
                                Alerta.toast('Producto eliminado correctamente', 'success'); // CAMBIO: Toast elegante
                            } else {
                                Alerta.error('Error al eliminar: ' + data.error); // CAMBIO
                            }
                        })
                        .catch(err => console.error(err));
                    }
                });
        }
    });

    // ==========================================
    // 4. ENVIAR FORMULARIO DE EDICIÓN
    // ==========================================
    formEditar.addEventListener('submit', (e) => {
        e.preventDefault(); 

        const limpiarEstilosError = () => {
            formEditar.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
            formEditar.querySelectorAll('.caja-error').forEach(el => el.classList.remove('caja-error'));
        };
        limpiarEstilosError();

        let errores = [];
        let primerError = null;

        const marcarError = (id, mensaje) => {
            const el = document.getElementById(id);
            if (el) {
                el.classList.add('input-error');
                if (!primerError) primerError = el;
            }
            errores.push(mensaje);
        };

        // --- Validaciones (Igual que antes) ---
        const textos = ['edit-NombreSombrero'];
        textos.forEach(id => {
            const input = document.getElementById(id);
            const valor = input.value.trim();
            const nombreCampo = id.replace('edit-', '').replace('Sombrero', '');

            if (valor === "") marcarError(id, `El campo ${nombreCampo} no puede estar vacío.`);
            else if (/^\d+$/.test(valor)) marcarError(id, `El ${nombreCampo} no puede ser solo números.`);
            else if (valor.length < 3) marcarError(id, `El ${nombreCampo} es muy corto.`);
        });

        const selects = ['edit-HormaSombrero', 'edit-CopaSombrero', 'edit-ColorSombrero', 'edit-MaterialSombrero'];
        selects.forEach(id => {
            const input = document.getElementById(id);
            if (input.value === "Null") marcarError(id, `Selecciona una opción válida.`);
        });

        const numeros = ['edit-PrecioSombrero', 'edit-TamañoCopaSombrero', 'edit-TamañoAlaSombrero'];
        numeros.forEach(id => {
            const input = document.getElementById(id);
            if (input.value === "" || isNaN(input.value) || Number(input.value) <= 0) {
                marcarError(id, `Revisa el valor numérico.`);
            }
        });

        const archivosNuevos = new Set();
        for (let i = 1; i <= 4; i++) {
            const idInput = `imgEditSombrero${i}`; 
            const input = document.getElementById(idInput);
            if (input && input.files.length > 0) {
                const nombreArchivo = input.files[0].name;
                const caja = input.closest('.caja-preview');
                if (archivosNuevos.has(nombreArchivo)) {
                    errores.push(`La imagen "${nombreArchivo}" está repetida.`);
                    if (caja) caja.classList.add('caja-error');
                } else {
                    archivosNuevos.add(nombreArchivo);
                }
            }
        }

        // --- D) MOSTRAR ERRORES CON SWEETALERT ---
        if (errores.length > 0) {
            // Unimos los errores con saltos de línea HTML (<br>)
            const mensajeHTML = errores.join("<br>");
            
            // CAMBIO: Alerta visual con HTML activado
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                html: mensajeHTML, // Usamos 'html' en vez de 'text' para que lea los <br>
                confirmButtonColor: '#d33',
                confirmButtonText: 'Corregir'
            });
            
            if (primerError) primerError.focus();
            return;
        }

        // --- E) FETCH DE GUARDADO ---
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
                
                // CAMBIO: Esperamos a que el usuario presione OK para recargar
                Alerta.exito('Sombrero actualizado correctamente.')
                    .then(() => {
                        location.reload(); 
                    });
            } else {
                let mensaje = "Error del servidor:<br>";
                if(data.error) mensaje += data.error + "<br>";
                if(data.warnings) mensaje += data.warnings.join("<br>");
                
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

    // 5. ACTIVAR PREVIEWS (Sin cambios)
    if (typeof setupImagePreview === 'function') {
        setupImagePreview('imgEditSombrero1', 'previewEditSombrero1');
        setupImagePreview('imgEditSombrero2', 'previewEditSombrero2');
        setupImagePreview('imgEditSombrero3', 'previewEditSombrero3');
        setupImagePreview('imgEditSombrero4', 'previewEditSombrero4');
        setupImagePreview('imgSombrero1', 'previewSombrero1');
        setupImagePreview('imgSombrero2', 'previewSombrero2');
        setupImagePreview('imgSombrero3', 'previewSombrero3');
        setupImagePreview('imgSombrero4', 'previewSombrero4');
    }
});