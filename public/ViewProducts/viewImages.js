/**
 * Función REUTILIZABLE para conectar un input de archivo a una vista previa de imagen
 * y opcionalmente mostrar el nombre del archivo en un span.
 * * @param {string} inputId - El ID del <input type="file">
 * @param {string} previewId - El ID del <img> para la vista previa
 * @param {string} [spanId] - (Opcional) El ID del <span> donde mostrar el nombre del archivo
 */
function setupImagePreview(inputId, previewId, spanId) {

    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    
    // Solo busca el span SI se pasó el spanId como argumento
    const fileNameSpan = spanId ? document.getElementById(spanId) : null;

    if (!input) {
        // console.warn(`(viewImages) No se encontró el input #${inputId}`);
        return;
    }
    if (!preview) {
        // console.warn(`(viewImages) No se encontró el preview #${previewId}`);
        return;
    }

    input.addEventListener('change', function() {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);

            // Muestra el nombre del archivo en el span (si existe)
            if (fileNameSpan) {
                fileNameSpan.textContent = file.name;
            }

        } else {
            preview.src = '#';
            preview.style.display = 'none';

            // Limpia el nombre del archivo si se cancela
            if (fileNameSpan) {
                fileNameSpan.textContent = '';
            }
        }
    });
}

// ¡YA NO HAY LLAMADAS A LA FUNCIÓN AQUÍ!
// Este archivo ahora solo DEFINE la función, no la ejecuta.

