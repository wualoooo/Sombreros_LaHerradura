document.addEventListener('DOMContentLoaded', () => {

    // ==========================================
    // 1. REFERENCIAS AL DOM
    // ==========================================
    const modalEditar = document.getElementById('modal-EditTexana');
    const formEditar = document.getElementById('form-EditTexana');
    const tablaBody = document.getElementById('tabla-texanas-body'); 
    const btnCerrar = modalEditar ? modalEditar.querySelector('.close') : null;

    if (!modalEditar || !formEditar || !tablaBody) {
        console.error("ERROR CRÍTICO: No se encontraron elementos del modal de Texanas.");
        // No retornamos para que al menos funcione el botón de "Agregar" si existe
    }

    // ==========================================
    // 2. FUNCIONES AUXILIARES
    // ==========================================
    const limpiarModalEditar = () => {
        formEditar.reset();

        // Resetear la pasarela al paso 1
        document.querySelectorAll('#modal-EditTexana .pasarela-step-edit').forEach(el => el.style.display = 'none');
        const paso1 = document.getElementById('step-edit-texana-1');
        if (paso1) paso1.style.display = 'block';

        // Resetear bolitas
        document.querySelectorAll('#modal-EditTexana .paso-dot-edit').forEach((dot, index) => {
            if (index === 0) dot.classList.add('active');
            else dot.classList.remove('active');
        });

        // Limpiar checkboxes
        document.querySelectorAll('#modal-EditTexana .talla-edit-checkbox').forEach(cb => cb.checked = false);

        // Limpiar imágenes
        const inputsArchivo = formEditar.querySelectorAll('input[type="file"]');
        inputsArchivo.forEach(input => input.value = '');
        const previews = formEditar.querySelectorAll('.preview');
        previews.forEach(img => {
            img.src = '#';
            img.style.display = 'none';
        });
        formEditar.querySelectorAll('.input-error, .caja-error').forEach(el => el.classList.remove('input-error', 'caja-error'));
    };

    const cargarPreviewDesdeBD = (nombreArchivo, idImgPreview) => {
        const rutaBase = '/LaHerradura/uploads/texanas/';
        const preview = document.getElementById(idImgPreview);
        if (nombreArchivo && nombreArchivo !== '') {
            preview.src = rutaBase + nombreArchivo;
            preview.style.display = 'block';
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    };

    if (btnCerrar) {
        btnCerrar.addEventListener('click', () => {
            modalEditar.style.display = 'none';
        });
    }

    // ==========================================
    // 3. GENERAR SKU AUTOMÁTICO (Botón Agregar)
    // ==========================================
    const btnAgregar = document.getElementById('btnAgg-Texana');
    if (btnAgregar) {
        btnAgregar.addEventListener('click', () => {
            const inputSKU = document.getElementById('SKUTexana'); // ID del modal AGREGAR
            const modalAgregar = document.getElementById('modal-AggTexana');
            
            const random = Math.floor(100 + Math.random() * 900);
            const fecha = Date.now().toString().slice(-4);
            const skuGenerado = `TEX-${fecha}${random}`;
            
            if (inputSKU) {
                inputSKU.value = skuGenerado;
                inputSKU.readOnly = true; 
            }
            if (modalAgregar) modalAgregar.style.display = 'block';
        });
    }

    // ==========================================
    // 4. EVENTOS DE LA TABLA (EDITAR, ELIMINAR, VER)
    // ==========================================
    tablaBody.addEventListener('click', (e) => {

        // --- A) BOTÓN EDITAR ---
        const btnEditar = e.target.closest('.btn-editarTexana');
        if (btnEditar) {
            const id = btnEditar.getAttribute('data-id');
            limpiarModalEditar();

            fetch(`/LaHerradura/Controller/CRUD_Texanas/ViewTexanas.php?id=${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        Swal.fire('Error', data.error, 'error');
                        return;
                    }

                    document.getElementById('edit-id-texana').value = data.id_texana;
                    document.getElementById('edit-SKUTexana').value = data.SKU || '';
                    document.getElementById('edit-NombreTexana').value = data.Nombre;
                    document.getElementById('edit-PrecioTexana').value = data.Precio;

                    document.getElementById('edit-ColorTexana').value = data.id_color || "Null";
                    document.getElementById('edit-HormaTexana').value = data.id_horma || "Null";
                    document.getElementById('edit-CopaTexana').value = data.id_copa || "Null";
                    document.getElementById('edit-MaterialTexana').value = data.id_material || "Null";

                    document.getElementById('edit-TamañoCopaTexana').value = data.Tam_Copa;
                    document.getElementById('edit-TamañoAlaTexana').value = data.Tam_ala;

                    // Marcar tallas
                    if (data.Tallas && data.Tallas !== "Unitalla") {
                        const tallasGuardadas = data.Tallas.split(',');
                        tallasGuardadas.forEach(talla => {
                            const cb = document.querySelector(`#modal-EditTexana .talla-edit-checkbox[value="${talla.trim()}"]`);
                            if (cb) cb.checked = true;
                        });
                    }

                    cargarPreviewDesdeBD(data.Img1, 'previewEditTexana1');
                    cargarPreviewDesdeBD(data.Img2, 'previewEditTexana2');
                    cargarPreviewDesdeBD(data.Img3, 'previewEditTexana3');
                    cargarPreviewDesdeBD(data.Img4, 'previewEditTexana4');

                    modalEditar.style.display = 'block';
                })
                .catch(err => {
                    console.error('Error fetching data:', err);
                    Swal.fire('Error', 'No se pudo cargar la información de la texana.', 'error');
                });
        }

        // --- B) BOTÓN ELIMINAR ---
        const btnEliminar = e.target.closest('.btn-eliminarTexana');
        if (btnEliminar) {
            const id = btnEliminar.dataset.id;
            Alerta.confirmar(`¿Estás seguro de eliminar la texana ID ${id}?`, 'Sí, eliminar')
                .then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData();
                        formData.append('id', id);

                        fetch('/LaHerradura/Controller/CRUD_Texanas/eliminarTexana.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                btnEliminar.closest('tr').remove();
                                Alerta.toast('Producto eliminado correctamente', 'success');
                            } else {
                                Alerta.error('Error al eliminar: ' + data.error);
                            }
                        })
                        .catch(err => console.error(err));
                    }
                });
        }

        // --- C) BOTÓN VER DETALLES ---
        const btnVer = e.target.closest('.btn-verTexana');
        if (btnVer) {
            const id = btnVer.dataset.id;
            const modalVer = document.getElementById('modal-ViewProducts') || document.getElementById('modal-ViewProduct');

            if(!modalVer) return;

            fetch(`/LaHerradura/Controller/CRUD_Texanas/ViewTexanas.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('name-sombrero-vp').textContent = data.Nombre; // Reusa IDs del modal genérico
                    document.getElementById('precio-vp').textContent = `$${data.Precio}.00 mxn`;
                    document.getElementById('modal-color').textContent = `Color: ${data.Nombre_Color || data.Color}`;
                    document.getElementById('modal-horma').textContent = `Horma: ${data.Nombre_Horma || data.Horma}`;
                    document.getElementById('modal-copa').textContent = `Copa: ${data.Nombre_Copa || data.Copa}`;
                    document.getElementById('modal-tam-copa').textContent = `Tamaño copa: ${data.Tam_Copa} cm`;
                    document.getElementById('modal-tam-ala').textContent = `Tamaño ala: ${data.Tam_ala} cm`;
                    document.getElementById('modal-material').textContent = `Material: ${data.Nombre_Material || data.Material}`;

                    const imgCont = document.getElementById('img-sombrero');
                    let galeriaHtml = `
                        <div id="vista-foto">
                            <img id="main-image-modal" src="/LaHerradura/uploads/texanas/${data.Img1}" alt="${data.Nombre}">
                        </div>
                        <div id="vista-miniaturas">
                    `;
                    const imagenes = [];
                    if (data.Img1) imagenes.push(data.Img1);
                    if (data.Img2) imagenes.push(data.Img2);
                    if (data.Img3) imagenes.push(data.Img3);
                    if (data.Img4) imagenes.push(data.Img4);

                    imagenes.forEach(imgSrc => {
                        galeriaHtml += `<img class="thumbnail-modal" src="/LaHerradura/uploads/texanas/${imgSrc}" alt="Miniatura">`;
                    });
                    galeriaHtml += `</div>`;
                    imgCont.innerHTML = galeriaHtml;

                    // Re-activar listeners de galería
                    const mainImage = document.getElementById('main-image-modal');
                    const thumbnails = document.querySelectorAll('#img-sombrero .thumbnail-modal');
                    thumbnails.forEach(thumbnail => {
                        thumbnail.addEventListener('click', () => mainImage.src = thumbnail.src);
                    });

                    modalVer.style.display = 'block';
                    
                    const spanClose = modalVer.querySelector('.close');
                    if(spanClose) {
                        spanClose.onclick = () => {
                            modalVer.style.display = 'none';
                            imgCont.innerHTML = "";
                        }
                    }
                });
        }
    });

    // ==========================================
    // 5. GUARDAR CAMBIOS DE EDICIÓN
    // ==========================================
    if (formEditar) {
        formEditar.addEventListener('submit', function(e) {
            e.preventDefault();

            const btnSubmit = document.getElementById('btnGuardarEditTexanas');
            const textoOriginal = btnSubmit.textContent;
            btnSubmit.textContent = "Guardando...";
            btnSubmit.disabled = true;

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btnSubmit.textContent = textoOriginal;
                btnSubmit.disabled = false;

                if (data.success) {
                    modalEditar.style.display = 'none';
                    Alerta.exito('Texana actualizada correctamente.')
                        .then(() => location.reload());
                } else {
                    let mensaje = "Error del servidor:<br>";
                    if(data.error) mensaje += data.error + "<br>";
                    Swal.fire({ icon: 'error', title: 'Ocurrió un problema', html: mensaje });
                }
            })
            .catch(error => {
                console.error('Error update:', error);
                Alerta.error('Error de conexión con el servidor.');
                btnSubmit.textContent = textoOriginal;
                btnSubmit.disabled = false;
            });
        });
    }

    // ==========================================
    // 6. ACTIVAR PREVIEWS
    // ==========================================
    if (typeof setupImagePreview === 'function') {
        setupImagePreview('imgEditTexana1', 'previewEditTexana1');
        setupImagePreview('imgEditTexana2', 'previewEditTexana2');
        setupImagePreview('imgEditTexana3', 'previewEditTexana3');
        setupImagePreview('imgEditTexana4', 'previewEditTexana4');
        setupImagePreview('imgTexana1', 'previewTexana1');
        setupImagePreview('imgTexana2', 'previewTexana2');
        setupImagePreview('imgTexana3', 'previewTexana3');
        setupImagePreview('imgTexana4', 'previewTexana4');
    }
});