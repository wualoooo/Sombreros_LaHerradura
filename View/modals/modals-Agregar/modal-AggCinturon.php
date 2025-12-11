<link rel="stylesheet" href="/LaHerradura/View/css/style-ModalAgregar.css">

<div class="modal-Agregar" id="modal-AggCinturon">
    <div class="modal-content-Agregar">
        <span class="close">&times;</span>
        <h2 class="Agregar-text">Agregar Cinturon</h2>
        <div class="cont-form-Agregar">
            <form class="formAgregar" id="form-AggCinturon" action="/LaHerradura/Controller/CRUD_Cinturones/registroCinturones.php" method="POST" enctype="multipart/form-data">
                
                <div class="div-Agregar div-AggCinturon">
                    <div class="Agregar-left AggCinturon-left">
                        
                        <label class="lbl-Agregar" for="NombreCinturon">Nombre</label>
                        <br>
                        <input class="input-Agregar" type="text" name="NombreCinturon" id="NombreCinturon" placeholder="Ingresa el nombre completo">
                        <br>

                        <label class="lbl-Agregar"for="">Precio</label>
                        <br>
                        <input class="input-Agregar" type="number" name="PrecioCinturon" id="PrecioCinturon" placeholder="Ingresa el precio" min="0" step="10" max="2000">

                        <label class="lbl-Agregar"  for="">Material</label>
                        <br>
                        <select class="input-Agregar Selects-Agregar" name="MaterialCinturon" id="MaterialCinturon" placeholder="Ingresa el material">
                            <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                            <?php 
                                include(ROOT_PATH . 'Model/conexion.php') ;

                                $verMateriales = "SELECT id_material, Nombre FROM materiales WHERE Producto = 'Cinturones'";
                                $resultMateriales = $conn->query($verMateriales);

                                    while ($rowMateriales = $resultMateriales -> fetch_assoc()){
                                        echo "
                                        <option value=".$rowMateriales['id_material'].">".$rowMateriales['Nombre']."</option>
                                        ";
                                    }
                            ?>
                        </select>
                        <br>

                        <label class="lbl-Agregar" for="Adorno">Adorno:</label>
                        <br>
                        <select class="input-Agregar Selects-Agregar" name="AdornoCinturon" id="AdornoCinturon">
                            <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                            <?php 
                                include(ROOT_PATH . 'Model/conexion.php') ;

                                $verMateriales = "SELECT id_material, Nombre FROM materiales WHERE Producto = 'Adornos'";
                                $resultMateriales = $conn->query($verMateriales);

                                    while ($rowMateriales = $resultMateriales -> fetch_assoc()){
                                        echo "
                                        <option value=".$rowMateriales['id_material'].">".$rowMateriales['Nombre']."</option>
                                        ";
                                    }
                            ?>
                        </select>
                        <br>

                        <label class="lbl-Agregar" for="">Tamaño</label> <br>
                        <input class="input-Agregar" type="number" name="TamañoCinturon" id="TamañoCinturon" placeholder="Ingresa el tamaño" min="30" step="0.5" max="120">   

                    </div>

                    <div class="Agregar-right">
                        <div class="contenedor-preview">
            
                            <div class="caja-preview">
                                <input type="file" name="imgCinturon1" id="imgCinturon1" class="input-img-oculto" accept="image/*">
                                <label for="imgCinturon1" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewCinturon1" class="preview" src="#" alt="Vista previa 1">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgCinturon2" id="imgCinturon2" class="input-img-oculto" accept="image/*">
                                <label for="imgCinturon2" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewCinturon2" class="preview" src="#" alt="Vista previa 2">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgCinturon3" id="imgCinturon3" class="input-img-oculto" accept="image/*">
                                <label for="imgCinturon3" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewCinturon3" class="preview" src="#" alt="Vista previa 3">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgCinturon4" id="imgCinturon4" class="input-img-oculto" accept="image/*">
                                <label for="imgCinturon4" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewCinturon4" class="preview" src="#" alt="Vista previa 4">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divButton">
                    <input type="submit" class="ButtonGuardar" id="btnGuardarAggCinturon" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>
