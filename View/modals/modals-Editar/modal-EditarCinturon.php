<link rel="stylesheet" href="../../css/style-Modal-Edit-Som-Tex.css">

<div class="modal-EditSom" id="modal-EditCinturon">
    <div class="modal-content-EditSom">
        <span class="close">&times;</span>
        <h2 id="EditSom-text">Editar Cinturon</h2> <div class="cont-form-EditSom">
            
            <form class="EditSom" id="form-EditCinturon" action="../../../Controller/CRUD_Cinturones/ActualizarCinturon.php" method="POST" enctype="multipart/form-data">
                
                <div id="div-EditCinturon">
                    <div id="EditCinturon-left">
                        
                        <input type="hidden" id="edit-id-cinturon" name="id_cinturon">

                        <label class="lbl-EditSom" for="NombreCinturon">Nombre</label>
                        <br>
                        <input class="input-EditSom" type="text" name="NombreCinturon" id="NombreCinturon" placeholder="Ingresa el nombre completo">
                        <br>

                        <label class="lbl-EditSom"for="">Precio</label>
                        <br>
                        <input class="input-EditSom" type="text" name="PrecioCinturon" id="PrecioCinturon" placeholder="Solo numeros     Ej: 500">
                        <br>

                        <label class="lbl-EditSom"  for="">Material</label>
                        <br>
                        <input class="input-EditSom" type="text" name="MaterialCinturon" id="MaterialCinturon" placeholder="Ingresa el material">
                        <br>

                        <label class="lbl-EditSom" for="Adorno">Adorno:</label>
                        <br>
                        <select class="input-EditSom Selects-Edit" name="AdornoCinturon" id="AdornoCinturon">
                            <option value="Null">Selecciona una opcion</option>
                            <option value="Hilo">Hilo</option>
                            <option value="Pita">Pita</option>
                            <option value="Plata">Plata</option>
                            <option value="Cincelado">Cincelado</option>
                            <option value="Herraje">Herraje</option>
                            <option value="Laser">Laser</option>
                        </select>
                        <br>

                        <label class="lbl-EditSom" for="">Tamaño</label> <br>
                        <input class="input-EditSom" type="text" name="TamañoCinturon" id="TamañoCinturon" placeholder="(Numeros)">   

                    </div>

                    <div id="EditSom-right">
                        <div class="contenedor-preview">
            
                            <div class="caja-preview">
                                <input type="file" name="imgEditCinturon1" id="imgEditCinturon1" class="input-img-oculto" accept="image/*">
                                <label for="imgEditCinturon1" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditCinturon1" class="preview" src="#" alt="Vista previa 1">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgEditCinturon2" id="imgEditCinturon2" class="input-img-oculto" accept="image/*">
                                <label for="imgEditCinturon2" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditCinturon2" class="preview" src="#" alt="Vista previa 2">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgEditCinturon3" id="imgEditCinturon3" class="input-img-oculto" accept="image/*">
                                <label for="imgEditCinturon3" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditCinturon3" class="preview" src="#" alt="Vista previa 3">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgEditCinturon4" id="imgEditCinturon4" class="input-img-oculto" accept="image/*">
                                <label for="imgEditCinturon4" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewEditCinturon4" class="preview" src="#" alt="Vista previa 4">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="divButton">
                    <input type="submit" id="btnGuardarEditCinturon" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>
