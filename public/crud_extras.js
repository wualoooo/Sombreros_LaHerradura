/**
 * Función Mágica Reutilizable para Formularios Simples
 * @param {string} idFormulario - El ID del <form> en tu HTML
 * @param {string} urlBackend - La ruta al archivo PHP (ej: controller/registroHormas.php)
 * @param {string} nombreEntidad - El nombre para las alertas (ej: "Horma", "Material")
 */
function configurarFormularioExtra(idFormulario, urlBackend, nombreEntidad) {
    
    const formulario = document.getElementById(idFormulario);

    // Validación de seguridad: Si no existe el form en esta página, no hacemos nada
    if (!formulario) return;

    formulario.addEventListener('submit', function(e) {
        e.preventDefault(); // Evitar recarga

        const btnSubmit = formulario.querySelector('input[type="submit"], button[type="submit"]');
        const textoOriginal = btnSubmit ? btnSubmit.value : 'Guardar';
        
        // Efecto de carga
        if(btnSubmit) {
            btnSubmit.value = "Guardando...";
            btnSubmit.disabled = true;
        }

        const formData = new FormData(formulario);

        fetch(urlBackend, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Restaurar botón
            if(btnSubmit) {
                btnSubmit.value = textoOriginal;
                btnSubmit.disabled = false;
            }

            if (data.success) {
                // ÉXITO
                alert(`${nombreEntidad} registrada correctamente.`);
                
                formulario.reset(); // Limpiar campos
                
                // Opcional: Cerrar modal si está dentro de uno
                const modal = formulario.closest('.modal'); // Busca el modal padre
                if(modal) modal.style.display = 'none';

                location.reload(); // Recargar para ver cambios en tabla
            } else {
                // ERROR (Viene del PHP que arreglamos antes)
                alert(`Error al guardar ${nombreEntidad}:\n${data.message}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Error de conexión con el servidor.");
            if(btnSubmit) {
                btnSubmit.value = textoOriginal;
                btnSubmit.disabled = false;
            }
        });
    });
}