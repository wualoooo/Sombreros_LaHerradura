document.addEventListener('DOMContentLoaded', () => {

    // --- 1. SELECCIONAR ELEMENTOS ---
    // (Usamos los IDs y Clases de tu HTML)
    
    // El modal y su formulario
    const modalEditar = document.getElementById('modal-EditTexana');
    const formEditar = document.getElementById('form-EditTexana');
    
    // (Asegúrate de que tu botón de cerrar tenga la clase 'close')
    const btnCerrar = modalEditar.querySelector('.close');

    // (Asegúrate de que tu <tbody> de la tabla tenga este ID)
    const tablaBody = document.getElementById('tabla-texana-body'); 

    if (!tablaBody) {
        console.error("No se encontró el <tbody> con ID 'tabla-texana-body'.");
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
        if (e.target.classList.contains('btn-editarTexana')) {
            const id = e.target.dataset.id; //
            
            // Usamos tu script de "ver texana" para obtener los datos
            fetch(`/LaHerradura/Controller/CRUD_Texanas/ViewTexanas.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    // Rellenamos el formulario con los datos recibidos
                    // (Usamos los 'id' de tus inputs)
                    
                    // ¡EL MÁS IMPORTANTE! Rellenamos el ID oculto
                    document.getElementById('edit-id-Texana').value = data.id_texana; 
                    document.getElementById('NombreTexana').value = data.Nombre;
                    document.getElementById('ColorTexana').value = data.Color;
                    document.getElementById('HormaTexana').value = data.Horma;
                    document.getElementById('CopaTexana').value = data.Copa;
                    document.getElementById('TamañoCopaTexana').value = data.Tam_Copa;
                    document.getElementById('MaterialTexana').value = data.Material;
                    document.getElementById('PrecioTexana').value = data.Precio;
                    
                    // Rellenamos las vistas previas de imágenes
                    const rutaBase = '/LaHerradura/uploads/texanas/';
                    const placeholder = '#'; // O una imagen placeholder

                    // Imagen 1
                    const img1 = document.getElementById('previewEditTexana1');
                    if (data.Img1) {
                        img1.src = rutaBase + data.Img1;
                        img1.style.display = 'block';
                    } else {
                        img1.src = placeholder;
                        img1.style.display = 'none'; // O 'block' si usas placeholder
                    }

                    // Imagen 2
                    const img2 = document.getElementById('previewEditTexana2');
                    if (data.Img2) {
                        img2.src = rutaBase + data.Img2;
                        img2.style.display = 'block';
                    } else {
                        img2.src = placeholder;
                        img2.style.display = 'none';
                    }

                    // Imagen 3
                    const img3 = document.getElementById('previewEditTexana3');
                    if (data.Img3) {
                        img3.src = rutaBase + data.Img3;
                        img3.style.display = 'block';
                    } else {
                        img3.src = placeholder;
                        img3.style.display = 'none';
                    }

                    // Imagen 4
                    const img4 = document.getElementById('previewEditTexana4');
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
        if (e.target.classList.contains('btn-eliminarTexana')) {
            const id = e.target.dataset.id;

            if (confirm(`¿Estás seguro de que quieres eliminar el producto ID ${id}?`)) {
                
                const formData = new FormData();
                formData.append('id', id);

                fetch('/LaHerradura/Controller/CRUD_Texanas/eliminarTexana.php', {
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
                alert('¡Texana actualizado con éxito!');
                location.reload(); // Recargamos la página para ver los cambios
            } else {
                // Si el PHP devolvió un error
                alert('Error al actualizar: ' + data.error);
            }
        })
        .catch(error => console.error('Error al enviar el formulario:', error));
    });

    // Para el modal de AGREGAR Texana
    setupImagePreview('imgTexana1', 'previewTexana1', 'fileNameAgg1');
    setupImagePreview('imgTexana2', 'previewTexana2', 'fileNameAgg2');
    setupImagePreview('imgTexana3', 'previewTexana3', 'fileNameAgg3');
    setupImagePreview('imgTexana4', 'previewTexana4', 'fileNameAgg4');

    // Para el modal de EDITAR Texana
    setupImagePreview('imgEditTexana1', 'previewEditTexana1', 'fileNameEdit1');
    setupImagePreview('imgEditTexana2', 'previewEditTexana2', 'fileNameEdit2');
    setupImagePreview('imgEditTexana3', 'previewEditTexana3', 'fileNameEdit3');
    setupImagePreview('imgEditTexana4', 'previewEditTexana4', 'fileNameEdit4');

});