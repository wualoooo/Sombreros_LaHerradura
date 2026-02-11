document.addEventListener('DOMContentLoaded', () => {
    const switches = document.querySelectorAll('.btn-estado');

    switches.forEach(btn => {
        btn.addEventListener('change', function() {
            const id = this.dataset.id;
            const tabla = this.dataset.tabla;
            const colID = this.dataset.colId;
            const nuevoEstado = this.checked ? 1 : 0; // Si está checked mandamos 1, si no 0

            // Feedback visual opcional (deshabilitar mientras carga)
            this.disabled = true;

            fetch('/LaHerradura/Controller/EstadoProductos.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    id: id,
                    tabla: tabla,
                    columnaID: colID,
                    estado: nuevoEstado
                })
            })
            .then(res => res.json())
            .then(data => {
                this.disabled = false; // Rehabilitar
                
                if (data.success) {
                    // Opcional: Mostrar toast de éxito pequeño
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    Toast.fire({
                        icon: 'success',
                        title: nuevoEstado ? 'Producto Activado' : 'Producto Desactivado'
                    });
                } else {
                    // Si falló, regresamos el switch a como estaba
                    this.checked = !this.checked;
                    Swal.fire('Error', 'No se pudo cambiar el estado', 'error');
                }
            })
            .catch(err => {
                console.error(err);
                this.checked = !this.checked; // Revertir cambio visual
                this.disabled = false;
            });
        });
    });
});