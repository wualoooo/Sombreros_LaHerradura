document.addEventListener('DOMContentLoaded', () => {

    const modalEditar = document.getElementById('modal-EditCinturon');
    const formEditar = document.getElementById('form-EditCinturon');
    const tablaBody = document.getElementById('tabla-cinturones-body'); 
    const btnCerrar = modalEditar ? modalEditar.querySelector('.close') : null;

    if (!modalEditar || !formEditar || !tablaBody) {
        console.error("ERROR: No se encontraron elementos del modal de Cinturones.");
    }

    // ==========================================
    // 1. FUNCIONES AUXILIARES
    // ==========================================
    const limpiarModalEditar = () => {
        formEditar.reset();

        // Resetear pasarela
        document.querySelectorAll('#modal-EditCinturon .pasarela-step-edit').forEach(el => el.style.display = 'none');
        const paso1 = document.getElementById('step-edit-cinturon-1');
        if (paso1) paso1.style.display = 'block';

        document.querySelectorAll('#modal-EditCinturon .paso-dot-edit').forEach((dot, index) => {
            if (index === 0) dot.classList.add('active');
            else dot.classList.remove('active');
        });

        // Limpiar checkboxes
        document.querySelectorAll('#modal-EditCinturon .talla-edit-checkbox').forEach(cb => cb.checked = false);

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
        const rutaBase = '/LaHerradura/uploads/cinturones/';
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
    const btnAgregar = document.getElementById('btnAgg-Cinturon');
    if (btnAgregar) {
        btnAgregar.addEventListener('click', () => {
            const inputSKU = document.getElementById('SKUCinturon'); 
            const modalAgregar = document.getElementById('modal-AggCinturon');
            
            const random = Math.floor(100 + Math.random() * 900);
            const fecha = Date.now().toString().slice(-4);
            const skuGenerado = `CIN-${fecha}${random}`;
            
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
        const btnEditar = e.target.closest('.btn-editarCinturon');
        if (btnEditar) {
            const id = btnEditar.getAttribute('data-id');
            limpiarModalEditar();

            fetch(`/LaHerradura/Controller/CRUD_Cinturones/ViewCinturones.php?id=${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        Swal.fire('Error', data.error, 'error');
                        return;
                    }

                    document.getElementById('edit-id-cinturon').value = data.id_cinturon;
                    document.getElementById('edit-SKUCinturon').value = data.SKU || '';
                    document.getElementById('edit-NombreCinturon').value = data.Nombre;
                    document.getElementById('edit-PrecioCinturon').value = data.Precio;

                    document.getElementById('edit-MaterialCinturon').value = data.id_material || "Null";
                    document.getElementById('edit-AdornoCinturon').value = data.id_adorno || "Null";
                    document.getElementById('edit-TamañoCinturon').value = data.Tamaño;

                    // --- NUEVO: LLENAR TALLAS Y STOCK ---
                    // 1. Limpiamos todas las casillas por si abriste otro sombrero antes
                    document.querySelectorAll('.check-talla-edit').forEach(cb => { 
                        cb.checked = false; 
                        toggleStockEdit(cb); // Oculta los inputs de stock
                    });

                    // 2. Llenamos las casillas y el stock que vienen de la Base de Datos
                    if (data.inventario && data.inventario.length > 0) {
                        data.inventario.forEach(item => {
                            // Buscamos el checkbox y el input de cantidad usando los IDs que creamos
                            const cb = document.getElementById(`edit-check-talla-${item.talla}`);
                            const inputStock = document.getElementById(`edit-stock-talla-${item.talla}`);
                            
                            if (cb && inputStock) {
                                cb.checked = true;                  // Marcamos la palomita
                                inputStock.value = item.stock;      // Ponemos la cantidad
                                toggleStockEdit(cb);                // Mostramos el cuadro de texto
                            }
                        });
                    }

                    cargarPreviewDesdeBD(data.Img1, 'previewEditCinturon1');
                    cargarPreviewDesdeBD(data.Img2, 'previewEditCinturon2');
                    cargarPreviewDesdeBD(data.Img3, 'previewEditCinturon3');
                    cargarPreviewDesdeBD(data.Img4, 'previewEditCinturon4');

                    modalEditar.style.display = 'block';
                })
                .catch(err => {
                    console.error('Error fetching data:', err);
                    Swal.fire('Error', 'No se pudo cargar la información del cinturón.', 'error');
                });
        }

        // --- B) BOTÓN ELIMINAR ---
        const btnEliminar = e.target.closest('.btn-eliminarCinturon');
        if (btnEliminar) {
            const id = btnEliminar.dataset.id;
            Alerta.confirmar(`¿Estás seguro de eliminar el cinturón ID ${id}?`, 'Sí, eliminar')
                .then((result) => {
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
        const btnVer = e.target.closest('.btn-verCinturon');
        if (btnVer) {
            const id = btnVer.dataset.id;
            const modalVer = document.getElementById('modal-ViewProducts') || document.getElementById('modal-ViewProduct');

            if(!modalVer) return;

            fetch(`/LaHerradura/Controller/CRUD_Cinturones/ViewCinturones.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('name-sombrero-vp').textContent = data.Nombre;
                    document.getElementById('precio-vp').textContent = `$${data.Precio}.00 mxn`;
                    document.getElementById('modal-color').textContent = `Tallas: ${data.Tallas || "Unitalla"}`; // Reusamos campo
                    document.getElementById('modal-horma').textContent = `Material: ${data.Nombre_Material || data.Material}`;
                    document.getElementById('modal-copa').textContent = `Adorno: ${data.Nombre_Adorno || data.Adorno}`;
                    document.getElementById('modal-tam-copa').textContent = `Ancho: ${data.Tamaño || "N/A"}`;
                    document.getElementById('modal-tam-ala').textContent = ""; 
                    document.getElementById('modal-material').textContent = "";

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
                        galeriaHtml += `<img class="thumbnail-modal" src="/LaHerradura/uploads/cinturones/${imgSrc}" alt="Miniatura">`;
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

            const btnSubmit = document.getElementById('btnGuardarEditCinturones');
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
                    Alerta.exito('Cinturón actualizado correctamente.')
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