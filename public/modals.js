function activarModal(triggerId, modalId) {
  const trigger = document.getElementById(triggerId);
  const modal = document.getElementById(modalId);
  
  if (!trigger) {
    console.warn(`Advertencia: No se encontró el trigger con id="${triggerId}"`);
    return;
  }
  if (!modal) {
    console.error(`Error: No se encontró el modal con id="${modalId}"`);
    return;
  }

  const closeBtn = modal.querySelector(".close");

  if (closeBtn) {
    trigger.onclick = () => modal.style.display = "block";
    closeBtn.onclick = () => modal.style.display = "none";
  } else {
    console.warn(`Advertencia: El modal "${modalId}" no tiene un botón con la clase ".close"`);
  }
}

document.addEventListener("DOMContentLoaded", () => {
  
  activarModal("openLogin", "modal-Login"); 
  activarModal("buttonCrear", "modal-CrearCuenta");
  activarModal("btnAgg-Sombrero", "modal-AggSombrero")
  activarModal("btnAgg-Admin", "modal-RegAdmin")

  // --- B. LA NUEVA LÓGICA PARA LAS TARJETAS DE PRODUCTO ---
  const modalId_vp = "modal-ViewProducts";
  const triggerClass_vp = ".abrir-modal-vp"; 
  
  const modal_vp = document.getElementById(modalId_vp);
  const triggers_vp = document.querySelectorAll(triggerClass_vp);
  
  let closeBtn_vp = null;
  if (modal_vp) {
    closeBtn_vp = modal_vp.querySelector(".close");
  }

  if (modal_vp && triggers_vp.length > 0 && closeBtn_vp) {
    
    console.log(`Éxito: Se encontraron ${triggers_vp.length} tarjetas de producto. Asignando clics.`);

    triggers_vp.forEach(trigger => {
      trigger.onclick = () => {
        console.log("Clic en tarjeta, abriendo modal:", modalId_vp);
        modal_vp.style.display = "block";
      };
    });

    closeBtn_vp.onclick = () => {
      modal_vp.style.display = "none";
    };
    
  } else {
    // ERROR: Si algo falla, esto es lo que verás
    console.error("Error al configurar el modal de productos:");
    if (!modal_vp) console.error(" - No se encontró el modal #modal-ViewProducts");
    if (triggers_vp.length === 0) console.error(" - No se encontró ningún trigger con la clase .abrir-modal-vp");
    if (!closeBtn_vp) console.error(" - No se encontró .close dentro de #modal-ViewProducts");
  }
  

  // --- C. LÓGICA UNIFICADA PARA CERRAR MODALES HACIENDO CLIC AFUERA ---
  window.onclick = (e) => {
    // Si el clic fue en el fondo de CUALQUIERA de tus modales, lo cierra.
    if (e.target.classList.contains('modal-vp') || e.target.classList.contains('modal')) {
       // (Asumiendo que tus modales de login/registro también tienen una clase 'modal')
       // Ajusta esta parte si es necesario.
      
       // Si el objetivo del clic ES el modal (el fondo), ciérralo.
      if (e.target.id === "modal-ViewProducts" || 
          e.target.id === "modal-Login" || 
          e.target.id === "modal-CrearCuenta") 
      {
        e.target.style.display = "none";
      }
    }
  };
  
});

document.addEventListener('DOMContentLoaded', () => {

    const formRegistro = document.getElementById('form-registro');

    // PRUEBA 1: ¿Se encontró el formulario?
    if (formRegistro) {
        console.log("Formulario de registro encontrado. Adjuntando listener."); // Deberías ver esto en la consola (F12) al cargar la página.

        formRegistro.addEventListener('submit', function (e) {
            e.preventDefault(); 
            
            // PRUEBA 2: ¿El 'submit' fue capturado?
            console.log("Submit detectado. Enviando datos..."); // Deberías ver esto en la consola al dar clic.

            const formData = new FormData(this);

            fetch(this.action, {
                method: this.method,
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                
                // PRUEBA 3: ¿Qué respondió PHP?
                // ¡Esto es lo más importante!
                console.log("Respuesta de PHP:", data); 

                // Lógica de alerta mejorada
                if (data.includes("correctamente")) {
                    alert('¡Registro exitoso!');
                    document.getElementById('modal-CrearCuenta').style.display = 'none';
                    formRegistro.reset(); 

                } else if (data.trim() === "") {
                    // Si PHP no devolvió NADA
                    alert("Error: El servidor no dio respuesta. Revisa el PHP.");
                
                } else {
                    // Si PHP devolvió un error (ej: "Error: Correo ya existe")
                    alert(data); 
                }
            })
            .catch(error => {
                // PRUEBA 4: ¿Falló la conexión?
                console.error('Error en la solicitud fetch:', error);
                alert('Error de conexión. Revisa la consola (F12) para más detalles.');
            });
        });
    } else {
        // Si no se encontró el formulario
        console.warn("ADVERTENCIA: No se encontró el elemento #form-registro en esta página.");
    }
});
