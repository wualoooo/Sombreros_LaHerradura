document.addEventListener('DOMContentLoaded', () => {

    // (Eliminé el código de selección de tallas que tenías al principio 
    // porque ahora lo haremos dinámicamente cada vez que se abre el modal)

    const modal = document.getElementById('modal-ViewProducts');

    // Usamos delegación de eventos para más eficiencia
    document.body.addEventListener('click', function(evento) {
        
        const tarjetaClicada = evento.target.closest('.abrir-modal-vp');
        
        if (tarjetaClicada) {
            
            const id = tarjetaClicada.dataset.id;
            console.log("Haciendo fetch para el ID:", id);
            
            fetch(`/LaHerradura/Controller/CRUD_Sombreros/ViewSombreros.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    console.log("Datos recibidos:", data);

                    // 1. Llenar Textos Básicos
                    document.getElementById('name-sombrero-vp').textContent = data.Nombre;
                    document.getElementById('precio-vp').textContent = `$${data.Precio}.00 mxn`;
                    document.getElementById('modal-color').textContent = `Color: ${data.Nombre_Color || data.Color}`;
                    document.getElementById('modal-horma').textContent = `Horma: ${data.Nombre_Horma || data.Horma}`;
                    document.getElementById('modal-copa').textContent = `Copa: ${data.Nombre_Copa || data.Copa}`;
                    document.getElementById('modal-tam-copa').textContent = `Tamaño copa: ${data.Tam_Copa} cm`;
                    document.getElementById('modal-tam-ala').textContent = `Tamaño ala: ${data.Tam_ala} cm`;
                    document.getElementById('modal-material').textContent = `Material: ${data.Nombre_Material || data.Material}`;


                    // --- LÓGICA DE TALLAS DINÁMICAS (NUEVO) ---
                    const contenedorTallas = document.getElementById('container-tallas');
                    
                    if (contenedorTallas) {
                        // A) Limpiar tallas anteriores (del producto que viste antes)
                        contenedorTallas.innerHTML = ''; 

                        // B) Obtener el string de tallas (ej: "54,55,56" o "Unitalla")
                        let stringTallas = data.Tallas || "Unitalla";
                        
                        // C) Convertirlo en un array separando por comas
                        let arrayTallas = stringTallas.split(',');

                        // D) Crear un botón por cada talla
                        arrayTallas.forEach(talla => {
                            let span = document.createElement('span');
                            span.classList.add('talla'); // Clase para estilos CSS
                            span.textContent = talla.trim(); // .trim() quita espacios extra

                            // E) Agregar el evento de click AQUÍ MISMO a los nuevos botones
                            span.addEventListener('click', function() {
                                // 1. Quitar 'selected' a todos los hermanos
                                contenedorTallas.querySelectorAll('.talla').forEach(t => t.classList.remove('selected'));
                                // 2. Poner 'selected' al actual
                                this.classList.add('selected');
                            });

                            // F) Insertar en el HTML
                            contenedorTallas.appendChild(span);
                        });
                    }
                    // ------------------------------------------


                    // --- LÓGICA DE GALERÍA DE IMÁGENES ---
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

                    // Activar miniaturas
                    activarListenersGaleriaModal(); 


                    // --- LÓGICA DE CARRITO ---
                    // Reemplazar el botón para limpiar eventos anteriores
                    const btnAgregar = document.getElementById('btn-AggCart');
                    const inputCantidad = document.getElementById('cant-products');
                    const nuevoBtn = btnAgregar.cloneNode(true);
                    btnAgregar.parentNode.replaceChild(nuevoBtn, btnAgregar);

                    nuevoBtn.addEventListener('click', () => {
                        
                        // Validar talla seleccionada (buscamos dentro del contenedor dinámico)
                        const tallaSeleccionada = contenedorTallas.querySelector('.talla.selected');
                        
                        if (!tallaSeleccionada) {
                            if (typeof Alerta !== 'undefined') {
                                Alerta.error("Por favor, selecciona una talla.");
                            } else {
                                alert("Selecciona una talla");
                            }
                            return; 
                        }

                        const valorTalla = tallaSeleccionada.textContent.trim();
                        const cantidad = parseInt(inputCantidad.value) || 1;

                        const producto = {
                            sku: data.SKU,
                            id: data.id_sombrero,
                            nombre: data.Nombre,
                            precio: data.Precio,
                            imagen: data.Img1,
                            tipo: 'sombreros', 
                            cantidad: cantidad,
                            talla: valorTalla 
                        };

                        if (typeof Carrito !== 'undefined') {
                            Carrito.agregar(producto);
                            modal.style.display = 'none';
                            if (typeof Alerta !== 'undefined') Alerta.toast("Producto agregado al carrito", "success");
                        }
                    });

                    // Mostrar modal
                    modal.style.display = 'block';
                })
                .catch(error => console.error('Error al cargar datos:', error));
        }
    });

    // Cerrar modal
    const spanClose = document.querySelector('.modal-content-vp .close');
    if (spanClose) {
        spanClose.onclick = function() {
            modal.style.display = "none";
            document.getElementById('img-sombrero').innerHTML = ""; 
        }
    }

    // Listener para cambiar imagen principal
    function activarListenersGaleriaModal() {
        const mainImage = document.getElementById('main-image-modal'); 
        const thumbnails = document.querySelectorAll('#img-sombrero .thumbnail-modal');

        if (mainImage) {
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', () => {
                    mainImage.src = thumbnail.src;
                });
            });
        }
    }
});