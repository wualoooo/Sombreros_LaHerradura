<link rel="stylesheet" href="/LaHerradura/View/css/style-ModalEdit.css">

<div class="modal-Edit" id="modal-EditCinturon">
    <div class="modal-content-Edit">
        <span class="close">&times;</span>
        <h2 class="Edit-text">Editar Cinturon</h2> 
        
        <div class="cont-form-Edit">
            <form class="EditSom" id="form-EditCinturon" action="/LaHerradura/Controller/CRUD_Cinturones/ActualizarCinturon.php" method="POST" enctype="multipart/form-data">
                
                <div class="div-Edit div-EditCinturon">
                    <div class="Edit-left EditCinturon-left">
                        
                        <input type="hidden" id="edit-id-cinturon" name="id_cinturon">

                        <label class="lbl-Edit" for="NombreCinturon">Nombre</label>
                        <br>
                        <input class="input-Edit" type="text" name="NombreCinturon" id="edit-NombreCinturon" placeholder="Ingresa el nombre completo">
                        <br>

                        <label class="lbl-Edit"for="">Precio</label>
                        <br>
                        <input class="input-Edit" type="number" name="PrecioCinturon" id="edit-PrecioCinturon" placeholder="Ingresa el precio" min="0" step="10" max="2000">

                        <label class="lbl-Edit"  for="">Material</label>
                        <br>
                        <select class="input-Edit Selects-Edit" name="MaterialCinturon" id="edit-MaterialCinturon" placeholder="Ingresa el material">
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

                        <label class="lbl-Edit" for="Adorno">Adorno:</label>
                        <br>
                        <select class="input-Edit Selects-Edit" name="AdornoCinturon" id="edit-AdornoCinturon">
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

                        <label class="lbl-Edit" for="">Tamaño</label> <br>
                        <input class="input-Edit" type="number" name="TamañoCinturon" id="edit-TamañoCinturon" placeholder="Ingresa la talla" min="30" step="0.5" max="120">   

                    </div>

                    <div id="Edit-right">
                        <div class="contenedor-preview">
            
                            <div class="caja-preview">
                                <input type="file" name="imgCinturon1" id="imgEditCinturon1" class="input-img-oculto" accept="image/*">
                                <label for="imgEditCinturon1" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditCinturon1" class="preview" src="#" alt="Vista previa 1">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgCinturon2" id="imgEditCinturon2" class="input-img-oculto" accept="image/*">
                                <label for="imgEditCinturon2" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditCinturon2" class="preview" src="#" alt="Vista previa 2">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgCinturon3" id="imgEditCinturon3" class="input-img-oculto" accept="image/*">
                                <label for="imgEditCinturon3" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditCinturon3" class="preview" src="#" alt="Vista previa 3">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgCinturon4" id="imgEditCinturon4" class="input-img-oculto" accept="image/*">
                                <label for="imgEditCinturon4" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditCinturon4" class="preview" src="#" alt="Vista previa 4">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divButton">
                    <input type="submit" class="ButtonGuardarEdit" id="btnGuardarEditCinturon" value="Guardar cambios">
                </div>
            </form>
        </div>
    </div>
</div>
