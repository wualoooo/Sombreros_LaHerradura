document.addEventListener('DOMContentLoaded', () => {

    // ==========================================
    // 1. REFERENCIAS AL DOM (VARIABLES GLOBALES)
    // ==========================================
    const modalEditar = document.getElementById('modal-EditSombrero');
    const formEditar = document.getElementById('form-EditSom');
    const tablaBody = document.getElementById('tabla-sombreros-body'); 
    const btnCerrar = modalEditar ? modalEditar.querySelector('.close') : null;

    // Validación de seguridad: Si falta algo, no hacemos nada para no causar errores
    if (!modalEditar || !formEditar || !tablaBody) {
        console.error("ERROR CRÍTICO: No se encontraron elementos del modal o la tabla en el HTML.");
        return;
    }

    // ==========================================
    // 2. FUNCIONES AUXILIARES
    // ==========================================

    // --- FUNCIÓN DE LIMPIEZA ---
    // Esta función borra "fantasmas" de ediciones anteriores
    const limpiarModalEditar = () => {
        // 1. Reseteamos el formulario (textos y selects)
        formEditar.reset();

        // 2. Borramos manualmente los inputs de archivo (el reset a veces no los limpia bien)
        const inputsArchivo = formEditar.querySelectorAll('input[type="file"]');
        inputsArchivo.forEach(input => input.value = '');

        // 3. Ocultamos y limpiamos las previsualizaciones de imagen
        const previews = formEditar.querySelectorAll('.preview');
        previews.forEach(img => {
            img.src = '#';
            img.style.display = 'none';
        });
        
        // 4. Quitamos bordes rojos de errores viejos
        document.querySelectorAll('.input-error, .caja-error').forEach(el => {
            el.classList.remove('input-error', 'caja-error');
        });
    };

    // --- FUNCIÓN PARA MOSTRAR PREVIEW DE IMAGEN (DB) ---
    const cargarPreviewDesdeBD = (nombreArchivo, idImgPreview) => {
        // RUTA ABSOLUTA: Asegúrate que 'LaHerradura' coincida con tu carpeta real
        const rutaBase = '/LaHerradura/uploads/sombreros/'; 
        const img = document.getElementById(idImgPreview);
        
        if (img) {
            if (nombreArchivo && nombreArchivo.trim() !== "") {
                img.src = rutaBase + nombreArchivo;
                img.style.display = 'block'; // ¡Aparece!
            } else {
                img.src = '#';
                img.style.display = 'none'; // Se oculta
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

    // CLIC EN LA TABLA (Delegación)
    tablaBody.addEventListener('click', (e) => {
        
        // ------------------------------------------------
        // A) BOTÓN EDITAR
        // ------------------------------------------------
        if (e.target.classList.contains('btn-editarSombrero')) {
            
            // 1. ¡LIMPIEZA PRIMERO! (Antes de pedir datos)
            limpiarModalEditar();

            const id = e.target.dataset.id;
            console.log("Editando ID:", id); // Para depurar en consola

            // 2. PEDIR DATOS AL SERVIDOR
            fetch(`/LaHerradura/Controller/CRUD_Sombreros/ViewSombreros.php?id=${id}`)
                .then(response => {
                    if (!response.ok) throw new Error("Error de red o archivo PHP no encontrado");
                    return response.json();
                })
                .then(data => {
                    if(data.error){
                        alert("Error del servidor: " + data.error);
                        return;
                    }

                    // 3. RELLENAR EL FORMULARIO
                    document.getElementById('edit-id-sombrero').value = data.id_sombrero; 
                    
                    // Textos y Números
                    document.getElementById('edit-NombreSombrero').value = data.Nombre;
                    document.getElementById('edit-ColorSombrero').value = data.Color;
                    document.getElementById('edit-MaterialSombrero').value = data.Material;
                    document.getElementById('edit-PrecioSombrero').value = data.Precio;
                    
                    // Selects
                    document.getElementById('edit-HormaSombrero').value = data.Horma;
                    document.getElementById('edit-CopaSombrero').value = data.Copa;
                    
                    // Tamaños
                    document.getElementById('edit-TamañoCopaSombrero').value = data.Tam_Copa;
                    document.getElementById('edit-TamañoAlaSombrero').value = data.Tam_ala;
                    
                    // 4. MOSTRAR IMÁGENES
                    cargarPreviewDesdeBD(data.Img1, 'previewEditSombrero1');
                    cargarPreviewDesdeBD(data.Img2, 'previewEditSombrero2');
                    cargarPreviewDesdeBD(data.Img3, 'previewEditSombrero3');
                    cargarPreviewDesdeBD(data.Img4, 'previewEditSombrero4');
                    
                    // 5. ABRIR EL MODAL
                    modalEditar.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error al cargar datos:', error);
                    alert("No se pudieron cargar los datos. Revisa la consola (F12).");
                });
        }

        // ------------------------------------------------
        // B) BOTÓN ELIMINAR
        // ------------------------------------------------
        if (e.target.classList.contains('btn-eliminarSombrero')) {
            const id = e.target.dataset.id;

            if (confirm(`¿Estás seguro de eliminar el sombrero ID ${id}?`)) {
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
                        alert('Producto eliminado.');
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(err => console.error(err));
            }
        }
    });

    // ==========================================
    // 4. ENVIAR FORMULARIO DE EDICIÓN (GUARDAR)
    // ==========================================
    formEditar.addEventListener('submit', (e) => {
        e.preventDefault(); 

        // --- A) LIMPIEZA DE ERRORES PREVIOS ---
        // Quitamos bordes rojos viejos
        const limpiarEstilosError = () => {
            formEditar.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
            formEditar.querySelectorAll('.caja-error').forEach(el => el.classList.remove('caja-error'));
        };
        limpiarEstilosError();

        let errores = [];
        let primerError = null;

        // Helper para marcar errores
        const marcarError = (id, mensaje) => {
            const el = document.getElementById(id);
            if (el) {
                el.classList.add('input-error'); // Asegúrate de tener esta clase en tu CSS
                if (!primerError) primerError = el;
            }
            errores.push(mensaje);
        };

        // --- B) VALIDACIONES DE TEXTO Y SELECTS ---
        
        // 1. Campos de Texto (Nombre, Color, Material)
        const textos = ['edit-NombreSombrero', 'edit-ColorSombrero', 'edit-MaterialSombrero'];
        textos.forEach(id => {
            const input = document.getElementById(id);
            const valor = input.value.trim();
            const nombreCampo = id.replace('edit-', '').replace('Sombrero', '');

            if (valor === "") {
                marcarError(id, `El campo ${nombreCampo} no puede estar vacío.`);
            } else if (/^\d+$/.test(valor)) {
                marcarError(id, `El ${nombreCampo} no puede ser solo números.`);
            } else if (valor.length < 3) {
                marcarError(id, `El ${nombreCampo} es muy corto.`);
            }
        });

        // 2. Selects (Horma, Copa)
        const selects = ['edit-HormaSombrero', 'edit-CopaSombrero'];
        selects.forEach(id => {
            const input = document.getElementById(id);
            if (input.value === "Null") {
                marcarError(id, `Selecciona una opción válida para ${id.replace('edit-','').replace('Sombrero','')}.`);
            }
        });

        // 3. Números (Precios y Tamaños)
        const numeros = ['edit-PrecioSombrero', 'edit-TamañoCopaSombrero', 'edit-TamañoAlaSombrero'];
        numeros.forEach(id => {
            const input = document.getElementById(id);
            if (input.value === "" || isNaN(input.value) || Number(input.value) <= 0) {
                marcarError(id, `Revisa el valor numérico de ${id.replace('edit-','').replace('Sombrero','')}.`);
            }
        });

        // --- C) VALIDACIÓN DE IMÁGENES (ESPECIAL PARA EDITAR) ---
        // Solo validamos si el usuario seleccionó un archivo NUEVO.
        // No es obligatorio subir fotos, pero si suben, no pueden repetirse entre sí.
        
        const archivosNuevos = new Set();
        
        for (let i = 1; i <= 4; i++) {
            // OJO: Aquí usamos el 'name' porque los IDs de los inputs file son distintos
            // Tu HTML tiene name="imgSombrero1" e id="imgEditSombrero1"
            const idInput = `imgEditSombrero${i}`; 
            const input = document.getElementById(idInput);
            
            if (input && input.files.length > 0) {
                const nombreArchivo = input.files[0].name;
                const caja = input.closest('.caja-preview');

                // Validar duplicados EN ESTA SUBIDA
                if (archivosNuevos.has(nombreArchivo)) {
                    errores.push(`Estás intentando subir la imagen "${nombreArchivo}" dos veces.`);
                    if (caja) caja.classList.add('caja-error');
                } else {
                    archivosNuevos.add(nombreArchivo);
                }
            }
        }

        // --- D) DECISIÓN: ¿ENVIAMOS O NO? ---
        
        if (errores.length > 0) {
            // Mostramos errores y cancelamos
            let mensaje = "⚠️ No se pueden guardar los cambios:\n\n";
            mensaje += errores.join("\n");
            alert(mensaje);
            
            if (primerError) primerError.focus();
            return; // <--- AQUÍ SE DETIENE TODO SI HAY ERRORES
        }

        // --- E) SI PASA LA VALIDACIÓN, ENVIAMOS EL FETCH ---

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
                alert('✅ Sombrero actualizado correctamente.');
                modalEditar.style.display = 'none';
                location.reload(); 
            } else {
                let mensaje = "Error del servidor:\n";
                if(data.error) mensaje += data.error + "\n";
                if(data.warnings) mensaje += data.warnings.join("\n");
                alert(mensaje);
            }
        })
        .catch(error => {
            console.error('Error update:', error);
            alert('Error de conexión con el servidor.');
            btnSubmit.value = textoOriginal;
            btnSubmit.disabled = false;
        });
    });

    // ==========================================
    // 5. ACTIVAR PREVIEWS DE SELECCIÓN MANUAL
    // ==========================================
    // Esto hace que si CAMBIAS la foto manualmente, se vea la nueva antes de guardar.
    // Requiere que tengas cargado el script 'viewImages.js' o la función setupImagePreview
    if (typeof setupImagePreview === 'function') {
        // Para Editar
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