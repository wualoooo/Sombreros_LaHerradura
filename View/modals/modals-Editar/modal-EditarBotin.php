<link rel="stylesheet" href="/LaHerradura/View/css/style-ModalEdit.css">

<div class="modal-Edit" id="modal-EditBotin">
    <div class="modal-content-Edit">
        <span class="close">&times;</span>
        <h2 class="Edit-text">Editar Botín</h2> 
        
        <div class="indicador-pasos">
            <span class="paso-dot-edit active">1</span>
            <span class="paso-dot-edit">2</span>
            <span class="paso-dot-edit">3</span>
        </div>

        <div class="cont-form-Edit">
            <form class="EditSom" id="form-EditBotin" action="/LaHerradura/Controller/CRUD_Botines/ActualizarBotin.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="edit-id-botin" name="id_botin">
                
                <div class="pasarela-step-edit active" id="step-edit-botin-1">
                    <h3>Paso 1: Información Básica</h3>

                    <label class="lbl-Edit" for="edit-SKUBotin">Código del Producto (SKU)</label>
                    <input class="input-Edit" type="text" name="SKUBotin" id="edit-SKUBotin" required>

                    <label class="lbl-Edit" for="edit-NombreBotin">Nombre</label>
                    <input class="input-Edit" type="text" name="NombreBotin" id="edit-NombreBotin" required>
                    
                    <label class="lbl-Edit" for="edit-PrecioBotin">Precio ($)</label>
                    <input class="input-Edit" type="number" name="PrecioBotin" id="edit-PrecioBotin" step="10" required min="0">
                    
                    <div class="divButton-pasarela">
                        <button type="button" class="btn-siguiente" onclick="cambiarPasoEditBotin(1, 2)">Siguiente</button>
                    </div>
                </div>

                <div class="pasarela-step-edit" id="step-edit-botin-2" style="display: none;">
                    <h3>Paso 2: Especificaciones y Talla</h3>
                    
                    <label class="lbl-Edit" for="edit-TallaBotin">Talla</label>
                    <input class="input-Edit" type="number" name="TallaBotin" id="edit-TallaBotin" placeholder="Ej. 26.5" min="10" step="0.5" max="35" required>

                    <label class="lbl-Edit" for="edit-MaterialBotin">Material</label>
                    <select class="input-Edit" name="MaterialBotin" id="edit-MaterialBotin" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultMateriales = $conn->query("SELECT id_material, Nombre FROM materiales WHERE Producto = 'Botines'");
                            while ($row = $resultMateriales->fetch_assoc()) echo "<option value='".$row['id_material']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <label class="lbl-Edit" for="edit-SuelaBotin">Suela</label>
                    <select class="input-Edit" name="SuelaBotin" id="edit-SuelaBotin" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultSuelas = $conn->query("SELECT id_material, Nombre FROM materiales WHERE Producto = 'Suelas'");
                            while ($row = $resultSuelas->fetch_assoc()) echo "<option value='".$row['id_material']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <div class="divButton-pasarela">
                        <button type="button" class="btn-anterior" onclick="cambiarPasoEditBotin(2, 1)">Anterior</button>
                        <button type="button" class="btn-siguiente" onclick="cambiarPasoEditBotin(2, 3)">Siguiente</button>
                    </div>
                </div>

                <div class="pasarela-step-edit" id="step-edit-botin-3" style="display: none;">
                    <h3>Paso 3: Fotografías del Producto</h3>
                    <p style="font-size: 0.85rem; color: #666; margin-bottom: 10px;">(Solo sube imágenes si deseas reemplazar las actuales)</p>
                    <div class="contenedor-preview" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                        <?php for($i=1; $i<=4; $i++): ?>
                        <div class="caja-preview">
                            <input type="file" name="imgBotin<?php echo $i; ?>" id="imgEditBotin<?php echo $i; ?>" class="input-img-oculto" accept="image/*">
                            <label for="imgEditBotin<?php echo $i; ?>" class="label-boton">Imagen <?php echo $i; ?></label>
                            <img id="previewEditBotin<?php echo $i; ?>" class="preview" src="#" alt="Vista previa <?php echo $i; ?>" style="display: block;">
                        </div>
                        <?php endfor; ?>
                    </div>

                    <div class="divButton-pasarela">
                        <button type="button" class="btn-anterior" onclick="cambiarPasoEditBotin(3, 2)">Anterior</button>
                        <button type="button" class="ButtonGuardarEdit" id="btnGuardarEditBotines" onclick="enviarFormularioEditBotin()">Guardar Cambios</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
window.cambiarPasoEditBotin = function(pasoActual, pasoSiguiente) {
    if (pasoSiguiente > pasoActual) {
        const contenedorPasoActual = document.getElementById(`step-edit-botin-${pasoActual}`);
        const campos = contenedorPasoActual.querySelectorAll('input:not([type="file"]), select');

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

    document.getElementById(`step-edit-botin-${pasoActual}`).style.display = 'none';
    document.getElementById(`step-edit-botin-${pasoSiguiente}`).style.display = 'block';

    const dots = document.querySelectorAll('#modal-EditBotin .paso-dot-edit');
    dots.forEach((dot, index) => {
        if (index < pasoSiguiente) dot.classList.add('active');
        else dot.classList.remove('active');
    });
};

function enviarFormularioEditBotin() {
    document.getElementById('form-EditBotin').dispatchEvent(new Event('submit', { cancelable: true }));
}
</script>