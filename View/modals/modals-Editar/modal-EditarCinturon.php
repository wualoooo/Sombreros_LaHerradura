<link rel="stylesheet" href="/LaHerradura/View/css/style-ModalEdit.css">

<div class="modal-Edit" id="modal-EditCinturon">
    <div class="modal-content-Edit">
        <span class="close">&times;</span>
        <h2 class="Edit-text">Editar Cinturón</h2> 
        
        <div class="indicador-pasos">
            <span class="paso-dot-edit active">1</span>
            <span class="paso-dot-edit">2</span>
            <span class="paso-dot-edit">3</span>
        </div>

        <div class="cont-form-Edit">
            <form class="EditSom" id="form-EditCinturon" action="/LaHerradura/Controller/CRUD_Cinturones/ActualizarCinturon.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="edit-id-cinturon" name="id_cinturon">
                
                <div class="pasarela-step-edit active" id="step-edit-cinturon-1">
                    <h3>Paso 1: Información Básica</h3>

                    <label class="lbl-Edit" for="edit-SKUCinturon">Código del Producto (SKU)</label>
                    <input class="input-Edit" type="text" name="SKUCinturon" id="edit-SKUCinturon" required>

                    <label class="lbl-Edit" for="edit-NombreCinturon">Nombre</label>
                    <input class="input-Edit" type="text" name="NombreCinturon" id="edit-NombreCinturon" required>
                    
                    <label class="lbl-Edit" for="edit-PrecioCinturon">Precio ($)</label>
                    <input class="input-Edit" type="number" name="PrecioCinturon" id="edit-PrecioCinturon" step="10" required min="0">
                    
                    <div class="divButton-pasarela">
                        <button type="button" class="btn-siguiente" onclick="cambiarPasoEditCinturon(1, 2)">Siguiente</button>
                    </div>
                </div>

                <div class="pasarela-step-edit" id="step-edit-cinturon-2" style="display: none;">
                    <h3>Paso 2: Especificaciones y Tallas</h3>
                    
                    <label class="lbl-Edit" for="edit-MaterialCinturon">Material</label>
                    <select class="input-Edit" name="MaterialCinturon" id="edit-MaterialCinturon" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultMateriales = $conn->query("SELECT id_material, Nombre FROM materiales WHERE Producto = 'Cinturones'");
                            while ($row = $resultMateriales->fetch_assoc()) echo "<option value='".$row['id_material']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <label class="lbl-Edit" for="edit-AdornoCinturon">Adorno</label>
                    <select class="input-Edit" name="AdornoCinturon" id="edit-AdornoCinturon" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultAdornos = $conn->query("SELECT id_material, Nombre FROM materiales WHERE Producto = 'Adornos'");
                            while ($row = $resultAdornos->fetch_assoc()) echo "<option value='".$row['id_material']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <label class="lbl-Edit" for="edit-TamañoCinturon">Ancho/Grosor (Opcional)</label>
                    <input class="input-Edit" type="number" name="TamañoCinturon" id="edit-TamañoCinturon" placeholder="Ej: 3.5" step="0.5">   

                    <hr style="border: 0; border-top: 1px solid #ddd; margin: 20px 0;">

                    <label class="lbl-Edit">Tallas y Cantidad (Stock)</label>
                        <div class="contenedor-tallas" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                            <?php
                            $tallas_comunes = ['53', '54', '55', '56', '57', '58', '59', '60', '61'];
                            foreach($tallas_comunes as $talla) {
                                echo "
                                <div class='item-talla-edit' style='border: 1px solid #ccc; padding: 10px; border-radius: 6px; background-color: #f9f9f9;'>
                                    <label style='display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: bold;'>
                                        <input type='checkbox' class='check-talla-edit' name='tallas_disponibles[]' value='$talla' onchange='toggleStockEdit(this)' id='edit-check-talla-$talla'>
                                        Talla $talla
                                    </label>
                                    <div class='input-stock-container-edit' style='display: none; margin-top: 10px;'>
                                        <input type='number' name='stock_talla[$talla]' id='edit-stock-talla-$talla' class='input-Edit input-stock-edit' placeholder='Cantidad' min='1' disabled style='width: 100%; padding: 5px; box-sizing: border-box;'>
                                    </div>
                                </div>";
                            }
                            ?>
                        </div>

                        <script>
                        // Función exclusiva para el modal de edición
                        function toggleStockEdit(checkbox) {
                                const container = checkbox.closest('.item-talla-edit').querySelector('.input-stock-container-edit');
                                const input = container.querySelector('input');
                                
                                if (checkbox.checked) {
                                    container.style.display = 'block';
                                    input.disabled = false;
                                    
                                    // CORRECCIÓN AQUÍ: Verificamos si 'event' existe antes de usarlo
                                    if (typeof event !== 'undefined' && event && event.type === 'change') {
                                        input.focus(); 
                                    }
                                } else {
                                    container.style.display = 'none';
                                    input.disabled = true;
                                    input.value = '';
                                }
                            }
                        </script>

                    <div class="divButton-pasarela">
                        <button type="button" class="btn-anterior" onclick="cambiarPasoEditCinturon(2, 1)">Anterior</button>
                        <button type="button" class="btn-siguiente" onclick="cambiarPasoEditCinturon(2, 3)">Siguiente</button>
                    </div>
                </div>

                <div class="pasarela-step-edit" id="step-edit-cinturon-3" style="display: none;">
                    <h3>Paso 3: Fotografías del Producto</h3>
                    <p style="font-size: 0.85rem; color: #666; margin-bottom: 10px;">(Solo sube imágenes si deseas reemplazar las actuales)</p>
                    <div class="contenedor-preview" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                        <?php for($i=1; $i<=4; $i++): ?>
                        <div class="caja-preview">
                            <input type="file" name="imgCinturon<?php echo $i; ?>" id="imgEditCinturon<?php echo $i; ?>" class="input-img-oculto" accept="image/*">
                            <label for="imgEditCinturon<?php echo $i; ?>" class="label-boton">Imagen <?php echo $i; ?></label>
                            <img id="previewEditCinturon<?php echo $i; ?>" class="preview" src="#" alt="Vista previa <?php echo $i; ?>" style="display: block;">
                        </div>
                        <?php endfor; ?>
                    </div>

                    <div class="divButton-pasarela">
                        <button type="button" class="btn-anterior" onclick="cambiarPasoEditCinturon(3, 2)">Anterior</button>
                        <button type="button" class="ButtonGuardarEdit" id="btnGuardarEditCinturones" onclick="enviarFormularioEditCinturon()">Guardar Cambios</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
// Función para navegación de pasos en Cinturones
window.cambiarPasoEditCinturon = function(pasoActual, pasoSiguiente) {
    if (pasoSiguiente > pasoActual) {
        const contenedorPasoActual = document.getElementById(`step-edit-cinturon-${pasoActual}`);
        const campos = contenedorPasoActual.querySelectorAll('input:not([type="checkbox"]):not([type="file"]), select');

        let pasoEsValido = true;
        for (let i = 0; i < campos.length; i++) {
            if (campos[i].tagName.toLowerCase() === 'select' && campos[i].hasAttribute('required') && (campos[i].value === 'Null' || campos[i].value === '')) {
                pasoEsValido = false;
                Swal.fire({ icon: 'warning', title: 'Campo requerido', text: 'Por favor, selecciona una opción en todos los menús desplegables.', confirmButtonColor: '#4C8F43' });
                break;
            }
            if (!campos[i].checkValidity()) {
                pasoEsValido = false;
                campos[i].reportValidity();
                break;
            }
        }
        if (!pasoEsValido) return;
    }

    document.getElementById(`step-edit-cinturon-${pasoActual}`).style.display = 'none';
    document.getElementById(`step-edit-cinturon-${pasoSiguiente}`).style.display = 'block';

    const dots = document.querySelectorAll('#modal-EditCinturon .paso-dot-edit');
    dots.forEach((dot, index) => {
        if (index < pasoSiguiente) dot.classList.add('active');
        else dot.classList.remove('active');
    });
};

function enviarFormularioEditCinturon() {
    document.getElementById('form-EditCinturon').dispatchEvent(new Event('submit', { cancelable: true }));
}
</script>