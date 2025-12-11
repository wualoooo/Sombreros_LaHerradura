<link rel="stylesheet" href="/LaHerradura/View/css/style-ModalEdit.css">

<div class="modal-Edit" id="modal-EditBotin">
    <div class="modal-content-Edit">
        <span class="close">&times;</span>
        <h2 class="Edit-text">Editar Botin</h2> 

        <div class="cont-form-Edit">
            <form class="Edit" id="form-EditBotin" action="/LaHerradura/Controller/CRUD_Botines/ActualizarBotin.php" method="POST" enctype="multipart/form-data">
                
                <div class="div-Edit div-EditCinturon">
                    <div class="Edit-left EditCinturon-left">
                        
                        <input type="hidden" id="edit-id-botin" name="id_botin">

                        <label class="lbl-Edit" for="NombreBotin">Nombre</label>
                        <br>
                        <input class="input-Edit" type="text" name="NombreBotin" id="edit-NombreBotin" placeholder="Ingresa el nombre completo">
                        <br>

                        <label class="lbl-Edit" for="">Talla</label> <br>
                        <input class="input-Edit" type="text" name="TallaBotin" id="edit-TallaBotin" placeholder="(Numeros)">

                        <label class="lbl-Edit"  for="">Material</label>
                        <br>
                        <select class="input-Edit Selects-Edit" name="MaterialBotin" id="edit-MaterialBotin">
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

                        <label class="lbl-Edit" for="Suela">Suela</label>
                        <br>
                        <select class="input-Edit Selects-Edit" name="SuelaBotin" id="edit-SuelaBotin">
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
                        
                        <label class="lbl-Edit"for="">Precio</label>
                        <br>
                        <input class="input-Edit" type="text" name="PrecioBotin" id="edit-PrecioBotin" placeholder="Solo numeros     Ej: 500">
                        <br>

                    </div>

                    <div class="Edit-right">
                        <div class="contenedor-preview">
            
                            <div class="caja-preview">
                                <input type="file" name="imgEditBotin1" id="imgEditBotin1" class="input-img-oculto" accept="image/*">
                                <label for="imgEditBotin1" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditBotin1" class="preview" src="#" alt="Vista previa 1">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgEditBotin2" id="imgEditBotin2" class="input-img-oculto" accept="image/*">
                                <label for="imgEditBotin2" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditBotin2" class="preview" src="#" alt="Vista previa 2">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgEditBotin3" id="imgEditBotin3" class="input-img-oculto" accept="image/*">
                                <label for="imgEditBotin3" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditBotin3" class="preview" src="#" alt="Vista previa 3">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgEditBotin4" id="imgEditBotin4" class="input-img-oculto" accept="image/*">
                                <label for="imgEditBotin4" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditBotin4" class="preview" src="#" alt="Vista previa 4">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divButton">
                    <input type="submit" class="ButtonGuardarEdit" id="btnGuardarEditBotin" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>
