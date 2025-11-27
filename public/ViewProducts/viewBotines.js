// Espera a que todo el HTML esté cargado
document.addEventListener('DOMContentLoaded', () => {

    // Selecciona el modal y sus partes
    const modal = document.getElementById('modal-ViewBotines');
    // ... (todos tus otros selectores 'modalNombre', 'modalPrecio', etc. están bien)

    // Usamos delegación de eventos para más eficiencia
    document.body.addEventListener('click', function(evento) {
        
        // Vemos si el clic fue en una tarjeta (o en algo dentro de ella)
        const tarjetaClicada = evento.target.closest('.abrir-modal-vp');
        
        if (tarjetaClicada) {
            
            // 1. Obtenemos el ID del 'data-id'
            const id = tarjetaClicada.dataset.id;
            
            console.log("Haciendo fetch para el ID:", id);
            // 2. Llamamos a nuestro PHP usando fetch
            fetch(`/LaHerradura/Controller/CRUD_Botines/ViewBotines.php?id=${id}`)
                .then(response => response.json()) // Convierte la respuesta a JSON
                .then(data => {
                    // 3. Rellenamos el modal con los datos recibidos
                    console.log("Datos recibidos del PHP:", data);

                    document.getElementById('name-sombrero-vp').textContent = data.Nombre;
                    document.getElementById('precio-vp').textContent = `$${data.Precio}.00 mxn`;

                    // Rellenamos los detalles (usando los nuevos IDs)
                    document.getElementById('modal-Talla').textContent = `Material: ${data.Talla}`;
                    document.getElementById('modal-Material').textContent = `Adorno: ${data.Material}`;
                    document.getElementById('modal-Suela').textContent = `Tamaño: ${data.Suela}`;
                    // --- INICIO DE LA MODIFICACIÓN DE GALERÍA ---
                    
                    // En lugar de una sola imagen, generamos la galería completa
                    const imgCont = document.getElementById('img-sombrero');

                    // 1. Preparamos el HTML para la vista principal y las miniaturas
                    
                    // Asignamos un ID único a la imagen principal del modal
                    let galeriaHtml = `
                        <div id="vista-foto">
                            <img id="main-image-modal" src="/LaHerradura/uploads/botines/${data.Img1}" alt="${data.Nombre}">
                        </div>
                        <div id="vista-miniaturas">
                    `;

                    // 2. Creamos un array solo con las imágenes que existen
                    const imagenes = [];
                    if (data.Img1) imagenes.push(data.Img1);
                    if (data.Img2) imagenes.push(data.Img2);
                    if (data.Img3) imagenes.push(data.Img3);
                    if (data.Img4) imagenes.push(data.Img4);
                    // (Puedes añadir más si tu BD tiene Img5, Img6, etc.)

                    // 3. Generamos el HTML de cada miniatura
                    imagenes.forEach(imgSrc => {
                        const rutaCompleta = `/LaHerradura/uploads/botines/${imgSrc}`;
                        // Usamos una clase única para las miniaturas del modal
                        galeriaHtml += `<img class="thumbnail-modal" src="${rutaCompleta}" alt="Miniatura ${data.Nombre}">`;
                    });

                    // 4. Cerramos los divs
                    galeriaHtml += `</div>`; // Cierra #vista-miniaturas

                    // 5. Inyectamos todo el HTML de la galería en el contenedor
                    imgCont.innerHTML = galeriaHtml;
                    
                    // 6. ¡IMPORTANTE! Activamos los listeners para las miniaturas que ACABAMOS de crear
                    activarListenersGaleriaModal();

                    // --- FIN DE LA MODIFICACIÓN DE GALERÍA ---

                    // 4. Mostramos el modal
                    modal.style.display = 'block';
                })
                .catch(error => console.error('Error al cargar datos:', error));
        }
    });

    // Tu código para cerrar el modal
    const spanClose = document.querySelector('.modal-content-vp .close');
    spanClose.onclick = function() {
        modal.style.display = "none";
        
        // --- BUENA PRÁCTICA (Opcional) ---
        // Limpiamos la galería al cerrar para que no se vea la anterior
        // si la siguiente carga falla.
        const imgCont = document.getElementById('img-sombrero');
        imgCont.innerHTML = ""; // Limpiamos el contenido
    }

    
    // --- NUEVA FUNCIÓN ---
    // Esta función añade la lógica de clic a las miniaturas del modal
    function activarListenersGaleriaModal() {
        // Seleccionamos la imagen principal DENTRO DEL MODAL
        const mainImage = document.getElementById('main-image-modal'); 
        
        // Seleccionamos las miniaturas DENTRO DEL MODAL
        const thumbnails = document.querySelectorAll('#img-sombrero .thumbnail-modal');

        if (!mainImage) {
            console.error("No se encontró la imagen principal del modal ('main-image-modal')");
            return;
        }

        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', () => {
                // Al hacer clic, cambiamos el 'src' de la imagen principal
                mainImage.src = thumbnail.src;
                mainImage.alt = thumbnail.alt; // También actualizamos el alt
            });
        });
    }
});