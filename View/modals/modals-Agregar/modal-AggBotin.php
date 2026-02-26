<link rel="stylesheet" href="/LaHerradura/View/css/style-ModalAgregar.css">

<?php 
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
}
include_once(ROOT_PATH . 'Model/conexion.php'); 
?>

<div class="modal-Agregar" id="modal-AggBotin">
    <div class="modal-content-Agregar">
        <span class="close">&times;</span>
        <h2 class="Agregar-text">Agregar Botín</h2>
        
        <div class="indicador-pasos">
            <span class="paso-dot active">1</span>
            <span class="paso-dot">2</span>
            <span class="paso-dot">3</span>
        </div>

        <div class="cont-form-Agregar">
            <form class="FormAgregar" id="form-AggBotin" action="/LaHerradura/Controller/CRUD_Botines/registroBotines.php" method="POST" enctype="multipart/form-data">
                
                <div class="pasarela-step active" id="step-1">
                    <h3>Paso 1: Información Básica</h3>

                    <label class="lbl-Agregar" for="SKUBotin">Código del Producto (SKU)</label>
                    <input class="input-Agregar" type="text" name="SKUBotin" id="SKUBotin" placeholder="Ej: BOT-HER-001" required>

                    <label class="lbl-Agregar" for="NombreBotin">Nombre</label>
                    <input class="input-Agregar" type="text" name="NombreBotin" id="NombreBotin" placeholder="Ingresa el nombre completo" required>
                    
                    <label class="lbl-Agregar" for="PrecioBotin">Precio ($)</label>
                    <input class="input-Agregar" type="number" name="PrecioBotin" id="PrecioBotin" placeholder="Ingresa el precio" min="0" step="10" required>
                    
                    <div class="divButton-pasarela">
                        <button type="button" class="btn-siguiente" onclick="cambiarPaso(1, 2)">Siguiente</button>
                    </div>
                </div>

                <div class="pasarela-step" id="step-2" style="display: none;">
                    <h3>Paso 2: Especificaciones y Talla</h3>
                    
                    <label class="lbl-Agregar" for="TallaBotin">Talla</label>
                    <input class="input-Agregar" type="number" name="TallaBotin" id="TallaBotin" placeholder="Ej. 26.5" min="10" step="0.5" max="35" required> 

                    <label class="lbl-Agregar" for="MaterialBotin">Material</label>
                    <select class="input-Agregar Selects-Agg" name="MaterialBotin" id="MaterialBotin" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultMateriales = $conn->query("SELECT id_material, Nombre FROM materiales WHERE Producto = 'Botines'");
                            while ($row = $resultMateriales->fetch_assoc()) echo "<option value='".$row['id_material']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <label class="lbl-Agregar" for="SuelaBotin">Suela</label>
                    <select class="input-Agregar Selects-Agg" name="SuelaBotin" id="SuelaBotin" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultSuelas = $conn->query("SELECT id_material, Nombre FROM materiales WHERE Producto = 'Suelas'");
                            while ($row = $resultSuelas->fetch_assoc()) echo "<option value='".$row['id_material']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

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
                            <input type="file" name="imgBotin<?php echo $i; ?>" id="imgBotin<?php echo $i; ?>" class="input-img-oculto" accept="image/*">
                            <label for="imgBotin<?php echo $i; ?>" class="label-boton">Imagen <?php echo $i; ?></label>
                            <img id="previewBotin<?php echo $i; ?>" class="preview" src="#" alt="Vista previa <?php echo $i; ?>">
                        </div>
                        <?php endfor; ?>
                    </div>

                    <div class="divButton-pasarela">
                        <button type="button" class="btn-anterior" onclick="cambiarPaso(3, 2)">Anterior</button>
                        <button type="button" class="ButtonGuardar" id="btnGuardarAggBotin" onclick="enviarFormularioBotin()">Guardar Botín</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function enviarFormularioBotin() {
    document.getElementById('form-AggBotin').dispatchEvent(new Event('submit', { cancelable: true }));
}
</script>