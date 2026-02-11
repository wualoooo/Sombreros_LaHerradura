document.addEventListener("DOMContentLoaded", () => {

    // --- 1. FUNCIÓN GENÉRICA PARA ACTIVAR UN MODAL ---
    function activarModal(triggerId, modalId) {
        const trigger = document.getElementById(triggerId);
        const modal = document.getElementById(modalId);
        
        if (trigger && modal) {
            const closeBtn = modal.querySelector(".close");
            
            trigger.onclick = (e) => {
                e.preventDefault(); // Evita saltos de página en enlaces
                modal.style.display = "block";
            };

            if (closeBtn) {
                closeBtn.onclick = () => modal.style.display = "none";
            }
        } else {
            console.warn(`No se pudo vincular trigger: ${triggerId} con modal: ${modalId}`);
        }
    }

    // --- 2. MAPEO DE MODALES (Configuración) ---
    // Aquí listas tus conexiones. Es más limpio que llamar la función 20 veces.
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
    // Esto funciona para CUALQUIER modal, sin tener que poner su ID
    window.onclick = (e) => {
        if (e.target.classList.contains('modal')) {
            e.target.style.display = "none";
        }
    };
});