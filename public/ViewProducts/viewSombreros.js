document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('modal-ViewProducts');

    document.body.addEventListener('click', function(evento) {     
        const tarjetaClicada = evento.target.closest('.abrir-modal-vp');
        if (tarjetaClicada) {
            const id = tarjetaClicada.dataset.id;
            console.log("Haciendo fetch para el ID:", id);
            
            fetch(`/LaHerradura/Controller/CRUD_Sombreros/ViewSombreros.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    console.log("Datos recibidos:", data);

                    // Llenar el modal con los datos básicos
                    document.getElementById('name-sombrero-vp').textContent = data.Nombre;
                    document.getElementById('precio-vp').textContent = `$${data.Precio}.00 mxn`;
                    document.getElementById('modal-color').textContent = `Color: ${data.Nombre_Color || data.Color}`;
                    document.getElementById('modal-horma').textContent = `Horma: ${data.Nombre_Horma || data.Horma}`;
                    document.getElementById('modal-copa').textContent = `Copa: ${data.Nombre_Copa || data.Copa}`;
                    document.getElementById('modal-tam-copa').textContent = `Tamaño copa: ${data.Tam_Copa} cm`;
                    document.getElementById('modal-tam-ala').textContent = `Tamaño ala: ${data.Tam_ala} cm`;
                    document.getElementById('modal-material').textContent = `Material: ${data.Nombre_Material || data.Material}`;


                    // --- LÓGICA DE TALLAS DINÁMICAS (MODIFICADA) ---
                    const contenedorTallas = document.getElementById('container-tallas');
                    const inputCantidad = document.getElementById('cant-products'); // Input de cantidad

                    if (contenedorTallas) {
                        contenedorTallas.innerHTML = ''; 
                        
                        // Revisamos si viene el inventario desde PHP
                        if (data.inventario && data.inventario.length > 0) {
                            
                            let hayStock = false; // Bandera para saber si el producto está totalmente agotado

                            data.inventario.forEach(item => {
                                // Solo mostramos las tallas que tengan al menos 1 en stock
                                if (item.stock > 0) {
                                    hayStock = true;
                                    let span = document.createElement('span');
                                    span.classList.add('talla');
                                    span.textContent = item.talla;
                                    
                                    // GUARDAMOS EL STOCK EN LA ETIQUETA HTML (TRUCO CLAVE)
                                    span.dataset.stock = item.stock; 

                                    span.addEventListener('click', function() {
                                        contenedorTallas.querySelectorAll('.talla').forEach(t => t.classList.remove('selected'));
                                        this.classList.add('selected');
                                        
                                        // Cuando seleccionan talla, actualizamos el máximo del input
                                        inputCantidad.max = item.stock;
                                        
                                        // Si el usuario ya había escrito "10" pero de esta talla solo hay "2", lo bajamos a 2
                                        if (parseInt(inputCantidad.value) > item.stock) {
                                            inputCantidad.value = item.stock;
                                        }
                                    });
                                    contenedorTallas.appendChild(span);
                                }
                            });

                            if (!hayStock) {
                                contenedorTallas.innerHTML = '<span style="color: #dc3545; font-weight: bold;">Agotado</span>';
                            }

                        } else {
                            // Por si acaso es un producto viejo que aún no tiene inventario
                            contenedorTallas.innerHTML = '<span style="color: #888;">Tallas no configuradas</span>';
                        }
                    }
                    // -----------------------------------------------


                    // GALERÍA DE IMÁGENES
                    const imgCont = document.getElementById('img-sombrero');
                    let galeriaHtml = `
                        <div id="vista-foto">
                            <img id="main-image-modal" src="/LaHerradura/uploads/sombreros/${data.Img1}" alt="${data.Nombre}">
                        </div>
                        <div id="vista-miniaturas">`;
                        
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
                    activarListenersGaleriaModal(); 


                    // --- LÓGICA DE CARRITO (MODIFICADA) ---
                    const btnAgregar = document.getElementById('btn-AggCart');
                    const nuevoBtn = btnAgregar.cloneNode(true);
                    btnAgregar.parentNode.replaceChild(nuevoBtn, btnAgregar);

                    nuevoBtn.addEventListener('click', () => {
                        
                        const tallaSeleccionada = contenedorTallas.querySelector('.talla.selected');
                        
                        if (!tallaSeleccionada) {
                            if (typeof Alerta !== 'undefined') {
                                Alerta.error("Por favor, selecciona una talla disponible.");
                            } else {
                                alert("Selecciona una talla");
                            }
                            return; 
                        }

                        // Recuperamos la información de la talla seleccionada
                        const valorTalla = tallaSeleccionada.textContent.trim();
                        const cantidadSolicitada = parseInt(inputCantidad.value) || 1;
                        const stockDisponible = parseInt(tallaSeleccionada.dataset.stock);

                        // VALIDACIÓN ESTRELLA: ¿Nos está pidiendo más de lo que tenemos?
                        if (cantidadSolicitada > stockDisponible) {
                            if (typeof Alerta !== 'undefined') {
                                Alerta.error(`Lo sentimos, solo tenemos ${stockDisponible} piezas disponibles en talla ${valorTalla}.`);
                            } else {
                                alert(`Solo hay ${stockDisponible} piezas disponibles.`);
                            }
                            return; // Cortamos la ejecución, no se agrega al carrito
                        }

                        // Si pasó la validación, armamos el producto
                        const producto = {
                            sku: data.SKU,
                            id: data.id_sombrero,
                            nombre: data.Nombre,
                            precio: data.Precio,
                            imagen: data.Img1,
                            tipo: 'sombreros', 
                            cantidad: cantidadSolicitada,
                            talla: valorTalla 
                        };

                        if (typeof Carrito !== 'undefined') {
                            Carrito.agregar(producto);
                            modal.style.display = 'none';
                            if (typeof Alerta !== 'undefined') Alerta.toast("Producto agregado al carrito", "success");
                        }
                    });
                    // --------------------------------------

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

    // ==========================================
// LÓGICA DE FILTRADO AJAX
// ==========================================

function aplicarFiltros() {
    const nombre = document.getElementById('filtro-nombre').value;
    const precioMin = document.getElementById('filtro-precio-min').value;
    const precioMax = document.getElementById('filtro-precio-max').value;
    const copasSeleccionadas = Array.from(document.querySelectorAll('.check-copa:checked')).map(cb => cb.value);
    const tallasSeleccionadas = Array.from(document.querySelectorAll('.check-talla:checked')).map(cb => cb.value);

    const datosFiltro = {
        nombre: nombre,
        precioMin: precioMin,
        precioMax: precioMax,
        copas: copasSeleccionadas,
        tallas: tallasSeleccionadas
    };

    fetch('/LaHerradura/Controller/CRUD_Sombreros/FiltrarSombreros.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(datosFiltro)
    })
    .then(res => res.json())
    .then(data => {
        const contenedorProductos = document.querySelector('.container2');
        contenedorProductos.innerHTML = ''; // Limpiamos los productos actuales

        if (data.length === 0) {
            contenedorProductos.innerHTML = '<h3 style="grid-column: 1 / -1; text-align: center; color: #666;">No se encontraron productos con estos filtros.</h3>';
            return;
        }

        // Dibujamos las tarjetas exactamente como las hace tu PHP original
        data.forEach(producto => {
            const cardHTML = `
                <div class='card abrir-modal-vp' data-id='${producto.id_sombrero}'>
                    <div class='img-producto'>
                        <img src='/LaHerradura/uploads/sombreros/${producto.Img1}' alt='${producto.Nombre}'>
                    </div>
                    <div class='vista-rapida'>
                        <span>Ver más detalles</span>
                    </div>
                    <div class='text-producto'>
                        <h4>${producto.Nombre}</h4>
                        <h5>$${producto.Precio}.00 mxn</h5>
                    </div>
                </div>
            `;
            contenedorProductos.insertAdjacentHTML('beforeend', cardHTML);
        });
    })
    .catch(err => console.error("Error en filtros:", err));
}

// Listeners para Checkboxes y Precios (Se ejecutan al instante)
document.querySelectorAll('.check-copa, .check-talla, #filtro-precio-min, #filtro-precio-max').forEach(el => {
    el.addEventListener('change', aplicarFiltros);
});

// Listener para el Buscador de Texto con "Debounce" (Retraso inteligente)
let timeoutBuscador;
document.getElementById('filtro-nombre').addEventListener('input', () => {
    clearTimeout(timeoutBuscador); // Si sigue escribiendo, reinicia el reloj
    timeoutBuscador = setTimeout(() => {
        aplicarFiltros(); // Solo busca cuando deja de teclear por 300ms
    }, 300); 
});
});