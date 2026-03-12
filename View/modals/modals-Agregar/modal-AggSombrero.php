<link rel="stylesheet" href="/LaHerradura/View/css/style-ModalAgregar.css">

<?php 
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
}
include_once(ROOT_PATH . 'Model/conexion.php'); 
?>

<div class="modal-Agregar" id="modal-AggSombrero">
    <div class="modal-content-Agregar">
        <span class="close">&times;</span>
        <h2 class="Agregar-text">Agregar Sombrero</h2>
        
        <div class="indicador-pasos">
            <span class="paso-dot active">1</span>
            <span class="paso-dot">2</span>
            <span class="paso-dot">3</span>
        </div>

        <div class="cont-form-Agregar">
            <form class="formAgregar" id="form-AggSombrero" action="/LaHerradura/Controller/CRUD_Sombreros/registroSombreros.php" method="POST" enctype="multipart/form-data">
                
                <div class="pasarela-step active" id="step-1">

                    <label class="lbl-Agregar" for="SKUSombrero">Código del Producto (SKU)</label>
                    <input class="input-Agregar" type="text" name="SKUSombrero" id="SKUSombrero" readonly style="background-color: #e9ecef; cursor: not-allowed;">

                    <label class="lbl-Agregar" for="NombreSombrero">Nombre</label>
                    <input class="input-Agregar" type="text" name="NombreSombrero" id="NombreSombrero" placeholder="Ingresa el nombre completo" required>
                    
                    <label class="lbl-Agregar" for="ColorSombrero">Color</label>
                    <select class="input-Agregar Selects-Agg" name="ColorSombrero" id="ColorSombrero">
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $verColores = "SELECT id_color, Nombre FROM colores WHERE Producto = 'Sombreros'";
                            $resultColores = $conn->query($verColores);
                            while ($row = $resultColores->fetch_assoc()) echo "<option value='".$row['id_color']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <label class="lbl-Agregar" for="PrecioSombrero">Precio ($)</label>
                    <input class="input-Agregar" type="number" name="PrecioSombrero" id="PrecioSombrero" placeholder="Ingresa el precio" step="10" required min="0">
                    
                    <div class="divButton-pasarela">
                        <button type="button" class="btn-siguiente" onclick="cambiarPaso(1, 2)">Siguiente</button>
                    </div>
                </div>

                <div class="pasarela-step" id="step-2" style="display: none;">
                    
                    <label class="lbl-Agregar" for="HormaSombrero">Horma</label>
                    <select class="input-Agregar Selects-Agregar" name="HormaSombrero" id="HormaSombrero">
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resulthormas = $conn->query("SELECT id_horma, Nombre FROM hormas");
                            while ($row = $resulthormas->fetch_assoc()) echo "<option value='".$row['id_horma']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <label class="lbl-Agregar" for="CopaSombrero">Copa</label>
                    <select class="input-Agregar Selects-Agregar" name="CopaSombrero" id="CopaSombrero">
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultcopas = $conn->query("SELECT id_copa, Nombre FROM copas");
                            while ($row = $resultcopas->fetch_assoc()) echo "<option value='".$row['id_copa']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <div class="inputsTamaños">
                        <div class="inputsTamañosCopa">
                            <label class="lbl-Agregar" for="TamañoCopaSombrero">Tamaño copa</label>
                            <input class="input-Agregar" type="number" name="TamañoCopaSombrero" id="TamañoCopaSombrero" step="0.5" min="8">   
                        </div>
                        <div class="inputsTamañosAla">
                            <label class="lbl-Agregar" for="TamañoAlaSombrero">Tamaño ala</label>
                            <input class="input-Agregar" type="number" name="TamañoAlaSombrero" id="TamañoAlaSombrero" step="0.5" min="8">
                        </div>
                    </div>

                    <label class="lbl-Agregar" for="MaterialSombrero">Material</label>
                    <select class="input-Agregar Selects-Agregar" name="MaterialSombrero" id="MaterialSombrero">
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <?php 
                            $resultMateriales = $conn->query("SELECT id_material, Nombre FROM materiales WHERE Producto = 'Sombreros'");
                            while ($row = $resultMateriales->fetch_assoc()) echo "<option value='".$row['id_material']."'>".$row['Nombre']."</option>";
                        ?>
                    </select>

                    <label class="lbl-Agregar">Tallas Disponibles</label>
                    
                    <div class="contenedor-tallas">
                        <?php
                        // Puedes generar esto con un ciclo o traerlo de una tabla 'tallas' en la BD
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
                    <div class="contenedor-preview" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                        <?php for($i=1; $i<=4; $i++): ?>
                        <div class="caja-preview">
                            <input type="file" name="imgSombrero<?php echo $i; ?>" id="imgSombrero<?php echo $i; ?>" class="input-img-oculto" accept="image/*">
                            <label for="imgSombrero<?php echo $i; ?>" class="label-boton">Imagen <?php echo $i; ?></label>
                            <img id="previewSombrero<?php echo $i; ?>" class="preview" src="#" alt="Vista previa <?php echo $i; ?>">
                        </div>
                        <?php endfor; ?>
                    </div>

                    <div class="divButton-pasarela">
                        <button type="button" class="btn-anterior" onclick="cambiarPaso(3, 2)">Anterior</button>
                        <button type="submit" class="ButtonGuardar" id="btnGuardarAggSombrero">Guardar Sombrero</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>