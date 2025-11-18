<link rel="stylesheet" href="/LaHerradura/View/css/style-Modal-Edit-Som-Tex.css">

<div class="modal-EditSom" id="modal-EditBotin">
    <div class="modal-content-EditSom">
        <span class="close">&times;</span>
        <h2 id="EditSom-text">Editar Botin</h2> <div class="cont-form-EditSom">
            
            <form class="EditSom" id="form-EditBotin" action="/LaHerradura/Controller/CRUD_Botines/ActualizarBotin.php" method="POST" enctype="multipart/form-data">
                
                <div id="div-EditCinturon">
                    <div id="EditCinturon-left">
                        
                        <input type="hidden" id="edit-id-botin" name="id_botin">

                        <label class="lbl-EditSom" for="NombreBotin">Nombre</label>
                        <br>
                        <input class="input-EditSom" type="text" name="NombreBotin" id="NombreBotin" placeholder="Ingresa el nombre completo">
                        <br>

                        <label class="lbl-EditSom" for="">Talla</label> <br>
                        <input class="input-EditSom" type="text" name="TallaBotin" id="TallaBotin" placeholder="(Numeros)">

                        <label class="lbl-EditSom"  for="">Material</label>
                        <br>
                        <select class="input-EditSom Selects-Edit" name="MaterialBotin" id="MaterialBotin">
                            <option value="Null">Selecciona una opcion</option>
                            <option value="Piel">Piel</option>
                            <option value="Gamuza">Gamuza</option>
                        </select>
                        <br>

                        <label class="lbl-EditSom" for="Suela">Suela</label>
                        <br>
                        <select class="input-EditSom Selects-Edit" name="SuelaBotin" id="SuelaBotin">
                            <option value="Null">Selecciona una opcion</option>
                            <option value="Hule con cerco">Hule con cerco</option>
                            <option value="Hule sin cerco">Hule sin cerco</option>
                            <option value="Piel">Piel</option>
                            <option value="Doble suela">Doble suela</option>
                            <option value="Cuadros">Cuadros</option>
                            <option value="Tractor">Tractor</option>
                        </select>
                        <br>
                        
                        <label class="lbl-EditSom"for="">Precio</label>
                        <br>
                        <input class="input-EditSom" type="text" name="PrecioBotin" id="PrecioBotin" placeholder="Solo numeros     Ej: 500">
                        <br>

                    </div>

                    <div id="EditSom-right">
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
                <div id="divButton">
                    <input type="submit" id="btnGuardarEditBotin" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>
