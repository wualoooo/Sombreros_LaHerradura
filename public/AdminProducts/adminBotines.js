document.addEventListener('DOMContentLoaded', () => {

    const modalEditar = document.getElementById('modal-EditBotin');
    const formEditar = document.getElementById('form-EditBotin');
    const tablaBody = document.getElementById('tabla-botines-body'); 
    const btnCerrar = modalEditar ? modalEditar.querySelector('.close') : null;

    if (!modalEditar || !formEditar || !tablaBody) {
        console.error("ERROR: No se encontraron elementos del modal de Botines.");
    }

    // ==========================================
    // 1. FUNCIONES AUXILIARES
    // ==========================================
    const limpiarModalEditar = () => {
        formEditar.reset();

        // Resetear pasarela
        document.querySelectorAll('#modal-EditBotin .pasarela-step-edit').forEach(el => el.style.display = 'none');
        const paso1 = document.getElementById('step-edit-botin-1');
        if (paso1) paso1.style.display = 'block';

        document.querySelectorAll('#modal-EditBotin .paso-dot-edit').forEach((dot, index) => {
            if (index === 0) dot.classList.add('active');
            else dot.classList.remove('active');
        });

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
        const rutaBase = '/LaHerradura/uploads/botines/';
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
    // 2. GENERAR SKU AUTOMÁTICO (Botón Agregar)
    // ==========================================
    const btnAgregar = document.getElementById('btnAgg-Botin');
    if (btnAgregar) {
        btnAgregar.addEventListener('click', () => {
            const inputSKU = document.getElementById('SKUBotin'); 
            const modalAgregar = document.getElementById('modal-AggBotin');
            
            const random = Math.floor(100 + Math.random() * 900);
            const fecha = Date.now().toString().slice(-4);
            const skuGenerado = `BOT-${fecha}${random}`;
            
            if (inputSKU) {
                inputSKU.value = skuGenerado;
                inputSKU.readOnly = true; 
            }
            if (modalAgregar) modalAgregar.style.display = 'block';
        });
    }

    // ==========================================
    // 3. EVENTOS DE LA TABLA (EDITAR, ELIMINAR, VER)
    // ==========================================
    tablaBody.addEventListener('click', (e) => {

        // --- A) BOTÓN EDITAR ---
        const btnEditar = e.target.closest('.btn-editarBotin');
        if (btnEditar) {
            const id = btnEditar.getAttribute('data-id');
            limpiarModalEditar();

            fetch(`/LaHerradura/Controller/CRUD_Botines/ViewBotines.php?id=${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        Swal.fire('Error', data.error, 'error');
                        return;
                    }

                    document.getElementById('edit-id-botin').value = data.id_botin;
                    document.getElementById('edit-SKUBotin').value = data.SKU || '';
                    document.getElementById('edit-NombreBotin').value = data.Nombre;
                    document.getElementById('edit-PrecioBotin').value = data.Precio;
                    document.getElementById('edit-TallaBotin').value = data.Talla;

                    document.getElementById('edit-MaterialBotin').value = data.id_material || "Null";
                    document.getElementById('edit-SuelaBotin').value = data.id_suela || "Null";

                    cargarPreviewDesdeBD(data.Img1, 'previewEditBotin1');
                    cargarPreviewDesdeBD(data.Img2, 'previewEditBotin2');
                    cargarPreviewDesdeBD(data.Img3, 'previewEditBotin3');
                    cargarPreviewDesdeBD(data.Img4, 'previewEditBotin4');

                    modalEditar.style.display = 'block';
                })
                .catch(err => {
                    console.error('Error fetching data:', err);
                    Swal.fire('Error', 'No se pudo cargar la información del botín.', 'error');
                });
        }

        // --- B) BOTÓN ELIMINAR ---
        const btnEliminar = e.target.closest('.btn-eliminarBotin');
        if (btnEliminar) {
            const id = btnEliminar.dataset.id;
            Alerta.confirmar(`¿Estás seguro de eliminar el botín ID ${id}?`, 'Sí, eliminar')
                .then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData();
                        formData.append('id', id);

                        fetch('/LaHerradura/Controller/CRUD_Botines/eliminarBotin.php', {
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
        const btnVer = e.target.closest('.btn-verBotin');
        if (btnVer) {
            const id = btnVer.dataset.id;
            const modalVer = document.getElementById('modal-ViewProducts') || document.getElementById('modal-ViewProduct');

            if(!modalVer) return;

            fetch(`/LaHerradura/Controller/CRUD_Botines/ViewBotines.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('name-sombrero-vp').textContent = data.Nombre;
                    document.getElementById('precio-vp').textContent = `$${data.Precio}.00 mxn`;
                    document.getElementById('modal-color').textContent = `Talla: ${data.Talla} mx`; 
                    document.getElementById('modal-horma').textContent = `Material: ${data.Nombre_Material || data.Material}`;
                    document.getElementById('modal-copa').textContent = `Suela: ${data.Nombre_Suela || data.Suela}`;
                    
                    // Limpiamos los campos que no usan los botines
                    document.getElementById('modal-tam-copa').textContent = "";
                    document.getElementById('modal-tam-ala').textContent = "";
                    document.getElementById('modal-material').textContent = "";

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
                        galeriaHtml += `<img class="thumbnail-modal" src="/LaHerradura/uploads/botines/${imgSrc}" alt="Miniatura">`;
                    });
                    galeriaHtml += `</div>`;
                    imgCont.innerHTML = galeriaHtml;

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
    // 4. GUARDAR CAMBIOS DE EDICIÓN
    // ==========================================
    if (formEditar) {
        formEditar.addEventListener('submit', function(e) {
            e.preventDefault();

            const btnSubmit = document.getElementById('btnGuardarEditBotines');
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
                    Alerta.exito('Botín actualizado correctamente.')
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
    // 5. ACTIVAR PREVIEWS
    // ==========================================
    if (typeof setupImagePreview === 'function') {
        setupImagePreview('imgEditBotin1', 'previewEditBotin1');
        setupImagePreview('imgEditBotin2', 'previewEditBotin2');
        setupImagePreview('imgEditBotin3', 'previewEditBotin3');
        setupImagePreview('imgEditBotin4', 'previewEditBotin4');
        setupImagePreview('imgBotin1', 'previewBotin1');
        setupImagePreview('imgBotin2', 'previewBotin2');
        setupImagePreview('imgBotin3', 'previewBotin3');
        setupImagePreview('imgBotin4', 'previewBotin4');
    }
});