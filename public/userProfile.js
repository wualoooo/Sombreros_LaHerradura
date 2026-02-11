document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('upload-profile-pic');
    const profileImage = document.getElementById('user-profile-image');
    
    if (!fileInput || !profileImage) return; // Seguridad si no está el modal

    fileInput.addEventListener('change', function(e) {
        const file = this.files[0];
        if (!file) return;

        // Feedback visual inmediato (opcional: spinner)
        const originalSrc = profileImage.src;
        profileImage.style.opacity = '0.5'; // Indicar carga

        const formData = new FormData();
        formData.append('profile_pic', file);

        // Usar fetch para subir sin recargar
        fetch('/LaHerradura/Controller/updateProfilePic.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            profileImage.style.opacity = '1'; // Restaurar opacidad

            if (data.success) {
                // Actualizar la imagen en el modal inmediatamente
                profileImage.src = data.newSrc;
                
                // Opcional: si tuvieras una miniatura en el header, actualizarla también
                const headerPic = document.getElementById('header-user-pic');
                if(headerPic) headerPic.src = data.newSrc;

                if (typeof Alerta !== 'undefined') {
                    Alerta.toast('Foto de perfil actualizada', 'success');
                }
            } else {
                // Error: restaurar y mostrar mensaje
                fileInput.value = ''; // Limpiar input
                if (typeof Alerta !== 'undefined') {
                    Alerta.error(data.message);
                } else {
                    alert(data.message);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            profileImage.style.opacity = '1';
            fileInput.value = '';
            if (typeof Alerta !== 'undefined') Alerta.error('Error de conexión.');
        });
    });
});