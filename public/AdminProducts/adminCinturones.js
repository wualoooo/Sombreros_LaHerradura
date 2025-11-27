document.addEventListener('DOMContentLoaded', () => {

    // --- 1. SELECCIONAR ELEMENTOS ---
    // (Usamos los IDs y Clases de tu HTML)
    
    // El modal y su formulario
    const modalEditar = document.getElementById('modal-EditCinturon');
    const formEditar = document.getElementById('form-EditCinturon');
    
    // (Asegúrate de que tu botón de cerrar tenga la clase 'close')
    const btnCerrar = modalEditar.querySelector('.close');

    // (Asegúrate de que tu <tbody> de la tabla tenga este ID)
    const tablaBody = document.getElementById('tabla-cinturones-body'); 

    if (!tablaBody) {
        console.error("No se encontró el <tbody> con ID 'tabla-cinturones-body'.");
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
        if (e.target.classList.contains('btn-editarCinturon')) {
            const id = e.target.dataset.id; //
            
            // Usamos tu script de "ver texana" para obtener los datos
            fetch(`../../../Controller/CRUD_Cinturones/ViewCinturones.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    // Rellenamos el formulario con los datos recibidos
                    // (Usamos los 'id' de tus inputs)
                    
                    // ¡EL MÁS IMPORTANTE! Rellenamos el ID oculto
                    document.getElementById('edit-id-cinturon').value = data.id_cinturon; 
                    document.getElementById('NombreCinturon').value = data.Nombre;
                    document.getElementById('PrecioCinturon').value = data.Precio;
                    document.getElementById('MaterialCinturon').value = data.Material;
                    document.getElementById('AdornoCinturon').value = data.Adorno;
                    document.getElementById('TamañoCinturon').value = data.Tamaño;
                    
                    
                    // Rellenamos las vistas previas de imágenes
                    const rutaBase = '../../../uploads/cinturones/';
                    const placeholder = '#'; // O una imagen placeholder

                    // Imagen 1
                    const img1 = document.getElementById('previewEditCinturon1');
                    if (data.Img1) {
                        img1.src = rutaBase + data.Img1;
                        img1.style.display = 'block';
                    } else {
                        img1.src = placeholder;
                        img1.style.display = 'none'; // O 'block' si usas placeholder
                    }

                    // Imagen 2
                    const img2 = document.getElementById('previewEditCinturon2');
                    if (data.Img2) {
                        img2.src = rutaBase + data.Img2;
                        img2.style.display = 'block';
                    } else {
                        img2.src = placeholder;
                        img2.style.display = 'none';
                    }

                    // Imagen 3
                    const img3 = document.getElementById('previewEditCinturon3');
                    if (data.Img3) {
                        img3.src = rutaBase + data.Img3;
                        img3.style.display = 'block';
                    } else {
                        img3.src = placeholder;
                        img3.style.display = 'none';
                    }

                    // Imagen 4
                    const img4 = document.getElementById('previewEditCinturon4');
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
        if (e.target.classList.contains('btn-eliminarCinturon')) {
            const id = e.target.dataset.id;

            if (confirm(`¿Estás seguro de que quieres eliminar el producto ID ${id}?`)) {
                
                const formData = new FormData();
                formData.append('id', id);

                fetch('../../../Controller/CRUD_Cinturones/eliminarCinturon.php', {
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
                alert('¡Cinturon actualizado con éxito!');
                location.reload(); // Recargamos la página para ver los cambios
            } else {
                // Si el PHP devolvió un error
                alert('Error al actualizar: ' + data.error);
            }
        })
        .catch(error => console.error('Error al enviar el formulario:', error));
    });

    // Para el modal de AGREGAR Cinturon
    setupImagePreview('imgCinturon1', 'previewCinturon1', 'fileNameAgg1');
    setupImagePreview('imgCinturon2', 'previewCinturon2', 'fileNameAgg2');
    setupImagePreview('imgCinturon3', 'previewCinturon3', 'fileNameAgg3');
    setupImagePreview('imgCinturon4', 'previewCinturon4', 'fileNameAgg4');

    // Para el modal de EDITAR Cinturon
    setupImagePreview('imgEditCinturon1', 'previewEditCinturon1', 'fileNameEdit1');
    setupImagePreview('imgEditCinturon2', 'previewEditCinturon2', 'fileNameEdit2');
    setupImagePreview('imgEditCinturon3', 'previewEditCinturon3', 'fileNameEdit3');
    setupImagePreview('imgEditCinturon4', 'previewEditCinturon4', 'fileNameEdit4');

});