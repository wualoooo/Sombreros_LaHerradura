<link rel="stylesheet" href="../css/style-EditSombrero.css">

<div class="modal-EditSom" id="modal-EditSombrero">
    <div class="modal-content-EditSom">
        <span class="close">&times;</span>
        <h2 id="EditSom-text">Editar Sombrero</h2> <div class="cont-form-EditSom">
            
            <form class="EditSom" id="form-EditSom" action="../../Controller/CRUD_Sombreros/ActualizarSombrero.php" method="POST" enctype="multipart/form-data">
                
                <div id="div-EditSomb">
                    <div id="EditSom-left">

                        <input type="hidden" id="edit-id-sombrero" name="id_sombrero">

                        <label class="lbl-EditSom" for="NombreSombrero">Nombre</label>
                        <br>
                        <input class="input-EditSom" type="text" name="NombreSombrero" id="NombreSombrero">
                        <br>

                        <label class="lbl-EditSom" for="ColorSombrero">Color</label>
                        <br>
                        <input class="input-EditSom" type="text" name="ColorSombrero" id="ColorSombrero">
                        <br>

                        <label class="lbl-EditSom" for="HormaSombrero">Horma</label>
                        <br>
                        <select class="input-EditSom Selects-Edit" name="HormaSombrero" id="HormaSombrero">
                            <option value="Null">Selecciona una opcion</option>
                            <option value="horma1">horma1</option>
                            <option value="horma2">horma2</option>
                            <option value="horma3">horma3</option>
                            <option value="horma4">horma4</option>
                        </select>
                        <br>

                        <label class="lbl-EditSom" for="CopaSombrero">Copa</label> <br>
                        <select class="input-EditSom Selects-Edit" name="CopaSombrero" id="CopaSombrero">
                            <option value="Null">Selecciona una opcion</option>
                            <option value="copa1">Copa1</option>
                            <option value="copa2">Copa2</option>
                            <option value="copa3">Copa3</option>
                            <option value="copa4">Copa4</option>
                        </select>
                        <br>

                        <label class="lbl-EditSom" for="TamañoCopaSombrero">Tamaño copa</label> <br>
                        <input class="input-EditSom" type="text" name="TamañoCopaSombrero" id="TamañoCopaSombrero">
                        <br>

                        <label class="lbl-EditSom" for="MaterialSombrero">Material</label> <br>
                        <input class="input-EditSom" type="text" name="MaterialSombrero" id="MaterialSombrero">
                        <br>

                        <label class="lbl-EditSom" for="PrecioSombrero">Precio</label> <br>
                        <input class="input-EditSom" type="text" name="PrecioSombrero" id="PrecioSombrero">
                    </div>

                    <div id="EditSom-right">
                        <div class="contenedor-preview">
                
                            <div class="caja-preview">
                                <input type="file" name="imgEditSombrero1" id="imgEditSombrero1" class="input-img-oculto" accept="image/*">
                                <label for="imgEditSombrero1" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditSombrero1" class="preview" src="#" alt="Vista previa 1">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgEditSombrero2" id="imgEditSombrero2" class="input-img-oculto" accept="image/*">
                                <label for="imgEditSombrero2" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditSombrero2" class="preview" src="#" alt="Vista previa 2">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgEditSombrero3" id="imgEditSombrero3" class="input-img-oculto" accept="image/*">
                                <label for="imgEditSombrero3" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditSombrero3" class="preview" src="#" alt="Vista previa 3">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgEditSombrero4" id="imgEditSombrero4" class="input-img-oculto" accept="image/*">
                                <label for="imgEditSombrero4" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditSombrero4" class="preview" src="#" alt="Vista previa 4">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="divButton">
                    <input type="submit" id="btnGuardarEdit" value="Guardar Cambios">
                </div>
            </form>
        </div>
    </div>
</div>
