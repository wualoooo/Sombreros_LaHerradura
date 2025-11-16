function setupImagePreview(inputId, previewId) {
    
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);

    // NUEVO: Encontrar el span para el nombre del archivo
    // (Asume que se llama 'fileName1' si el input es 'imgInput1')
    const spanId = 'fileName' + inputId.replace('imgSombrero', '');
    const fileNameSpan = document.getElementById(spanId);

    input.addEventListener('change', function() {
        
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);

            // NUEVO: Muestra el nombre del archivo en el span
            if (fileNameSpan) {
                fileNameSpan.textContent = file.name;
            }

        } else {
            preview.src = '#';
            preview.style.display = 'none';
            
            // NUEVO: Limpia el nombre del archivo si se cancela
            if (fileNameSpan) {
                fileNameSpan.textContent = '';
            }
        }
    });
}

setupImagePreview('imgEditSombrero1', 'previewEditSombrero1');
setupImagePreview('imgEditSombrero2', 'previewEditSombrero2');
setupImagePreview('imgEditSombrero3', 'previewEditSombrero3');
setupImagePreview('imgEditSombrero4', 'previewEditSombrero4');

setupImagePreview('imgSombrero1', 'previewSombrero1');
setupImagePreview('imgSombrero2', 'previewSombrero2');
setupImagePreview('imgSombrero3', 'previewSombrero3');
setupImagePreview('imgSombrero4', 'previewSombrero4');

