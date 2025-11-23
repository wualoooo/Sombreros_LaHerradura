// alerts.js
// Requiere SweetAlert2 cargado previamente (CDN o importado)

function alertSuccess(message = 'Operación exitosa') {
  Swal.fire({
    icon: 'success',
    title: 'Éxito',
    text: message,
    confirmButtonColor: '#4CAF50'
  });
}

function alertError(message = 'Ocurrió un error') {
  Swal.fire({
    icon: 'error',
    title: 'Error',
    text: message,
    confirmButtonColor: '#d33'
  });
}

function alertInfo(message = 'Información importante') {
  Swal.fire({
    icon: 'info',
    title: 'Aviso',
    text: message,
    confirmButtonColor: '#3085d6'
  });
}

function alertConfirm(message, callback) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: message,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, continuar',
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6'
  }).then((result) => {
    if (result.isConfirmed) callback();
  });
}

function alertCustom({ title = '', html = '', icon = 'info', confirmText = 'Aceptar', cancelText = null, onConfirm = null, onCancel = null }) {
  Swal.fire({
    title,
    html,
    icon,
    showCancelButton: !!cancelText,
    confirmButtonText: confirmText,
    cancelButtonText: cancelText,
    confirmButtonColor: '#4CAF50',
    cancelButtonColor: '#d33'
  }).then((result) => {
    if (result.isConfirmed && typeof onConfirm === 'function') onConfirm();
    else if (result.dismiss === Swal.DismissReason.cancel && typeof onCancel === 'function') onCancel();
  });
}