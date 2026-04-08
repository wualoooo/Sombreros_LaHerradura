// Espera a que todo el HTML esté cargado
document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('modal-ViewCinturones');

    // Usamos delegación de eventos para más eficiencia
    document.body.addEventListener('click', function(evento) {
        
        const tarjetaClicada = evento.target.closest('.abrir-modal-vp');
        
        if (tarjetaClicada) {
            
            const id = tarjetaClicada.dataset.id;
            
            console.log("Haciendo fetch para el ID:", id);
            fetch(`/LaHerradura/Controller/CRUD_Cinturones/ViewCinturones.php?id=${id}`)
                .then(response => response.json()) 
                .then(data => {
                    console.log("Datos recibidos del PHP:", data);

                    document.getElementById('name-sombrero-vp').textContent = data.Nombre;
                    document.getElementById('precio-vp').textContent = `$${data.Precio}.00 mxn`;

                    // Rellenamos los detalles
                    document.getElementById('modal-material').textContent = `Material: ${data.Nombre_Material || data.id_Material}`;
                    document.getElementById('modal-adorno').textContent = `Adorno: ${data.Nombre_Adorno || data.id_Adorno}`;
                    document.getElementById('modal-tamaño').textContent = `Tamaño: ${data.Tamaño} cm`;
                    
                    // --- LÓGICA DE TALLAS Y STOCK ---
                    const contenedorTallas = document.getElementById('container-tallas');
                    const inputCantidad = document.getElementById('cant-products');
                    
                    if (contenedorTallas) {
                        contenedorTallas.innerHTML = ''; 
                        
                        if (data.inventario && data.inventario.length > 0) {
                            let hayStock = false;

                            data.inventario.forEach(item => {
                                if (item.stock > 0) {
                                    hayStock = true;
                                    let span = document.createElement('span');
                                    span.classList.add('talla');
                                    span.textContent = item.talla;
                                    span.dataset.stock = item.stock; 

                                    span.addEventListener('click', function() {
                                        contenedorTallas.querySelectorAll('.talla').forEach(t => t.classList.remove('selected'));
                                        this.classList.add('selected');
                                        
                                        inputCantidad.max = item.stock;
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
                            contenedorTallas.innerHTML = '<span style="color: #888;">Tallas no configuradas</span>';
                        }
                    }

                    // --- GALERÍA DE IMÁGENES ---
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
                        const rutaCompleta = `/LaHerradura/uploads/cinturones/${imgSrc}`;
                        galeriaHtml += `<img class="thumbnail-modal" src="${rutaCompleta}" alt="Miniatura ${data.Nombre}">`;
                    });

                    galeriaHtml += `</div>`; 
                    imgCont.innerHTML = galeriaHtml;
                    activarListenersGaleriaModal();

                    // --- LÓGICA DE CARRITO CON STOCK ---
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

                        const valorTalla = tallaSeleccionada.textContent.trim();
                        const cantidadSolicitada = parseInt(inputCantidad.value) || 1;
                        const stockDisponible = parseInt(tallaSeleccionada.dataset.stock);

                        // VALIDACIÓN ESTRELLA
                        if (cantidadSolicitada > stockDisponible) {
                            if (typeof Alerta !== 'undefined') {
                                Alerta.error(`Lo sentimos, solo tenemos ${stockDisponible} piezas disponibles en talla ${valorTalla}.`);
                            } else {
                                alert(`Solo hay ${stockDisponible} piezas disponibles.`);
                            }
                            return; 
                        }

                        const producto = {
                            sku: data.SKU,
                            id: data.id_cinturon,
                            nombre: data.Nombre,
                            precio: data.Precio,
                            imagen: data.Img1,
                            tipo: 'cinturones', 
                            cantidad: cantidadSolicitada,
                            talla: valorTalla 
                        };

                        if (typeof Carrito !== 'undefined') {
                            Carrito.agregar(producto);
                            modal.style.display = 'none';
                            if (typeof Alerta !== 'undefined') Alerta.toast("Producto agregado al carrito", "success");
                        }
                    });

                    modal.style.display = 'block';
                })
                .catch(error => console.error('Error al cargar datos:', error));
        }
    });

    // Cerrar el modal
    const spanClose = document.querySelector('.modal-content-vp .close');
    if (spanClose) {
        spanClose.onclick = function() {
            modal.style.display = "none";
            const imgCont = document.getElementById('img-sombrero');
            if (imgCont) imgCont.innerHTML = ""; 
        }
    }

    function activarListenersGaleriaModal() {
        const mainImage = document.getElementById('main-image-modal'); 
        const thumbnails = document.querySelectorAll('#img-sombrero .thumbnail-modal');

        if (!mainImage) return;

        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', () => {
                mainImage.src = thumbnail.src;
                mainImage.alt = thumbnail.alt; 
            });
        });
    }

       // ==========================================
// LÓGICA DE FILTRADO AJAX
// ==========================================

function aplicarFiltros() {
    const nombre = document.getElementById('filtro-nombre').value;
    const precioMin = document.getElementById('filtro-precio-min').value;
    const precioMax = document.getElementById('filtro-precio-max').value;
    const adornosSeleccionados = Array.from(document.querySelectorAll('.check-adorno:checked')).map(cb => cb.value);
    const materialesSeleccionados = Array.from(document.querySelectorAll('.check-material:checked')).map(cb => cb.value);

    const datosFiltro = {
        nombre: nombre,
        precioMin: precioMin,
        precioMax: precioMax,
        adornos: adornosSeleccionados,
        materiales: materialesSeleccionados
    };

    fetch('/LaHerradura/Controller/CRUD_Cinturones/FiltrarCinturones.php', {
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
                <div class='card abrir-modal-vp' data-id='${producto.id_cinturon}'>
                    <div class='img-producto'>
                        <img src='/LaHerradura/uploads/cinturones/${producto.Img1}' alt='${producto.Nombre}'>
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
document.querySelectorAll('.check-adorno, .check-material, #filtro-precio-min, #filtro-precio-max').forEach(el => {
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