// Espera a que todo el HTML esté cargado
document.addEventListener('DOMContentLoaded', () => {

    // Selecciona el modal y sus partes (basado en tu imagen 700d5a.png)
    const modal = document.getElementById('modal-ViewProducts');
    const modalNombre = document.getElementById('name-sombrero-vp');
    const modalPrecio = document.getElementById('precio-vp');
    const modalImgContenedor = document.getElementById('img-sombrero');
    const modalColor = document.querySelector('.details-sombrero:nth-child(1)'); // Forma de seleccionar por clase
    const modalHorma = document.querySelector('.details-sombrero:nth-child(2)');
    // ... etc. para todos tus campos de detalles

    // Usamos delegación de eventos para más eficiencia
    document.body.addEventListener('click', function(evento) {
        
        // Vemos si el clic fue en una tarjeta (o en algo dentro de ella)
        const tarjetaClicada = evento.target.closest('.abrir-modal-vp');
        
        if (tarjetaClicada) {
            
            // 1. Obtenemos el ID del 'data-id'
            const id = tarjetaClicada.dataset.id;
            
            console.log("Haciendo fetch para el ID:", id);
            // 2. Llamamos a nuestro PHP usando fetch
            // (¡Ajusta esta ruta a donde sea que pongas tu archivo PHP!)
            fetch(`../../Controller/ViewSombreros.php?id=${id}`)
                .then(response => response.json()) // Convierte la respuesta a JSON
                .then(data => {
                    // 3. Rellenamos el modal con los datos recibidos
    //    ¡Esto es mucho más limpio que antes!
    
    console.log("Datos recibidos del PHP:", data);

    document.getElementById('name-sombrero-vp').textContent = data.Nombre;
    document.getElementById('precio-vp').textContent = `$${data.Precio}.00 mxn`;

    // Rellenamos los detalles (usando los nuevos IDs)
    document.getElementById('modal-color').textContent = `Color: ${data.Color}`;
    document.getElementById('modal-horma').textContent = `Horma: ${data.Horma}`;
    document.getElementById('modal-copa').textContent = `Copa: ${data.Copa}`;
    document.getElementById('modal-tam-copa').textContent = `Tamaño copa: ${data.Tam_Copa}`;
    document.getElementById('modal-material').textContent = `Material: ${data.Material}`;

    // Rellenamos la imagen
    const imgCont = document.getElementById('img-sombrero');
    imgCont.innerHTML = `<img src="../../uploads/sombreros/${data.Img1}" alt="${data.Nombre}">`;
    
    // 4. Mostramos el modal
    modal.style.display = 'block';
                })
                .catch(error => console.error('Error al cargar datos:', error));
        }
    });

    // Tu código para cerrar el modal (asumo que ya lo tienes)
    const spanClose = document.querySelector('.modal-content-vp .close');
    spanClose.onclick = function() {
        modal.style.display = "none";
    }
});