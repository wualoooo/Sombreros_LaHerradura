<link rel="stylesheet" href="../../css/style-Modal-Edit-Som-Tex.css">

<div class="modal-EditSom" id="modal-EditSombrero">
    <div class="modal-content-EditSom">
        <span class="close">&times;</span>
        <h2 id="EditSom-text">Editar Sombrero</h2> 
        
        <div class="cont-form-EditSom">
            <form class="EditSom" id="form-EditSom" action="/LaHerradura/Controller/CRUD_Sombreros/ActualizarSombrero.php" method="POST" enctype="multipart/form-data">
                
                <div id="div-EditSomb">
                    <div id="EditSom-left">

                        <input type="hidden" id="edit-id-sombrero" name="id_sombrero">

                        <label class="lbl-EditSom" for="edit-NombreSombrero">Nombre</label>
                        <br>
                        <input class="input-EditSom" type="text" name="NombreSombrero" id="edit-NombreSombrero" required>
                        <br>

                        <label class="lbl-EditSom" for="edit-ColorSombrero">Color</label>
                        <br>
                        <input class="input-EditSom" type="text" name="ColorSombrero" id="edit-ColorSombrero" required>
                        <br>

                        <label class="lbl-EditSom" for="edit-HormaSombrero">Horma</label>
                        <br>
                        <select class="input-EditSom Selects-Edit" name="HormaSombrero" id="edit-HormaSombrero" required>
                            <option value="Null">Selecciona una opcion</option>
                            <option value="Malboro">Malboro</option>
                            <option value="Malboro copa alta">Malboro copa alta</option>
                            <option value="Malboro copa media/Sinalona">Malboro copa media/Sinalona</option>
                            <option value="Ocho Segundos">Ocho Segundos</option>
                            <option value="Cuernos chuecos">Cuernos chuecos</option>
                            <option value="Chihuahua">Chihuahua</option>
                            <option value="Indiana">Indiana</option>
                            <option value="Joan Sebastian">Joan Sebastian</option>
                            <option value="Patrón">Patrón</option>
                            <option value="Viejón">Viejón</option>
                            <option value="Pedradas de corazón">Pedradas de corazón</option>
                        </select>
                        <br>

                        <label class="lbl-EditSom" for="edit-CopaSombrero">Copa</label> <br>
                        <select class="input-EditSom Selects-Edit" name="CopaSombrero" id="edit-CopaSombrero" required>
                            <option value="Null">Selecciona una opcion</option>
                            <option value="Malboro">Malboro</option>
                            <option value="Malboro copa alta">Malboro copa alta</option>
                            <option value="Malboro copa media/Sinalona">Malboro copa media/Sinalona</option>
                            <option value="Ocho Segundos">Ocho Segundos</option>
                            <option value="Cuernos chuecos">Cuernos chuecos</option>
                            <option value="Chihuahua">Chihuahua</option>
                            <option value="Indiana">Indiana</option>
                            <option value="Joan Sebastian">Joan Sebastian</option>
                            <option value="Patrón">Patrón</option>
                            <option value="Viejón">Viejón</option>
                            <option value="Pedradas de corazón">Pedradas de corazón</option>
                        </select>
                        <br>
                        
                        <div class="inputsTamaños">
                            <div class="inputsTamañosCopa">
                                <label class="lbl-EditSom" for="edit-TamañoCopaSombrero">Tamaño copa</label> <br>
                                <input class="input-EditSom" type="number" step="0.1" name="TamañoCopaSombrero" id="edit-TamañoCopaSombrero" required>   
                            </div>
                            <div class="inputsTamañosAla">
                                <label class="lbl-EditSom" for="edit-TamañoAlaSombrero">Tamaño ala</label> <br>
                                <input class="input-EditSom" type="number" step="0.1" name="TamañoAlaSombrero" id="edit-TamañoAlaSombrero" required>
                            </div>
                        </div>

                        <label class="lbl-EditSom" for="edit-MaterialSombrero">Material</label> <br>
                        <input class="input-EditSom" type="text" name="MaterialSombrero" id="edit-MaterialSombrero" required>
                        <br>

                        <label class="lbl-EditSom" for="edit-PrecioSombrero">Precio</label> <br>
                        <input class="input-EditSom" type="number" step="10" name="PrecioSombrero" id="edit-PrecioSombrero" required>
                    </div>

                    <div id="EditSom-right">
                        <div class="contenedor-preview">
                            
                            <div class="caja-preview">
                                <input type="file" name="imgSombrero1" id="imgEditSombrero1" class="input-img-oculto" accept="image/*">
                                <label for="imgEditSombrero1" class="label-boton">Seleccionar archivo</label>
                                <img id="previewEditSombrero1" class="preview" src="#" alt="Vista previa 1">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgSombrero2" id="imgEditSombrero2" class="input-img-oculto" accept="image/*">
                                <label for="imgEditSombrero2" class="label-boton">Seleccionar archivo</label>
                                <img id="previewEditSombrero2" class="preview" src="#" alt="Vista previa 2">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgSombrero3" id="imgEditSombrero3" class="input-img-oculto" accept="image/*">
                                <label for="imgEditSombrero3" class="label-boton">Seleccionar archivo</label>
                                <img id="previewEditSombrero3" class="preview" src="#" alt="Vista previa 3">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgSombrero4" id="imgEditSombrero4" class="input-img-oculto" accept="image/*">
                                <label for="imgEditSombrero4" class="label-boton">Seleccionar archivo</label>
                                <img id="previewEditSombrero4" class="preview" src="#" alt="Vista previa 4">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="divButton">
                    <input type="submit" id="btnGuardarEditSombreros" value="Guardar Cambios">
                </div>
            </form>
        </div>
    </div>
</div>