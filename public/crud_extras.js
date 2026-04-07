/**
 * Función Mágica Reutilizable para Formularios Simples (Con SweetAlert2)
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
                // --- ÉXITO CON SWEETALERT ---
                // Usamos el nombreEntidad para que el mensaje sea dinámico (ej: "Color registrado...")
                Alerta.exito(`${nombreEntidad} registrado correctamente.`)
                    .then(() => {
                        formulario.reset(); // Limpiar campos
                        
                        // Opcional: Cerrar modal si está dentro de uno
                        const modal = formulario.closest('.modal') || formulario.closest('.modal-AggExtras');
                        if(modal) modal.style.display = 'none';

                        location.reload(); // Recargar para ver cambios en tabla
                    });

            } else {
                // --- ERROR CON SWEETALERT ---
                Alerta.error(`Error al guardar ${nombreEntidad}:<br>${data.message}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // --- ERROR DE CONEXIÓN CON SWEETALERT ---
            Alerta.error("Error de conexión con el servidor.");
            
            if(btnSubmit) {
                btnSubmit.value = textoOriginal;
                btnSubmit.disabled = false;
            }
        });
    });
}

function borrarExtra(id, tipo) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: `Estás a punto de eliminar este ${tipo}.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Preparamos los datos a enviar
            const formData = new FormData();
            formData.append('id', id);
            formData.append('tipo', tipo);

            // Enviamos a PHP
            fetch('../../../Controller/CRUD_Extras/eliminarExtras.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('¡Eliminado!', data.message, 'success')
                    .then(() => location.reload());
                } else {
                    Swal.fire('No se pudo eliminar', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Hubo un problema de conexión con el servidor.', 'error');
            });
        }
    });
}