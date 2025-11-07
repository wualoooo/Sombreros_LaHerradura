document.addEventListener("DOMContentLoaded", function() {

    // 1. Selecciona el formulario
    const loginForm = document.getElementById('loginForm');
    
    // 2. Selecciona el div de error
    const loginError = document.getElementById('loginError');

    // 3. Agrega el "escuchador" para el evento 'submit'
    loginForm.addEventListener('submit', function(event) {
        
        // ¡IMPORTANTE! Previene que el formulario se envíe de forma tradicional
        event.preventDefault(); 
        
        // Limpiamos errores previos
        loginError.textContent = '';

        // Creamos un objeto FormData con los datos del formulario
        const formData = new FormData(loginForm);

        // 4. Usamos fetch para enviar los datos a PHP
        fetch('../../Controller/InicioSesion.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) 
.then(data => {
    
    // --- INICIA DEBUG ---
    console.log("Datos recibidos:", data); // Muestra el JSON en consola
    // --- TERMINA DEBUG ---

    if (data.status === 'success') {
        
        if (data.role === 'admin') {
            // --- INICIA DEBUG ---
            console.log("Rol de admin detectado. Redirigiendo...");
            // --- TERMINA DEBUG ---
            
            // ¡AQUÍ ESTÁ EL PROBLEMA MÁS PROBABLE!
            // Esta ruta relativa 'view/pages/pedidos.php' 
            // probablemente es incorrecta desde la URL donde estás.
            window.location.href = '/LaHerradura/View/pages/pedidos.php'; 

        } else {
            console.log("Rol de usuario detectado.");
            cerrarModalLogin();
            document.getElementById('userInfo').textContent = '¡Bienvenido!';
        }
        
    } else {
        console.error("Error de login:", data.message);
        loginError.textContent = data.message;
    }
})(error => {
            // Maneja errores de red o si el JSON está mal formado
            console.error('Error en fetch:', error);
            loginError.textContent = 'Ocurrió un error de conexión. Intenta de nuevo.';
        });
    });
});

// Debes tener una función para cerrar tu modal
function cerrarModalLogin() {
    // Ejemplo:
    const modal = document.getElementById('modal-Login');
    if (modal) {
        modal.style.display = 'none';
    }
    // O si usas Bootstrap:
    // $('#loginModal').modal('hide');
}