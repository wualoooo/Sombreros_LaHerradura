<link rel="stylesheet" href="../../css/style-AggSombrero.css">

<div class="modal-AggSom" id="modal-AggTexana">
    <div class="modal-content-AggSom">
        <span class="close">&times;</span>
        <h2 id="AggSom-text">Agregar Texana</h2>
        <div class="cont-form-AggSom">
            <form class="AggSom" id="form-AggSom" action="/LaHerradura/Controller/CRUD_Texanas/registroTexanas.php" method="POST" enctype="multipart/form-data">
                
                <div id="div-AggSomb">
                    <div id="AggSom-left">

                        <label class="lbl-AggSom" for="NombreTexana">Nombre</label>
                        <br>
                        <input class="input-AggSom" type="text" name="NombreTexana" id="NombreTexana" placeholder="Ingresa el nombre completo">
                        <br>

                        <label class="lbl-AggSom" for="Color">Color</label>
                        <br>
                        <input class="input-AggSom" type="text" name="ColorTexana" id="ColorTexana" placeholder="Ingresa el color">
                        <br>

                        <label class="lbl-AggSom" for="Horma">Horma</label>
                        <br>
                        <select class="input-AggSom Selects-Agg" name="HormaTexana" id="HormaTexana">
                            <option value="Null">Selecciona una opcion</option>
                            <option value="horma1">horma1</option>
                            <option value="horma2">horma2</option>
                            <option value="horma3">horma3</option>
                            <option value="horma4">horma4</option>
                        </select>
                        <br>

                        <label class="lbl-AggSom" for="">Copa</label>
                        <br>
                        <select class="input-AggSom Selects-Agg" name="CopaTexana" id="CopaTexana">
                            <option value="Null">Selecciona una opcion</option>
                            <option value="Copa1">Copa1</option>
                            <option value="Copa2">Copa2</option>
                            <option value="Copa3">Copa3</option>
                            <option value="Copa4">Copa4</option>
                        </select>
                        <br>

                        <div class="inputsTamaños">
                            <div class="inputsTamañosCopa">
                                <label class="lbl-AggSom" for="">Tamaño copa</label> <br>
                                <input class="input-AggSom" type="text" name="TamañoCopaTexana" id="TamañoCopaTexana" placeholder="(Numeros)">   
                            </div>
                            <div class="inputsTamañosAla">
                                <label class="lbl-AggSom" for="">Tamaño ala</label> <br>
                                <input class="input-AggSom" type="text" name="TamañoAlaTexana" id="TamañoAlaTexana" placeholder="(Numeros)">
                            </div>
                        </div>

                        <label class="lbl-AggSom"  for="">Material</label>
                        <br>
                        <input class="input-AggSom" type="text" name="MaterialTexana" id="MaterialTexana" placeholder="Ingresa el material">
                        <br>

                        <label class="lbl-AggSom"for="">Precio</label>
                        <br>
                        <input class="input-AggSom" type="text" name="PrecioTexana" id="PrecioTexana" placeholder="Solo numeros     Ej: 500">
                    </div>

                    <div id="AggSom-right">
                        <div class="contenedor-preview">
            
                            <div class="caja-preview">
                                <input type="file" name="imgTexana1" id="imgTexana1" class="input-img-oculto" accept="image/*">
                                <label for="imgTexana1" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewTexana1" class="preview" src="#" alt="Vista previa 1">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgTexana2" id="imgTexana2" class="input-img-oculto" accept="image/*">
                                <label for="imgTexana2" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewTexana2" class="preview" src="#" alt="Vista previa 2">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgTexana3" id="imgTexana3" class="input-img-oculto" accept="image/*">
                                <label for="imgTexana3" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewTexana3" class="preview" src="#" alt="Vista previa 3">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgTexana4" id="imgTexana4" class="input-img-oculto" accept="image/*">
                                <label for="imgTexana4" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewTexana4" class="preview" src="#" alt="Vista previa 4">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="divButton">
                    <input type="submit" id="btnGuardarAggTexana" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../../public/viewImages.js"></script>
