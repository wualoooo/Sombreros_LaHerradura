<link rel="stylesheet" href="/LaHerradura/View/css/style-ModalEdit.css">

<div class="modal-Edit" id="modal-EditTexana">
    <div class="modal-content-Edit">
        <span class="close">&times;</span>
        <h2 class="Edit-text">Editar Texana</h2> 
        
        <div class="indicador-pasos">
            <span class="paso-dot-edit active">1</span>
            <span class="paso-dot-edit">2</span>
            <span class="paso-dot-edit">3</span>
        </div>

        <div class="cont-form-Edit">
            <form class="EditSom" id="form-EditTexana" action="/LaHerradura/Controller/CRUD_Texanas/ActualizarTexana.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="edit-id-texana" name="id_texana">
                
                <div class="pasarela-step-edit active" id="step-edit-texana-1">
                    <h3>Paso 1: Información Básica</h3>

                    <label class="lbl-Edit" for="edit-SKUTexana">Código del Producto (SKU)</label>
                    <input class="input-Edit" type="text" name="SKUTexana" id="edit-SKUTexana" readonly style="background-color: #e9ecef; cursor: not-allowed;" required>

                    <label class="lbl-Edit" for="edit-NombreTexana">Nombre</label>
                    <input class="input-Edit" type="text" name="NombreTexana" id="edit-NombreTexana" required>
                    
                    <label class="lbl-Edit" for="edit-ColorTexana">Color</label>
                    <select class="input-Edit" name="ColorTexana" id="edit-ColorTexana" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultColores = $conn->query("SELECT id_color, Nombre FROM colores WHERE Producto = 'Texanas'");
                            while ($row = $resultColores->fetch_assoc()) echo "<option value='".$row['id_color']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <label class="lbl-Edit" for="edit-PrecioTexana">Precio ($)</label>
                    <input class="input-Edit" type="number" name="PrecioTexana" id="edit-PrecioTexana" step="10" required min="0">
                    
                    <div class="divButton-pasarela">
                        <button type="button" class="btn-siguiente" onclick="cambiarPasoEditTexana(1, 2)">Siguiente</button>
                    </div>
                </div>

                <div class="pasarela-step-edit" id="step-edit-texana-2" style="display: none;">
                    <h3>Paso 2: Especificaciones y Tallas</h3>
                    
                    <label class="lbl-Edit" for="edit-HormaTexana">Horma</label>
                    <select class="input-Edit" name="HormaTexana" id="edit-HormaTexana" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resulthormas = $conn->query("SELECT id_horma, Nombre FROM hormas");
                            while ($row = $resulthormas->fetch_assoc()) echo "<option value='".$row['id_horma']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <label class="lbl-Edit" for="edit-CopaTexana">Copa</label>
                    <select class="input-Edit" name="CopaTexana" id="edit-CopaTexana" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultcopas = $conn->query("SELECT id_copa, Nombre FROM copas");
                            while ($row = $resultcopas->fetch_assoc()) echo "<option value='".$row['id_copa']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <div class="inputsTamaños">
                        <div class="inputsTamañosCopa" style="width: 48%; display: inline-block;">
                            <label class="lbl-Edit" for="edit-TamañoCopaTexana">Tamaño copa</label>
                            <input class="input-Edit" type="number" name="TamañoCopaTexana" id="edit-TamañoCopaTexana" step="0.5" min="8" required>   
                        </div>
                        <div class="inputsTamañosAla" style="width: 48%; display: inline-block;">
                            <label class="lbl-Edit" for="edit-TamañoAlaTexana">Tamaño ala</label>
                            <input class="input-Edit" type="number" name="TamañoAlaTexana" id="edit-TamañoAlaTexana" step="0.5" min="8" required>
                        </div>
                    </div>

                    <label class="lbl-Edit" for="edit-MaterialTexana">Material</label>
                    <select class="input-Edit" name="MaterialTexana" id="edit-MaterialTexana" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultMateriales = $conn->query("SELECT id_material, Nombre FROM materiales WHERE Producto = 'Texanas'");
                            while ($row = $resultMateriales->fetch_assoc()) echo "<option value='".$row['id_material']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <hr style="border: 0; border-top: 1px solid #ddd; margin: 20px 0;">

                    <label class="lbl-Edit">Tallas Disponibles</label>
                    <div class="contenedor-tallas">
                        <?php
                        $tallas_comunes = ['53', '54', '55', '56', '57', '58', '59', '60', '61'];
                        foreach($tallas_comunes as $talla) {
                            echo "
                            <label class='talla-checkbox'>
                                <input type='checkbox' name='tallas_disponibles[]' value='$talla' class='talla-edit-checkbox'>
                                <span class='talla-btn'>$talla</span>
                            </label>";
                        }
                        ?>
                    </div>

                    <div class="divButton-pasarela">
                        <button type="button" class="btn-anterior" onclick="cambiarPasoEditTexana(2, 1)">Anterior</button>
                        <button type="button" class="btn-siguiente" onclick="cambiarPasoEditTexana(2, 3)">Siguiente</button>
                    </div>
                </div>

                <div class="pasarela-step-edit" id="step-edit-texana-3" style="display: none;">
                    <h3>Paso 3: Fotografías del Producto</h3>
                    <p style="font-size: 0.85rem; color: #666; margin-bottom: 10px;">(Solo sube imágenes si deseas reemplazar las actuales)</p>
                    <div class="contenedor-preview" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                        <?php for($i=1; $i<=4; $i++): ?>
                        <div class="caja-preview">
                            <input type="file" name="imgTexana<?php echo $i; ?>" id="imgEditTexana<?php echo $i; ?>" class="input-img-oculto" accept="image/*">
                            <label for="imgEditTexana<?php echo $i; ?>" class="label-boton">Imagen <?php echo $i; ?></label>
                            <img id="previewEditTexana<?php echo $i; ?>" class="preview" src="#" alt="Vista previa <?php echo $i; ?>" style="display: block;">
                        </div>
                        <?php endfor; ?>
                    </div>

                    <div class="divButton-pasarela">
                        <button type="button" class="btn-anterior" onclick="cambiarPasoEditTexana(3, 2)">Anterior</button>
                        <button type="button" class="ButtonGuardarEdit" id="btnGuardarEditTexanas" onclick="enviarFormularioEditTexana()">Guardar Cambios</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
// Función específica para cambiar pasos en Texanas
window.cambiarPasoEditTexana = function(pasoActual, pasoSiguiente) {
    if (pasoSiguiente > pasoActual) {
        const contenedorPasoActual = document.getElementById(`step-edit-texana-${pasoActual}`);
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

    document.getElementById(`step-edit-texana-${pasoActual}`).style.display = 'none';
    document.getElementById(`step-edit-texana-${pasoSiguiente}`).style.display = 'block';

    const dots = document.querySelectorAll('#modal-EditTexana .paso-dot-edit');
    dots.forEach((dot, index) => {
        if (index < pasoSiguiente) dot.classList.add('active');
        else dot.classList.remove('active');
    });
};

function enviarFormularioEditTexana() {
    document.getElementById('form-EditTexana').dispatchEvent(new Event('submit', { cancelable: true }));
}
</script>