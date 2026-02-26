// ==========================================
// 1. FUNCIÓN GLOBAL PARA LA PASARELA DE EDICIÓN
// ==========================================
window.cambiarPasoEdit = function(pasoActual, pasoSiguiente) {
    if (pasoSiguiente > pasoActual) {
        const contenedorPasoActual = document.getElementById(`step-edit-${pasoActual}`);
        const campos = contenedorPasoActual.querySelectorAll('input:not([type="checkbox"]):not([type="file"]), select');

        let pasoEsValido = true;

        for (let i = 0; i < campos.length; i++) {
            if (campos[i].tagName.toLowerCase() === 'select' && campos[i].hasAttribute('required') && (campos[i].value === 'Null' || campos[i].value === '')) {
                pasoEsValido = false;
                Swal.fire({
                    icon: 'warning',
                    title: 'Campo requerido',
                    text: 'Por favor, selecciona una opción en todos los menús desplegables.',
                    confirmButtonColor: '#4C8F43'
                });
                break;
            }

            if (!campos[i].checkValidity()) {
                pasoEsValido = false;
                campos[i].reportValidity();
                break;
            }
        }

        if (!pasoEsValido) return;
    }

    document.getElementById(`step-edit-${pasoActual}`).style.display = 'none';
    const stepSiguiente = document.getElementById(`step-edit-${pasoSiguiente}`);
    stepSiguiente.style.display = 'block';

    const dots = document.querySelectorAll('.paso-dot-edit');
    dots.forEach((dot, index) => {
        if (index < pasoSiguiente) dot.classList.add('active');
        else dot.classList.remove('active');
    });
};

document.addEventListener('DOMContentLoaded', () => {

    const modalEditar = document.getElementById('modal-EditSombrero');
    const formEditar = document.getElementById('form-EditSombrero');
    const btnCerrar = modalEditar ? modalEditar.querySelector('.close') : null;

    if (!modalEditar || !formEditar) return;

    // ==========================================
    // 2. FUNCIONES AUXILIARES
    // ==========================================
    const limpiarModalEditar = () => {
        formEditar.reset();

        // Resetear la pasarela al paso 1
        document.querySelectorAll('.pasarela-step-edit').forEach(el => el.style.display = 'none');
        const paso1 = document.getElementById('step-edit-1');
        if (paso1) paso1.style.display = 'block';

        document.querySelectorAll('.paso-dot-edit').forEach((dot, index) => {
            if (index === 0) dot.classList.add('active');
            else dot.classList.remove('active');
        });

        // Limpiar checkboxes de tallas
        document.querySelectorAll('.talla-edit-checkbox').forEach(cb => cb.checked = false);

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
    // 3. EVENTOS DE LA TABLA (EDITAR, ELIMINAR, VER)
    // ==========================================
    document.addEventListener('click', (e) => {

        // --- A) BOTÓN EDITAR ---
        const btnEditar = e.target.closest('.btn-editarSombrero');
        if (btnEditar) {
            const id = btnEditar.getAttribute('data-id');
            limpiarModalEditar();

            fetch(`/LaHerradura/Controller/CRUD_Sombreros/ViewSombreros.php?id=${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        Swal.fire('Error', data.error, 'error');
                        return;
                    }

                    document.getElementById('edit-id-sombrero').value = data.id_sombrero;
                    document.getElementById('edit-SKUSombrero').value = data.SKU || '';
                    document.getElementById('edit-NombreSombrero').value = data.Nombre;
                    document.getElementById('edit-PrecioSombrero').value = data.Precio;

                    document.getElementById('edit-ColorSombrero').value = data.id_color || "Null";
                    document.getElementById('edit-HormaSombrero').value = data.id_horma || "Null";
                    document.getElementById('edit-CopaSombrero').value = data.id_copa || "Null";
                    document.getElementById('edit-MaterialSombrero').value = data.id_material || "Null";

                    document.getElementById('edit-TamañoCopaSombrero').value = data.Tam_Copa;
                    document.getElementById('edit-TamañoAlaSombrero').value = data.Tam_ala;

                    if (data.Tallas && data.Tallas !== "Unitalla") {
                        const tallasGuardadas = data.Tallas.split(',');
                        tallasGuardadas.forEach(talla => {
                            const cb = document.querySelector(`.talla-edit-checkbox[value="${talla.trim()}"]`);
                            if (cb) cb.checked = true;
                        });
                    }

                    cargarPreviewDesdeBD(data.Img1, 'previewEditSombrero1');
                    cargarPreviewDesdeBD(data.Img2, 'previewEditSombrero2');
                    cargarPreviewDesdeBD(data.Img3, 'previewEditSombrero3');
                    cargarPreviewDesdeBD(data.Img4, 'previewEditSombrero4');

                    modalEditar.style.display = 'block';
                })
                .catch(err => {
                    console.error('Error fetching data:', err);
                    Swal.fire('Error', 'No se pudo cargar la información del sombrero.', 'error');
                });
        }

        // --- B) BOTÓN ELIMINAR ---
        const btnEliminar = e.target.closest('.btn-eliminarSombrero');
        if (btnEliminar) {
            const id = btnEliminar.dataset.id;
            Alerta.confirmar(`¿Estás seguro de eliminar el sombrero ID ${id}?`, 'Sí, eliminar')
                .then((result) => {
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

        // --- C) BOTÓN VER DETALLES (EL OJITO) ---
        const btnVer = e.target.closest('.btn-verSombrero');
        if (btnVer) {
            const id = btnVer.dataset.id;
            
            // NOTA: Ajusta este ID si tu modal se llama diferente en el HTML
            const modalVer = document.getElementById('modal-ViewProducts') || document.getElementById('modal-ViewProduct');

            if(!modalVer) {
                console.error("No se encontró el modal de Ver en el HTML.");
                return;
            }

            fetch(`/LaHerradura/Controller/CRUD_Sombreros/ViewSombreros.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('name-sombrero-vp').textContent = data.Nombre;
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
                            <img id="main-image-modal" src="/LaHerradura/uploads/sombreros/${data.Img1}" alt="${data.Nombre}">
                        </div>
                        <div id="vista-miniaturas">
                    `;

                    const imagenes = [];
                    if (data.Img1) imagenes.push(data.Img1);
                    if (data.Img2) imagenes.push(data.Img2);
                    if (data.Img3) imagenes.push(data.Img3);
                    if (data.Img4) imagenes.push(data.Img4);

                    imagenes.forEach(imgSrc => {
                        const rutaCompleta = `/LaHerradura/uploads/sombreros/${imgSrc}`;
                        galeriaHtml += `<img class="thumbnail-modal" src="${rutaCompleta}" alt="Miniatura ${data.Nombre}">`;
                    });

                    galeriaHtml += `</div>`;
                    imgCont.innerHTML = galeriaHtml;

                    const mainImage = document.getElementById('main-image-modal');
                    const thumbnails = document.querySelectorAll('#img-sombrero .thumbnail-modal');
                    thumbnails.forEach(thumbnail => {
                        thumbnail.addEventListener('click', () => {
                            mainImage.src = thumbnail.src;
                        });
                    });

                    modalVer.style.display = 'block';

                    const spanClose = modalVer.querySelector('.close');
                    if(spanClose) {
                        spanClose.onclick = () => {
                            modalVer.style.display = 'none';
                            imgCont.innerHTML = "";
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });

    // ==========================================
    // 4. GUARDAR CAMBIOS DE EDICIÓN
    // ==========================================
    formEditar.addEventListener('submit', function(e) {
        e.preventDefault();

        const btnSubmit = document.getElementById('btnGuardarEditSombreros');
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
            btnSubmit.textContent = textoOriginal;
            btnSubmit.disabled = false;
        });
    });

    // ==========================================
    // 5. ACTIVAR PREVIEWS
    // ==========================================
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

    // ==========================================
    // 6. GENERAR SKU AUTOMÁTICO
    // ==========================================
    const btnAgregar = document.getElementById('btnAgg-Sombrero');
    if (btnAgregar) {
        btnAgregar.addEventListener('click', () => {
            const inputSKU = document.getElementById('SKUSombrero');
            const modalAgregar = document.getElementById('modal-AggSombrero');
            
            // Generar código: SOM + últimos 6 dígitos de la fecha actual (para que sea único)
            // Ejemplo resultado: SOM-839210
            const random = Math.floor(100 + Math.random() * 900); // 3 números aleatorios
            const fecha = Date.now().toString().slice(-4); // Últimos 4 números del tiempo
            const skuGenerado = `SOM-${fecha}${random}`;
            
            if (inputSKU) {
                inputSKU.value = skuGenerado;
                // Opcional: Si quieres que no se pueda borrar, descomenta la siguiente línea:
                // inputSKU.readOnly = true; 
            }
            
            // Abrir el modal (por si acaso modal.js no lo ha abierto aún)
            if (modalAgregar) modalAgregar.style.display = 'block';
        });
    }
});