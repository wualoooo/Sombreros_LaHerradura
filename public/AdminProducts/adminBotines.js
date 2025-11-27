document.addEventListener('DOMContentLoaded', () => {

    // --- 1. SELECCIONAR ELEMENTOS ---
    // (Usamos los IDs y Clases de tu HTML)
    
    // El modal y su formulario
    const modalEditar = document.getElementById('modal-EditBotin');
    const formEditar = document.getElementById('form-EditBotin');
    
    // (Asegúrate de que tu botón de cerrar tenga la clase 'close')
    const btnCerrar = modalEditar.querySelector('.close');

    // (Asegúrate de que tu <tbody> de la tabla tenga este ID)
    const tablaBody = document.getElementById('tabla-botines-body'); 

    if (!tablaBody) {
        console.error("No se encontró el <tbody> con ID 'tabla-botines-body'.");
        return;
    }

    // --- 2. CERRAR EL MODAL ---
    btnCerrar.onclick = () => {
        modalEditar.style.display = 'none';
    }
    // Opcional: Cerrar si se hace clic fuera
    window.onclick = (event) => {
        if (event.target == modalEditar) {
            modalEditar.style.display = 'none';
        }
    }

    // --- 3. MANEJO DE CLICS EN LA TABLA (Delegación de eventos) ---
    // Escuchamos clics en TODO el <tbody>, es más eficiente
    tablaBody.addEventListener('click', (e) => {
        
        // --- LÓGICA DE "EDITAR" ---
        if (e.target.classList.contains('btn-editarBotin')) {
            const id = e.target.dataset.id; //
            
            // Usamos tu script de "ver texana" para obtener los datos
            fetch(`/LaHerradura/Controller/CRUD_Botines/ViewBotines.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    // Rellenamos el formulario con los datos recibidos
                    // (Usamos los 'id' de tus inputs)
                    
                    // ¡EL MÁS IMPORTANTE! Rellenamos el ID oculto
                    document.getElementById('edit-id-botin').value = data.id_botin; 
                    document.getElementById('NombreBotin').value = data.Nombre;
                    document.getElementById('TallaBotin').value = data.Talla;
                    document.getElementById('MaterialBotin').value = data.Material;
                    document.getElementById('SuelaBotin').value = data.Suela;
                    document.getElementById('PrecioBotin').value = data.Precio;
                    
                    
                    // Rellenamos las vistas previas de imágenes
                    const rutaBase = '/LaHerradura/uploads/botines/';
                    const placeholder = '#'; // O una imagen placeholder

                    // Imagen 1
                    const img1 = document.getElementById('previewEditBotin1');
                    if (data.Img1) {
                        img1.src = rutaBase + data.Img1;
                        img1.style.display = 'block';
                    } else {
                        img1.src = placeholder;
                        img1.style.display = 'none'; // O 'block' si usas placeholder
                    }

                    // Imagen 2
                    const img2 = document.getElementById('previewEditBotin2');
                    if (data.Img2) {
                        img2.src = rutaBase + data.Img2;
                        img2.style.display = 'block';
                    } else {
                        img2.src = placeholder;
                        img2.style.display = 'none';
                    }

                    // Imagen 3
                    const img3 = document.getElementById('previewEditBotin3');
                    if (data.Img3) {
                        img3.src = rutaBase + data.Img3;
                        img3.style.display = 'block';
                    } else {
                        img3.src = placeholder;
                        img3.style.display = 'none';
                    }

                    // Imagen 4
                    const img4 = document.getElementById('previewEditBotin4');
                    if (data.Img4) {
                        img4.src = rutaBase + data.Img4;
                        img4.style.display = 'block';
                    } else {
                        img4.src = placeholder;
                        img4.style.display = 'none';
                    }
                    
                    // --- FIN DE LA SECCIÓN ---

                    // Mostramos el modal
                    modalEditar.style.display = 'block';
                })
                .catch(error => console.error('Error al cargar datos:', error));
        }

        // --- LÓGICA DE "ELIMINAR" ---
        if (e.target.classList.contains('btn-eliminarBotin')) {
            const id = e.target.dataset.id;

            if (confirm(`¿Estás seguro de que quieres eliminar el producto ID ${id}?`)) {
                
                const formData = new FormData();
                formData.append('id', id);

                fetch('../../../Controller/CRUD_Botines/eliminarBotin.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Eliminamos la fila de la tabla sin recargar la página
                        e.target.closest('tr').remove();
                        alert('Producto eliminado');
                    } else {
                        alert('Error al eliminar: ' + data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    });

    // --- 4. MANEJAR EL ENVÍO DEL FORMULARIO DE EDICIÓN ---
    formEditar.addEventListener('submit', (e) => {
        e.preventDefault(); // Evitamos que la página se recargue

        // Obtenemos todos los datos del formulario (incluyendo el ID oculto)
        const formData = new FormData(formEditar);

        // Enviamos los datos al script PHP
        fetch(formEditar.action, { // La 'action' de tu <form>
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Si todo salió bien
                modalEditar.style.display = 'none';
                alert('¡Botin actualizado con éxito!');
                location.reload(); // Recargamos la página para ver los cambios
            } else {
                // Si el PHP devolvió un error
                alert('Error al actualizar: ' + data.error);
            }
        })
        .catch(error => console.error('Error al enviar el formulario:', error));
    });

    // Para el modal de AGREGAR Botin
    setupImagePreview('imgBotin1', 'previewBotin1', 'fileNameAgg1');
    setupImagePreview('imgBotin2', 'previewBotin2', 'fileNameAgg2');
    setupImagePreview('imgBotin3', 'previewBotin3', 'fileNameAgg3');
    setupImagePreview('imgBotin4', 'previewBotin4', 'fileNameAgg4');

    // Para el modal de EDITAR Botin
    setupImagePreview('imgEditBotin1', 'previewEditBotin1', 'fileNameEdit1');
    setupImagePreview('imgEditBotin2', 'previewEditBotin2', 'fileNameEdit2');
    setupImagePreview('imgEditBotin3', 'previewEditBotin3', 'fileNameEdit3');
    setupImagePreview('imgEditBotin4', 'previewEditBotin4', 'fileNameEdit4');

});