const Carrito = {
    clave: 'laherradura_carrito',

    obtenerItems: function() {
        const almacenado = localStorage.getItem(this.clave);
        return almacenado ? JSON.parse(almacenado) : [];
    },

    guardarItems: function(items) {
        localStorage.setItem(this.clave, JSON.stringify(items));
        this.actualizarContador();
        this.renderSideCart(); // ¡Actualizamos el visual al guardar!
    },

    agregar: function(producto) {
        let items = this.obtenerItems();
        
        const indice = items.findIndex(p => 
            p.id === producto.id && 
            p.tipo === producto.tipo && 
            p.talla === producto.talla 
        );

        if (indice > -1) {
            items[indice].cantidad += parseInt(producto.cantidad);
        } else {
            items.push(producto);
        }

        this.guardarItems(items);
        this.abrir();
        
        if (typeof Alerta !== 'undefined') {
            Alerta.toast(`Agregado: ${producto.nombre} (Talla: ${producto.talla})`);
        }
    },

    eliminar: function(index) {
        let items = this.obtenerItems();
        items.splice(index, 1);
        this.guardarItems(items); // Esto repinta el carrito automáticamente
    },

    vaciar: function() {
        localStorage.removeItem(this.clave);
        this.actualizarContador();
        this.renderSideCart();
    },

    actualizarContador: function() {
        const items = this.obtenerItems();
        const total = items.reduce((sum, item) => sum + parseInt(item.cantidad), 0);
        
        const contador = document.getElementById('cart-count'); // Asegúrate de tener este ID en tu header
        if(contador) {
            contador.innerText = total;
            contador.style.display = total > 0 ? 'inline-block' : 'none';
        }
    },

    // --- NUEVAS FUNCIONES PARA EL SIDEBAR ---

    abrir: function() {
        this.renderSideCart();
        document.getElementById('cart-sidebar').classList.add('active');
        document.getElementById('cart-overlay').classList.add('active');
        document.body.style.overflow = 'hidden'; // Evita scroll en la página de atrás
    },

    cerrar: function() {
        document.getElementById('cart-sidebar').classList.remove('active');
        document.getElementById('cart-overlay').classList.remove('active');
        document.body.style.overflow = ''; // Devuelve el scroll
    },

    renderSideCart: function() {
        const container = document.getElementById('cart-items-container');
        const totalElem = document.getElementById('cart-total-amount');
        
        if (!container || !totalElem) return; // Seguridad si no estamos en una página con header

        const items = this.obtenerItems();
        container.innerHTML = '';
        let total = 0;

        if (items.length === 0) {
            container.innerHTML = '<p style="text-align:center; color:#777; margin-top:2rem;">Tu carrito está vacío</p>';
            totalElem.innerText = '$0.00';
            return;
        }

        items.forEach((item, index) => {
            const subtotal = item.precio * item.cantidad;
            total += subtotal;

            // Creamos el HTML del item
            const itemHTML = `
                <div class="cart-item-side">
                    <img src="/LaHerradura/uploads/${item.tipo.toLowerCase()}s/${item.imagen}" alt="${item.nombre}">
                    <div class="item-details" style="flex-grow:1;">
                        <h4>${item.nombre}</h4>
                        
                        <div style="font-size: 0.85rem; color: #444; margin-bottom: 2px;">
                            Talla: <strong>${item.talla || 'N/A'}</strong>
                        </div>
                        <div class="item-price">$${item.precio} x ${item.cantidad}</div>
                        <div style="font-size:0.9rem; color:#666;">Subtotal: $${subtotal}</div>
                    </div>
                    <div style="display:flex; flex-direction:column; justify-content:center;">
                        <span class="btn-remove-item" onclick="Carrito.eliminar(${index})">
                            <span class="material-symbols-outlined">delete</span>
                        </span>
                    </div>
                </div>
            `;
            container.innerHTML += itemHTML;
        });

        totalElem.innerText = '$' + total.toFixed(2);
    }
};

// --- EVENTOS DE INICIALIZACIÓN ---
document.addEventListener('DOMContentLoaded', () => {
    Carrito.actualizarContador();

    // 1. Botón del Header para abrir
    const btnOpen = document.getElementById('btn-open-cart'); // OJO: Ponle este ID a tu ícono en el header
    if (btnOpen) {
        btnOpen.addEventListener('click', (e) => {
            e.preventDefault();
            Carrito.abrir();
        });
    }

    // 2. Botón Cerrar (X)
    const btnClose = document.getElementById('btn-close-cart');
    if (btnClose) {
        btnClose.addEventListener('click', () => Carrito.cerrar());
    }

    // 3. Clic en el fondo oscuro para cerrar
    const overlay = document.getElementById('cart-overlay');
    if (overlay) {
        overlay.addEventListener('click', () => Carrito.cerrar());
    }

    // 4. Botón Pagar (Lógica corregida)
    const btnPagar = document.getElementById('btn-pagar-side');
    if (btnPagar) {
        btnPagar.addEventListener('click', () => {
            
            // PASO 1: Cerrar el carrito lateral para que no estorbe
            Carrito.cerrar();

            // PASO 2: Verificar si existe la función del checkout y abrirla
            if (typeof abrirCheckout === 'function') {
                abrirCheckout(); 
            } else {
                console.error("Error: No encuentro la función abrirCheckout(). ¿Incluiste el archivo checkout.js?");
                // Solo si falla, redirigir como plan B (opcional)
                // window.location.href = '/LaHerradura/View/pages/user/carrito.php';
            }
        });
    }
});