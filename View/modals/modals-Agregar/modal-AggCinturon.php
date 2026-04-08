<link rel="stylesheet" href="/LaHerradura/View/css/style-ModalAgregar.css">

<?php 
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
}
include_once(ROOT_PATH . 'Model/conexion.php'); 
?>

<div class="modal-Agregar" id="modal-AggCinturon">
    <div class="modal-content-Agregar">
        <span class="close">&times;</span>
        <h2 class="Agregar-text">Agregar Cinturón</h2>
        
        <div class="indicador-pasos">
            <span class="paso-dot active">1</span>
            <span class="paso-dot">2</span>
            <span class="paso-dot">3</span>
        </div>

        <div class="cont-form-Agregar">
            <form class="formAgregar" id="form-AggCinturon" action="/LaHerradura/Controller/CRUD_Cinturones/registroCinturones.php" method="POST" enctype="multipart/form-data">
                
                <div class="pasarela-step active" id="step-1">
                    
                    <label class="lbl-Agregar" for="SKUCinturon">Código del Producto (SKU)</label>
                    <input class="input-Agregar" type="text" name="SKUCinturon" id="SKUCinturon" placeholder="Ej: CIN-HER-001" required>

                    <label class="lbl-Agregar" for="NombreCinturon">Nombre</label>
                    <input class="input-Agregar" type="text" name="NombreCinturon" id="NombreCinturon" placeholder="Ingresa el nombre completo" required>
                    
                    <label class="lbl-Agregar" for="PrecioCinturon">Precio ($)</label>
                    <input class="input-Agregar" type="number" name="PrecioCinturon" id="PrecioCinturon" placeholder="Ingresa el precio" min="0" step="10" required>
                    
                    <div class="divButton-pasarela">
                        <button type="button" class="btn-siguiente" onclick="cambiarPaso(1, 2)">Siguiente</button>
                    </div>
                </div>

                <div class="pasarela-step" id="step-2" style="display: none;">
                    
                    <label class="lbl-Agregar" for="MaterialCinturon">Material</label>
                    <select class="input-Agregar Selects-Agregar" name="MaterialCinturon" id="MaterialCinturon" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultMateriales = $conn->query("SELECT id_material, Nombre FROM materiales WHERE Producto = 'Cinturones'");
                            while ($row = $resultMateriales->fetch_assoc()) echo "<option value='".$row['id_material']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <label class="lbl-Agregar" for="AdornoCinturon">Adorno</label>
                    <select class="input-Agregar Selects-Agregar" name="AdornoCinturon" id="AdornoCinturon" required>
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultAdornos = $conn->query("SELECT id_material, Nombre FROM materiales WHERE Producto = 'Adornos'");
                            while ($row = $resultAdornos->fetch_assoc()) echo "<option value='".$row['id_material']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <label class="lbl-Agregar" for="TamañoCinturon">Ancho/Grosor (Opcional)</label>
                    <input class="input-Agregar" type="number" name="TamañoCinturon" id="TamañoCinturon" placeholder="Ej: 3.5" step="0.5">   

                    <hr style="border: 0; border-top: 1px solid #ddd; margin: 20px 0;">

                    <label class="lbl-Agregar">Tallas y Cantidad (Stock)</label>

                        <div class="contenedor-tallas" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                            <?php
                            $tallas_comunes = ['53', '54', '55', '56', '57', '58', '59', '60', '61'];
                            foreach($tallas_comunes as $talla) {
                                echo "
                                <div class='item-talla' style='border: 1px solid #ccc; padding: 10px; border-radius: 6px; background-color: #f9f9f9;'>
                                    <label style='display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: bold;'>
                                        <input type='checkbox' class='check-talla' name='tallas_disponibles[]' value='$talla' onchange='toggleStock(this)'>
                                        Talla $talla
                                    </label>
                                    <div class='input-stock-container' style='display: none; margin-top: 10px;'>
                                        <input type='number' name='stock_talla[$talla]' class='input-Agregar input-stock' placeholder='Cantidad' min='1' disabled style='width: 100%; padding: 5px; box-sizing: border-box;'>
                                    </div>
                                </div>";
                            }
                            ?>
                        </div>

                        <script>
                            function toggleStock(checkbox) {
                                const container = checkbox.closest('.item-talla').querySelector('.input-stock-container');
                                const input = container.querySelector('input');
                                
                                if (checkbox.checked) {
                                    container.style.display = 'block';
                                    input.disabled = false; // Lo habilitamos para que se envíe por POST
                                    input.focus();
                                } else {
                                    container.style.display = 'none';
                                    input.disabled = true; // Lo deshabilitamos para que PHP lo ignore
                                    input.value = ''; // Limpiamos si se arrepintió
                                }
                            }
                        </script>

                    <div class="divButton-pasarela">
                        <button type="button" class="btn-anterior" onclick="cambiarPaso(2, 1)">Anterior</button>
                        <button type="button" class="btn-siguiente" onclick="cambiarPaso(2, 3)">Siguiente</button>
                    </div>
                </div>

                <div class="pasarela-step" id="step-3" style="display: none;">
                    <div class="contenedor-preview" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                        <?php for($i=1; $i<=4; $i++): ?>
                        <div class="caja-preview">
                            <input type="file" name="imgCinturon<?php echo $i; ?>" id="imgCinturon<?php echo $i; ?>" class="input-img-oculto" accept="image/*">
                            <label for="imgCinturon<?php echo $i; ?>" class="label-boton">Imagen <?php echo $i; ?></label>
                            <img id="previewCinturon<?php echo $i; ?>" class="preview" src="#" alt="Vista previa <?php echo $i; ?>">
                        </div>
                        <?php endfor; ?>
                    </div>

                    <div class="divButton-pasarela">
                        <button type="button" class="btn-anterior" onclick="cambiarPaso(3, 2)">Anterior</button>
                        <button type="submit" class="ButtonGuardar" id="btnGuardarAggCinturon">Guardar Cinturón</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>