
const Alerta = {
    // 1. Alerta de Éxito (Verde)
    exito: function(mensaje, titulo = '¡Éxito!') {
        return Swal.fire({
            title: titulo,
            text: mensaje,
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
        });
    },

    // 2. Alerta de Error (Rojo)
    error: function(mensaje, titulo = 'Error') {
        return Swal.fire({
            title: titulo,
            text: mensaje,
            icon: 'error',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Cerrar'
        });
    },

    // 3. Alerta de Confirmación (Pregunta Sí/No)
    // Retorna una promesa para que puedas usar .then()
    confirmar: function(mensaje, textoBoton = 'Sí, continuar') {
        return Swal.fire({
            title: '¿Estás seguro?',
            text: mensaje,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: textoBoton,
            cancelButtonText: 'Cancelar'
        });
    },

    // 4. Toast (Notificación pequeña en la esquina)
    toast: function(mensaje, icon = 'success') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: icon,
            title: mensaje
        });
    }
};