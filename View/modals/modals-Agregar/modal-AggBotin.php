<link rel="stylesheet" href="/LaHerradura/View/css/style-ModalAgregar.css">

<div class="modal-Agregar" id="modal-AggBotin">
    <div class="modal-content-Agregar">
        <span class="close">&times;</span>
        <h2 class="Agregar-text">Agregar Botin</h2>
        <div class="cont-form-Agregar">
            <form class="FormAgregar" id="form-AggBotin" action="/LaHerradura/Controller/CRUD_Botines/registroBotines.php" method="POST" enctype="multipart/form-data">
                
                <div class="div-Agregar">
                    <div class="Agregar-left AggCinturon-left">
                        
                        <label class="lbl-Agregar" for="NombreBotin">Nombre</label>
                        <br>
                        <input class="input-Agregar" type="text" name="NombreBotin" id="NombreBotin" placeholder="Ingresa el nombre completo">
                        <br>

                        <label class="lbl-Agregar" for="">Talla</label> <br>
                        <input class="input-Agregar" type="number" name="TallaBotin" id="TallaBotin" placeholder="Ingresa la talla" min="10" step="0.5" max="30"> 

                        <label class="lbl-Agregar"  for="Material">Material</label>
                        <br>
                        <select class="input-Agregar Selects-Agg" name="MaterialBotin" id="MaterialBotin">
                            <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                            <?php 
                                include(ROOT_PATH . 'Model/conexion.php') ;

                                $verMateriales = "SELECT id_material, Nombre FROM materiales WHERE Producto = 'Botines'";
                                $resultMateriales = $conn->query($verMateriales);

                                    while ($rowMateriales = $resultMateriales -> fetch_assoc()){
                                        echo "
                                        <option value=".$rowMateriales['id_material'].">".$rowMateriales['Nombre']."</option>
                                        ";
                                    }
                            ?>
                        </select>
                        <br>

                        <label class="lbl-Agregar" for="Suela">Suela</label>
                        <br>
                        <select class="input-Agregar Selects-Agg" name="SuelaBotin" id="SuelaBotin">
                            <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                            <?php 
                                include(ROOT_PATH . 'Model/conexion.php') ;

                                $verMateriales = "SELECT id_material, Nombre FROM materiales WHERE Producto = 'Suelas'";
                                $resultMateriales = $conn->query($verMateriales);

                                    while ($rowMateriales = $resultMateriales -> fetch_assoc()){
                                        echo "
                                        <option value=".$rowMateriales['id_material'].">".$rowMateriales['Nombre']."</option>
                                        ";
                                    }
                            ?>
                        </select>
                        <br>
                        
                        <label class="lbl-Agregar"for="PrecioBotin">Precio</label>
                        <br>
                        <input class="input-Agregar" type="number" name="PrecioBotin" id="PrecioBotin" placeholder="Ingresa el precio" min="0" step="10" max="5000">

                    </div>

                    <div class="Agregar-right">
                        <div class="contenedor-preview">
            
                            <div class="caja-preview">
                                <input type="file" name="imgBotin1" id="imgBotin1" class="input-img-oculto" accept="image/*">
                                <label for="imgBotin1" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewBotin1" class="preview" src="#" alt="Vista previa 1">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgBotin2" id="imgBotin2" class="input-img-oculto" accept="image/*">
                                <label for="imgBotin2" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewBotin2" class="preview" src="#" alt="Vista previa 2">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgBotin3" id="imgBotin3" class="input-img-oculto" accept="image/*">
                                <label for="imgBotin3" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewBotin3" class="preview" src="#" alt="Vista previa 3">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgBotin4" id="imgBotin4" class="input-img-oculto" accept="image/*">
                                <label for="imgBotin4" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewBotin4" class="preview" src="#" alt="Vista previa 4">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divButton">
                    <input type="submit" class="ButtonGuardar" id="btnGuardarAggBotin" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>
