document.addEventListener("DOMContentLoaded", () => {

    // --- 1. FUNCIÓN PARA ACTIVAR UN MODAL ---
    function activarModal(triggerId, modalId) {
        const trigger = document.getElementById(triggerId);
        const modal = document.getElementById(modalId);
        
        if (trigger && modal) {
            const closeBtn = modal.querySelector(".close");
            
            trigger.onclick = (e) => {
                e.preventDefault();
                modal.style.display = "block";
            };

            if (closeBtn) {
                closeBtn.onclick = () => modal.style.display = "none";
            }
        }
    }

    // --- 2. MAPEO DE MODALES (Configuración) ---
    const conexiones = [
        { btn: "openLogin", modal: "modal-Login" },
        { btn: "buttonCrear", modal: "modal-CrearCuenta" },
        { btn: "btnAgg-Sombrero", modal: "modal-AggSombrero" },
        { btn: "btnAgg-Texana", modal: "modal-AggTexana" },
        { btn: "btnAgg-Admin", modal: "modal-RegAdmin" },
        { btn: "btn-editar", modal: "modal-EditSombrero" },
        { btn: "btnAgg-Cinturon", modal: "modal-AggCinturon" },
        { btn: "btnAgg-Botin", modal: "modal-AggBotin" },
        { btn: "btnAgg-Horma", modal: "modal-AggHorma" },
        { btn: "btnAgg-Copa", modal: "modal-AggCopa" },
        { btn: "btnAgg-Material", modal: "modal-AggMaterial" },
        { btn: "btnAgg-Color", modal: "modal-AggColor" },
        { btn: "openUserInfo", modal: "modal-UserInfo" },
        { btn: "AgregarDireccion", modal: "modal-AgregarDirección" }
    ];

    conexiones.forEach(item => activarModal(item.btn, item.modal));

    // --- 3. LOGICA ESPECIAL: TARJETAS DE PRODUCTO (Clases) ---
    const modalVp = document.getElementById("modal-ViewProducts");
    if (modalVp) {
        const triggersVp = document.querySelectorAll(".abrir-modal-vp");
        const closeBtnVp = modalVp.querySelector(".close");

        triggersVp.forEach(trigger => {
            trigger.onclick = () => modalVp.style.display = "block";
        });

        if (closeBtnVp) {
            closeBtnVp.onclick = () => modalVp.style.display = "none";
        }
    }

    // --- 4. CIERRE GLOBAL (Hacer clic afuera) ---
    window.onclick = (e) => {
        if (e.target.classList.contains('modal')) {
            e.target.style.display = "none";
        }
    };
});

// Función global para manejar el cambio de pasos con validación
function cambiarPaso(pasoActual, pasoSiguiente) {
    
    // 1. VALIDACIÓN: Solo revisamos si el usuario intenta avanzar (no si retrocede)
    if (pasoSiguiente > pasoActual) {
        // Capturamos el contenedor del paso actual
        const contenedorPasoActual = document.getElementById(`step-${pasoActual}`);
        
        // Buscamos todos los inputs y selects que están dentro de este paso
        const campos = contenedorPasoActual.querySelectorAll('input, select, textarea');
        
        let pasoEsValido = true;

        // Recorremos cada campo para ver si es válido según HTML5 (required, min, etc.)
        for (let i = 0; i < campos.length; i++) {
            // Validamos que los selects no se hayan quedado en la opción por defecto ("Null" o vacíos)
            if (campos[i].tagName.toLowerCase() === 'select' && campos[i].hasAttribute('required') && (campos[i].value === 'Null' || campos[i].value === '')) {
                pasoEsValido = false;
                // Como reportValidity no siempre se ve bien en selects, podemos mostrar una alerta
                Swal.fire({
                    icon: 'warning',
                    title: 'Campo requerido',
                    text: 'Por favor, selecciona una opción en todos los menús desplegables.',
                    confirmButtonColor: '#4C8F43'
                });
                break;
            }

            // checkValidity() revisa cosas como 'required', 'min', 'type="number"', etc.
            if (!campos[i].checkValidity()) {
                pasoEsValido = false;
                campos[i].reportValidity(); // Muestra el globito rojo nativo del navegador ("Completa este campo")
                break; // Detenemos el ciclo al primer error
            }
        }

        // Si encontramos un error, detenemos la función aquí y NO cambiamos de paso
        if (!pasoEsValido) {
            return; 
        }
    }

    // 2. CAMBIO DE PANTALLA (Si todo es válido o si el usuario va hacia atrás)
    document.getElementById(`step-${pasoActual}`).style.display = 'none';
    
    const stepSiguiente = document.getElementById(`step-${pasoSiguiente}`);
    stepSiguiente.style.display = 'block';
    stepSiguiente.style.animation = 'none';
    stepSiguiente.offsetHeight; /* trigger reflow */
    stepSiguiente.style.animation = null; 

    // 3. ACTUALIZAR LAS BOLITAS (Indicadores)
    const dots = document.querySelectorAll('.paso-dot');
    dots.forEach((dot, index) => {
        if (index < pasoSiguiente) {
            dot.classList.add('active');
        } else {
            dot.classList.remove('active');
        }
    });
}