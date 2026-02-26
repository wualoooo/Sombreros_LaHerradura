<link rel="stylesheet" href="/LaHerradura/View/css/style-ModalEdit.css">

<div class="modal-Edit" id="modal-EditSombrero">
    <div class="modal-content-Edit">
        <span class="close">&times;</span>
        <h2 class="Edit-text">Editar Sombrero</h2> 
        
        <div class="indicador-pasos">
            <span class="paso-dot-edit active">1</span>
            <span class="paso-dot-edit">2</span>
            <span class="paso-dot-edit">3</span>
        </div>

        <div class="cont-form-Edit">
            <form class="EditSom" id="form-EditSombrero" action="/LaHerradura/Controller/CRUD_Sombreros/ActualizarSombrero.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="edit-id-sombrero" name="id_sombrero">
                
                <div class="pasarela-step-edit active" id="step-edit-1">

                    <label class="lbl-Edit" for="edit-SKUSombrero">Código del Producto (SKU)</label>
                    <input class="input-Agregar" type="text" name="SKUSombrero" id="edit-SKUSombrero" readonly style="background-color: #e9ecef; cursor: not-allowed;">

                    <label class="lbl-Edit" for="edit-NombreSombrero">Nombre</label>
                    <input class="input-Edit" type="text" name="NombreSombrero" id="edit-NombreSombrero" required>
                    
                    <label class="lbl-Edit" for="edit-ColorSombrero">Color</label>
                    <select class="input-Edit" name="ColorSombrero" id="edit-ColorSombrero" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultColores = $conn->query("SELECT id_color, Nombre FROM colores WHERE Producto = 'Sombreros'");
                            while ($row = $resultColores->fetch_assoc()) echo "<option value='".$row['id_color']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <label class="lbl-Edit" for="edit-PrecioSombrero">Precio ($)</label>
                    <input class="input-Edit" type="number" name="PrecioSombrero" id="edit-PrecioSombrero" step="10" required min="0">
                    
                    <div class="divButton-pasarela">
                        <button type="button" class="btn-siguiente" onclick="cambiarPasoEdit(1, 2)">Siguiente</button>
                    </div>
                </div>

                <div class="pasarela-step-edit" id="step-edit-2" style="display: none;">
                    
                    <label class="lbl-Edit" for="edit-HormaSombrero">Horma</label>
                    <select class="input-Edit" name="HormaSombrero" id="edit-HormaSombrero" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resulthormas = $conn->query("SELECT id_horma, Nombre FROM hormas");
                            while ($row = $resulthormas->fetch_assoc()) echo "<option value='".$row['id_horma']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <label class="lbl-Edit" for="edit-CopaSombrero">Copa</label>
                    <select class="input-Edit" name="CopaSombrero" id="edit-CopaSombrero" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultcopas = $conn->query("SELECT id_copa, Nombre FROM copas");
                            while ($row = $resultcopas->fetch_assoc()) echo "<option value='".$row['id_copa']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <div class="inputsTamaños">
                        <div class="inputsTamañosCopa" style="width: 48%; display: inline-block;">
                            <label class="lbl-Edit" for="edit-TamañoCopaSombrero">Tamaño copa</label>
                            <input class="input-Edit" type="number" name="TamañoCopaSombrero" id="edit-TamañoCopaSombrero" step="0.5" min="8" required>   
                        </div>
                        <div class="inputsTamañosAla" style="width: 48%; display: inline-block;">
                            <label class="lbl-Edit" for="edit-TamañoAlaSombrero">Tamaño ala</label>
                            <input class="input-Edit" type="number" name="TamañoAlaSombrero" id="edit-TamañoAlaSombrero" step="0.5" min="8" required>
                        </div>
                    </div>

                    <label class="lbl-Edit" for="edit-MaterialSombrero">Material</label>
                    <select class="input-Edit" name="MaterialSombrero" id="edit-MaterialSombrero" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultMateriales = $conn->query("SELECT id_material, Nombre FROM materiales WHERE Producto = 'Sombreros'");
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
                        <button type="button" class="btn-anterior" onclick="cambiarPasoEdit(2, 1)">Anterior</button>
                        <button type="button" class="btn-siguiente" onclick="cambiarPasoEdit(2, 3)">Siguiente</button>
                    </div>
                </div>

                <div class="pasarela-step-edit" id="step-edit-3" style="display: none;">
                    <p style="font-size: 0.85rem; color: #666; margin-bottom: 10px;">(Solo sube imágenes si deseas reemplazar las actuales)</p>
                    <div class="contenedor-preview" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                        <?php for($i=1; $i<=4; $i++): ?>
                        <div class="caja-preview">
                            <input type="file" name="imgSombrero<?php echo $i; ?>" id="imgEditSombrero<?php echo $i; ?>" class="input-img-oculto" accept="image/*">
                            <label for="imgEditSombrero<?php echo $i; ?>" class="label-boton">Imagen <?php echo $i; ?></label>
                            <img id="previewEditSombrero<?php echo $i; ?>" class="preview" src="#" alt="Vista previa <?php echo $i; ?>" style="display: block;">
                        </div>
                        <?php endfor; ?>
                    </div>

                    <div class="divButton-pasarela">
                        <button type="button" class="btn-anterior" onclick="cambiarPasoEdit(3, 2)">Anterior</button>
                        <button type="button" class="ButtonGuardarEdit" id="btnGuardarEditSombreros" onclick="enviarFormularioEdit()">Guardar Cambios</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function enviarFormularioEdit() {
    document.getElementById('form-EditSombrero').dispatchEvent(new Event('submit', { cancelable: true }));
}
</script>