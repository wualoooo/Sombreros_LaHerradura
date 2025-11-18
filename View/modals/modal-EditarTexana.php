<link rel="stylesheet" href="../../css/style-Modal-Edit-Som-Tex.css">

<div class="modal-EditSom" id="modal-EditTexana">
    <div class="modal-content-EditSom">
        <span class="close">&times;</span>
        <h2 id="EditSom-text">Editar Texana</h2> 
        <div class="cont-form-EditSom">
            
            <form class="EditSom" id="form-EditTexana" action="../../Controller/CRUD_Texanas/ActualizarTexana.php" method="POST" enctype="multipart/form-data">
                
                <div id="div-EditSomb">
                    <div id="EditSom-left">

                        <input type="hidden" id="edit-id-Texana" name="id_Texana">

                        <label class="lbl-EditSom" for="NombreTexana">Nombre</label>
                        <br>
                        <input class="input-EditSom" type="text" name="NombreTexana" id="NombreTexana">
                        <br>

                        <label class="lbl-EditSom" for="ColorTexana">Color</label>
                        <br>
                        <input class="input-EditSom" type="text" name="ColorTexana" id="ColorTexana">
                        <br>

                        <label class="lbl-EditSom" for="HormaTexana">Horma</label>
                        <br>
                        <select class="input-EditSom Selects-Edit" name="HormaTexana" id="HormaTexana">
                            <option value="Null">Selecciona una opcion</option>
                            <option value="horma1">horma1</option>
                            <option value="horma2">horma2</option>
                            <option value="horma3">horma3</option>
                            <option value="horma4">horma4</option>
                        </select>
                        <br>

                        <label class="lbl-EditSom" for="CopaTexana">Copa</label> <br>
                        <select class="input-EditSom Selects-Edit" name="CopaTexana" id="CopaTexana">
                            <option value="Null">Selecciona una opcion</option>
                            <option value="copa1">Copa1</option>
                            <option value="copa2">Copa2</option>
                            <option value="copa3">Copa3</option>
                            <option value="copa4">Copa4</option>
                        </select>
                        <br>

                        <label class="lbl-EditSom" for="TamañoCopaTexana">Tamaño copa</label> <br>
                        <input class="input-EditSom" type="text" name="TamañoCopaTexana" id="TamañoCopaTexana">
                        <br>

                        <label class="lbl-EditSom" for="MaterialTexana">Material</label> <br>
                        <input class="input-EditSom" type="text" name="MaterialTexana" id="MaterialTexana">
                        <br>

                        <label class="lbl-EditSom" for="PrecioTexana">Precio</label> <br>
                        <input class="input-EditSom" type="text" name="PrecioTexana" id="PrecioTexana">
                    </div>

                    <div id="EditSom-right">
                        <div class="contenedor-preview">
                
                            <div class="caja-preview">
                                <input type="file" name="imgEditTexana1" id="imgEditTexana1" class="input-img-oculto" accept="image/*">
                                <label for="imgEditTexana1" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditTexana1" class="preview" src="#" alt="Vista previa 1">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgEditTexana2" id="imgEditTexana2" class="input-img-oculto" accept="image/*">
                                <label for="imgEditTexana2" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditTexana2" class="preview" src="#" alt="Vista previa 2">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgEditTexana3" id="imgEditTexana3" class="input-img-oculto" accept="image/*">
                                <label for="imgEditTexana3" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditTexana3" class="preview" src="#" alt="Vista previa 3">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgEditTexana4" id="imgEditTexana4" class="input-img-oculto" accept="image/*">
                                <label for="imgEditTexana4" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditTexana4" class="preview" src="#" alt="Vista previa 4">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="divButton">
                    <input type="submit" id="btnGuardarEditTexanas" value="Guardar Cambios">
                </div>
            </form>
        </div>
    </div>
</div>
