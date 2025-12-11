document.addEventListener('DOMContentLoaded', () => {

    // ==========================================
    // 1. REFERENCIAS AL DOM
    // ==========================================
    const modalEditar = document.getElementById('modal-EditCinturon');
    const formEditar = document.getElementById('form-EditCinturon');
    const tablaBody = document.getElementById('tabla-cinturones-body'); 
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
        const rutaBase = '/LaHerradura/uploads/cinturones/'; 
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
        if (e.target.classList.contains('btn-editarCinturon')) {
            limpiarModalEditar();
            const id = e.target.dataset.id;
            console.log("Editando ID:", id);

            fetch(`/LaHerradura/Controller/CRUD_Cinturones/ViewCinturones.php?id=${id}`)
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
                    document.getElementById('edit-id-cinturon').value = data.id_cinturon; 
                    document.getElementById('edit-NombreCinturon').value = data.Nombre;
                    document.getElementById('edit-MaterialCinturon').value = data.id_material;
                    document.getElementById('edit-PrecioCinturon').value = data.Precio;
                    document.getElementById('edit-AdornoCinturon').value = data.id_adorno;
                    document.getElementById('edit-TamañoCinturon').value = data.Tamaño;
                    
                    cargarPreviewDesdeBD(data.Img1, 'previewEditCinturon1');
                    cargarPreviewDesdeBD(data.Img2, 'previewEditCinturon2');
                    cargarPreviewDesdeBD(data.Img3, 'previewEditCinturon3');
                    cargarPreviewDesdeBD(data.Img4, 'previewEditCinturon4');
                    
                    modalEditar.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error al cargar datos:', error);
                    Alerta.error("No se pudieron cargar los datos."); // CAMBIO
                });
        }

        // --- B) BOTÓN ELIMINAR (GRAN CAMBIO AQUÍ) ---
        if (e.target.classList.contains('btn-eliminarCinturon')) {
            const id = e.target.dataset.id;

            // Usamos Alerta.confirmar en lugar de confirm()
            Alerta.confirmar(`¿Estás seguro de eliminar el cinturon ID ${id}?`, 'Sí, eliminar')
                .then((result) => {
                    // Solo si el usuario dio click en "Sí, eliminar"
                    if (result.isConfirmed) {
                        const formData = new FormData();
                        formData.append('id', id);

                        fetch('/LaHerradura/Controller/CRUD_Cinturones/eliminarCinturon.php', {
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

        // --- C) LÓGICA DE "VER DETALLES" (EL OJITO) ---
    if (e.target.closest('.btn-verCinturon')) {
        const btn = e.target.closest('.btn-verCinturon');
        const id = btn.dataset.id;
        
        // Seleccionamos el modal de VISTA (no el de editar)
        const modalVer = document.getElementById('modal-ViewCinturones');
        
        // Fetch para obtener los datos (reutilizamos tu controlador existente)
        fetch(`/LaHerradura/Controller/CRUD_Cinturones/ViewCinturones.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                // 1. Llenar textos
                document.getElementById('name-sombrero-vp').textContent = data.Nombre
                document.getElementById('precio-vp').textContent = `$${data.Precio}.00 mxn`;
                document.getElementById('modal-material').textContent = `Material: ${data.Nombre_Material || data.id_Material}`;
                document.getElementById('modal-adorno').textContent = `Adorno: ${data.Nombre_Adorno || data.id_Adorno}`;
                document.getElementById('modal-tamaño').textContent = `Tamaño: ${data.Tamaño} cm`;

                // 2. Generar Galería de Imágenes (Tu lógica mejorada)
                const imgCont = document.getElementById('img-sombrero');
                
                let galeriaHtml = `
                    <div id="vista-foto">
                        <img id="main-image-modal" src="/LaHerradura/uploads/cinturones/${data.Img1}" alt="${data.Nombre}">
                    </div>
                    <div id="vista-miniaturas">
                `;

                const imagenes = [];
                if (data.Img1) imagenes.push(data.Img1);
                if (data.Img2) imagenes.push(data.Img2);
                if (data.Img3) imagenes.push(data.Img3);
                if (data.Img4) imagenes.push(data.Img4);

                imagenes.forEach(imgSrc => {
                    const rutaCompleta = `/LaHerradura/uploads/cinturones/${imgSrc}`;
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
        const textos = ['edit-NombreCinturon'];
        textos.forEach(id => {
            const input = document.getElementById(id);
            const valor = input.value.trim();
            const nombreCampo = id.replace('edit-', '').replace('Cinturon', '');

            if (valor === "") marcarError(id, `El campo ${nombreCampo} no puede estar vacío.`);
            else if (/^\d+$/.test(valor)) marcarError(id, `El ${nombreCampo} no puede ser solo números.`);
            else if (valor.length < 3) marcarError(id, `El ${nombreCampo} es muy corto.`);
        });

        const selects = ['edit-AdornoCinturon', 'edit-MaterialCinturon'];
        selects.forEach(id => {
            const input = document.getElementById(id);
            if (input.value === "Null") marcarError(id, `Selecciona una opción válida.`);
        });

        const numeros = ['edit-PrecioCinturon'];
        numeros.forEach(id => {
            const input = document.getElementById(id);
            if (input.value === "" || isNaN(input.value) || Number(input.value) <= 0) {
                marcarError(id, `Revisa el valor numérico.`);
            }
        });

        const archivosNuevos = new Set();
        for (let i = 1; i <= 4; i++) {
            const idInput = `imgEditCinturon${i}`; 
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
                Alerta.exito('Cinturon actualizado correctamente.')
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
        setupImagePreview('imgEditCinturon1', 'previewEditCinturon1');
        setupImagePreview('imgEditCinturon2', 'previewEditCinturon2');
        setupImagePreview('imgEditCinturon3', 'previewEditCinturon3');
        setupImagePreview('imgEditCinturon4', 'previewEditCinturon4');

        setupImagePreview('imgCinturon1', 'previewCinturon1');
        setupImagePreview('imgCinturon2', 'previewCinturon2');
        setupImagePreview('imgCinturon3', 'previewCinturon3');
        setupImagePreview('imgCinturon4', 'previewCinturon4');
    }
});