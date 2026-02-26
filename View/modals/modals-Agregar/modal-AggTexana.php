<link rel="stylesheet" href="/LaHerradura/View/css/style-ModalAgregar.css">

<?php 
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
}
include_once(ROOT_PATH . 'Model/conexion.php'); 
?>

<div class="modal-Agregar" id="modal-AggTexana">
    <div class="modal-content-Agregar">
        <span class="close">&times;</span>
        <h2 class="Agregar-text">Agregar Texana</h2>
        
        <div class="indicador-pasos">
            <span class="paso-dot active">1</span>
            <span class="paso-dot">2</span>
            <span class="paso-dot">3</span>
        </div>

        <div class="cont-form-Agregar">
            <form class="formAgregar" id="form-AggTexana" action="/LaHerradura/Controller/CRUD_Texanas/registroTexanas.php" method="POST" enctype="multipart/form-data">
                
                <div class="pasarela-step active" id="step-1">
                    <h3>Paso 1: Información Básica</h3>
                    
                    <label class="lbl-Agregar" for="SKUTexana">Código del Producto (SKU)</label>
                    <input class="input-Agregar" type="text" name="SKUTexana" id="SKUTexana" readonly style="background-color: #e9ecef; cursor: not-allowed;">

                    <label class="lbl-Agregar" for="NombreTexana">Nombre</label>
                    <input class="input-Agregar" type="text" name="NombreTexana" id="NombreTexana" placeholder="Ingresa el nombre completo" required>
                    
                    <label class="lbl-Agregar" for="ColorTexana">Color</label>
                    <select class="input-Agregar Selects-Agregar" name="ColorTexana" id="ColorTexana" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $verColores = "SELECT id_color, Nombre FROM colores WHERE Producto = 'Texanas'";
                            $resultColores = $conn->query($verColores);
                            while ($rowColores = $resultColores->fetch_assoc()) echo "<option value='".$rowColores['id_color']."'>".$rowColores['Nombre']."</option>";
                        ?>
                    </select>

                    <label class="lbl-Agregar" for="PrecioTexana">Precio ($)</label>
                    <input class="input-Agregar" type="number" name="PrecioTexana" id="PrecioTexana" placeholder="Ingresa el precio" step="10" required min="0">
                    
                    <div class="divButton-pasarela">
                        <button type="button" class="btn-siguiente" onclick="cambiarPaso(1, 2)">Siguiente</button>
                    </div>
                </div>

                <div class="pasarela-step" id="step-2" style="display: none;">
                    <h3>Paso 2: Especificaciones y Tallas</h3>
                    
                    <label class="lbl-Agregar" for="HormaTexana">Horma</label>
                    <select class="input-Agregar Selects-Agregar" name="HormaTexana" id="HormaTexana" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resulthormas = $conn->query("SELECT id_horma, Nombre FROM hormas");
                            while ($rowhormas = $resulthormas->fetch_assoc()) echo "<option value='".$rowhormas['id_horma']."'>".$rowhormas['Nombre']."</option>";
                        ?>
                    </select>

                    <label class="lbl-Agregar" for="CopaTexana">Copa</label>
                    <select class="input-Agregar Selects-Agregar" name="CopaTexana" id="CopaTexana" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultcopas = $conn->query("SELECT id_copa, Nombre FROM copas");
                            while ($rowcopas = $resultcopas->fetch_assoc()) echo "<option value='".$rowcopas['id_copa']."'>".$rowcopas['Nombre']."</option>";
                        ?>
                    </select>

                    <div class="inputsTamaños">
                        <div class="inputsTamañosCopa">
                            <label class="lbl-Agregar" for="TamañoCopaTexana">Tamaño copa</label>
                            <input class="input-Agregar" type="number" name="TamañoCopaTexana" id="TamañoCopaTexana" step="0.5" min="8" required>   
                        </div>
                        <div class="inputsTamañosAla">
                            <label class="lbl-Agregar" for="TamañoAlaTexana">Tamaño ala</label>
                            <input class="input-Agregar" type="number" name="TamañoAlaTexana" id="TamañoAlaTexana" step="0.5" min="8" required>
                        </div>
                    </div>

                    <label class="lbl-Agregar" for="MaterialTexana">Material</label>
                    <select class="input-Agregar Selects-Agregar" name="MaterialTexana" id="MaterialTexana" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultMateriales = $conn->query("SELECT id_material, Nombre FROM materiales WHERE Producto = 'Texanas'");
                            while ($rowMateriales = $resultMateriales->fetch_assoc()) echo "<option value='".$rowMateriales['id_material']."'>".$rowMateriales['Nombre']."</option>";
                        ?>
                    </select>

                    <hr style="border: 0; border-top: 1px solid #ddd; margin: 20px 0;">

                    <label class="lbl-Agregar">Tallas Disponibles</label>
                    <p style="font-size: 0.9rem; color: #666; margin-bottom: 10px;">Selecciona todas las tallas que tienes en existencia para este modelo:</p>
                    
                    <div class="contenedor-tallas">
                        <?php
                        $tallas_comunes = ['53', '54', '55', '56', '57', '58', '59', '60', '61'];
                        foreach($tallas_comunes as $talla) {
                            echo "
                            <label class='talla-checkbox'>
                                <input type='checkbox' name='tallas_disponibles[]' value='$talla'>
                                <span class='talla-btn'>$talla</span>
                            </label>";
                        }
                        ?>
                    </div>

                    <div class="divButton-pasarela">
                        <button type="button" class="btn-anterior" onclick="cambiarPaso(2, 1)">Anterior</button>
                        <button type="button" class="btn-siguiente" onclick="cambiarPaso(2, 3)">Siguiente</button>
                    </div>
                </div>

                <div class="pasarela-step" id="step-3" style="display: none;">
                    <h3>Paso 3: Fotografías del Producto</h3>
                    <div class="contenedor-preview" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                        <?php for($i=1; $i<=4; $i++): ?>
                        <div class="caja-preview">
                            <input type="file" name="imgTexana<?php echo $i; ?>" id="imgTexana<?php echo $i; ?>" class="input-img-oculto" accept="image/*">
                            <label for="imgTexana<?php echo $i; ?>" class="label-boton">Imagen <?php echo $i; ?></label>
                            <img id="previewTexana<?php echo $i; ?>" class="preview" src="#" alt="Vista previa <?php echo $i; ?>">
                        </div>
                        <?php endfor; ?>
                    </div>

                    <div class="divButton-pasarela">
                        <button type="button" class="btn-anterior" onclick="cambiarPaso(3, 2)">Anterior</button>
                        <button type="submit" class="ButtonGuardar" id="btnGuardarAggTexana">Guardar Texana</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>