// Variable global para saber en qué paso estamos
let pasoActual = 1;

function abrirCheckout() {
    const modal = document.getElementById('modal-checkout');
    modal.style.display = 'flex';
    cargarResumenCarrito(); // Llenar la tabla del paso 1
    cambiarPaso(1); // Resetear al paso 1
}

function cerrarModalCheckout() {
    document.getElementById('modal-checkout').style.display = 'none';
}

// Lógica para cambiar de Vistas (Tabs)
function cambiarPaso(paso) {
    // 1. Ocultar todos los pasos
    document.getElementById('step-view-1').style.display = 'none';
    document.getElementById('step-view-2').style.display = 'none';
    document.getElementById('step-view-3').style.display = 'none';

    // 2. Quitar clase 'active' de los indicadores
    document.getElementById('indicator-1').classList.remove('active');
    document.getElementById('indicator-2').classList.remove('active');
    document.getElementById('indicator-3').classList.remove('active');

    // 3. Mostrar el paso seleccionado
    document.getElementById(`step-view-${paso}`).style.display = 'block';
    document.getElementById(`indicator-${paso}`).classList.add('active');
    
    pasoActual = paso;

    // Si vamos al paso 2, deberíamos cargar las direcciones reales (Aquí simulado por ahora)
    if(paso === 2) {
        // cargarDireccionesDeUsuario(); <--- Esto lo harás con fetch después
    }
}

// Llenar la tabla del Paso 1 con lo que hay en LocalStorage
function cargarResumenCarrito() {
    // Asumiendo que guardas el carrito así en LocalStorage
    let carrito = JSON.parse(localStorage.getItem('laherradura_carrito')) || [];
    const tbody = document.getElementById('checkout-lista-productos');
    const totalSpan = document.getElementById('checkout-total-monto');
    const totalFinalSpan = document.getElementById('pago-total-final');
    
    tbody.innerHTML = '';
    let total = 0;

    carrito.forEach(prod => {
        let subtotal = prod.precio * prod.cantidad;
        total += subtotal;
        
        let fila = `
            <tr>
                <td>${prod.nombre}</td>
                <td>${prod.talla || 'N/A'}</td> <td>${prod.cantidad}</td>
                <td>$${subtotal.toFixed(2)}</td>
            </tr>
        `;
        tbody.innerHTML += fila;
    });

    totalSpan.textContent = `$${total.toFixed(2)}`;
    totalFinalSpan.textContent = `$${total.toFixed(2)}`;
}

// Mostrar/Ocultar form de nueva dirección
function toggleNuevaDireccion() {
    const form = document.getElementById('form-nueva-direccion');
    form.style.display = (form.style.display === 'none') ? 'block' : 'none';
}

// --- LA JOYA DE LA CORONA: ENVIAR TODO AL BACKEND ---
function procesarCompraFinal() {
    
    // 1. Recolectar Datos
    const carrito = JSON.parse(localStorage.getItem('laherradura_carrito')) || [];
    // Buscar qué radio button de dirección está seleccionado
    const direccionSeleccionada = document.querySelector('input[name="direccion_envio"]:checked');
    
    if (!direccionSeleccionada) {
        alert("Por favor selecciona una dirección de envío en el paso 2.");
        cambiarPaso(2); // Regresarlo al paso 2
        return;
    }

    const totalTexto = document.getElementById('pago-total-final').textContent;
    const totalNumerico = parseFloat(totalTexto.replace('$', ''));

    const datosCompra = {
        carrito: carrito,
        id_direccion: direccionSeleccionada.value,
        total: totalNumerico
    };

    // 2. Enviar a PHP (AJAX)
    fetch('/LaHerradura/Controller/FinalizarCompra.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(datosCompra)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // ¡ÉXITO!
            // 1. Limpiar carrito
            localStorage.removeItem('laherradura_carrito');
            
            Swal.fire({
                title: '¡Compra Exitosa!',
                html: `Tu pedido ha sido procesado.<br><br>Tu código de rastreo es: <strong>${data.codigo_rastreo}</strong>`,
                icon: 'success',
                confirmButtonColor: '#8B0000', // Tu color vino de La Herradura
                confirmButtonText: 'Aceptar',
                allowOutsideClick: false // Evita que lo cierren dando clic afuera
            }).then((result) => {
                // Esto se ejecuta SOLAMENTE cuando el usuario le da a "Aceptar"
                if (result.isConfirmed) {
                    cerrarModalCheckout();
                    window.location.reload();
                }
            });
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Ocurrió un error al procesar el pago.");
    });
}