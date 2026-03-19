// INICIALIZA MERCADO PAGO (Pon tu PUBLIC KEY de pruebas aquí)
const mp = new MercadoPago('APP_USR-d7315938-5543-4aed-86c2-db72c07c58f7', {
    locale: 'es-MX'
});

let pasoActual = 1;

function abrirCheckout() {
    document.getElementById('modal-checkout').style.display = 'flex';
    cargarResumenCarrito(); 
    cambiarPaso(1); 
}

function cerrarModalCheckout() {
    document.getElementById('modal-checkout').style.display = 'none';
}

function cambiarPaso(paso) {
    document.getElementById('step-view-1').style.display = 'none';
    document.getElementById('step-view-2').style.display = 'none';
    document.getElementById('step-view-3').style.display = 'none';

    document.getElementById('indicator-1').classList.remove('active');
    document.getElementById('indicator-2').classList.remove('active');
    document.getElementById('indicator-3').classList.remove('active');

    document.getElementById(`step-view-${paso}`).style.display = 'block';
    document.getElementById(`indicator-${paso}`).classList.add('active');
    pasoActual = paso;
}

function cargarResumenCarrito() {
    let carrito = JSON.parse(localStorage.getItem('laherradura_carrito')) || [];
    const tbody = document.getElementById('checkout-lista-productos');
    const totalSpan = document.getElementById('checkout-total-monto');
    const totalFinalSpan = document.getElementById('pago-total-final');
    
    tbody.innerHTML = '';
    let total = 0;

    carrito.forEach(prod => {
        let subtotal = prod.precio * prod.cantidad;
        total += subtotal;
        tbody.innerHTML += `<tr><td>${prod.nombre}</td><td>${prod.talla || 'N/A'}</td><td>${prod.cantidad}</td><td>$${subtotal.toFixed(2)}</td></tr>`;
    });

    totalSpan.textContent = `$${total.toFixed(2)}`;
    totalFinalSpan.textContent = `$${total.toFixed(2)}`;
}

function toggleNuevaDireccion() {
    const form = document.getElementById('form-nueva-direccion');
    if(form) form.style.display = (form.style.display === 'none') ? 'block' : 'none';
}

// LA CONEXIÓN CON EL BACKEND
function procesarCompraFinal() {
    const carrito = JSON.parse(localStorage.getItem('laherradura_carrito')) || [];
    if (carrito.length === 0) {
        alert("Tu carrito está vacío."); return;
    }

    const direccionSeleccionada = document.querySelector('input[name="direccion_envio"]:checked');
    if (!direccionSeleccionada) {
        alert("Por favor selecciona una dirección de envío.");
        cambiarPaso(2); return;
    }

    const btnPago = document.getElementById('btn-preparar-pago');
    btnPago.textContent = "Conectando...";
    btnPago.disabled = true;

    const datosCompra = {
        carrito: carrito,
        id_direccion: direccionSeleccionada.value
    };

    // Llamamos a tu controlador PHP
    fetch('/LaHerradura/Controller/FinalizarCompra.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(datosCompra)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.id_preferencia) {
            // Ocultamos el botón original
            btnPago.style.display = 'none';

            // Dibujamos la pasarela de Mercado Pago
            mp.bricks().create("wallet", "wallet_container", {
                initialization: {
                    preferenceId: data.id_preferencia,
                },
                customization: {
                    texts: { valueProp: 'security_safety' },
                },
            });
        } else {
            alert('Error: ' + (data.message || 'No se pudo generar el pago'));
            btnPago.textContent = "CONTINUAR AL PAGO";
            btnPago.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Ocurrió un error de conexión.");
        btnPago.textContent = "CONTINUAR AL PAGO";
        btnPago.disabled = false;
    });
}