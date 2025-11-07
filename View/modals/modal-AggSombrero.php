<link rel="stylesheet" href="../css/style-AggSombrero.css">

<div class="modal-AggSom" id="modal-AggSombrero">
    <div class="modal-content-AggSom">
        <span class="close">&times;</span>
        <h2 id="AggSom-text">Agregar sombrero</h2>
        <div class="cont-form-AggSom">
            <form class="AggSom" id="form-AggSom" action="../../Controller/registroSombreros.php" method="POST" enctype="multipart/form-data">
                
                <div id="div-AggSomb">
                    <div id="AggSom-left">

                        <label class="lbl-AggSom" for="NombreSombrero">Nombre</label>
                        <br>
                        <input class="input-AggSom" type="text" name="NombreSombrero" id="NombreSombrero">
                        <br>

                        <label class="lbl-AggSom" for="Color">Color</label>
                        <br>
                        <input class="input-AggSom" type="text" name="ColorSombrero" id="ColorSombrero">
                        <br>

                        <label class="lbl-AggSom" for="Horma">Horma</label>
                        <br>
                        <select class="input-AggSom Selects-Agg" name="HormaSombrero" id="HormaSombrero">
                            <option value="Null">Selecciona una opcion</option>
                            <option value="">horma1</option>
                            <option value="">horma2</option>
                            <option value="">horma3</option>
                            <option value="">horma4</option>
                        </select>
                        <br>

                        <label class="lbl-AggSom" for="">Copa</label>
                        <br>
                        <select class="input-AggSom Selects-Agg" name="CopaSombrero" id="CopaSombrero">
                            <option value="Null">Selecciona una opcion</option>
                            <option value="">Copa1</option>
                            <option value="">Copa2</option>
                            <option value="">Copa3</option>
                            <option value="">Copa4</option>
                        </select>
                        <br>

                        <label class="lbl-AggSom" for="">Tamaño copa</label>
                        <br>
                        <input class="input-AggSom" type="text" name="TamañoCopaSombrero" id="TamañoCopaSombrero">
                        <br>

                        <label class="lbl-AggSom"  for="">Material</label>
                        <br>
                        <input class="input-AggSom" type="text" name="MaterialSombrero" id="MaterialSombrero">
                        <br>

                        <label class="lbl-AggSom"for="">Precio</label>
                        <br>
                        <input class="input-AggSom" type="text" name="PrecioSombrero" id="PrecioSombrero">
                    </div>

                    <div id="AggSom-right">
                        <div class="contenedor-preview">
            
                            <div class="caja-preview">
                                <input type="file" name="imgSombrero1" id="imgSombrero1" class="input-img-oculto" accept="image/*">
                                <label for="imgSombrero1" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewSombrero1" class="preview" src="#" alt="Vista previa 1">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgSombrero2" id="imgSombrero2" class="input-img-oculto" accept="image/*">
                                <label for="imgSombrero2" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewSombrero2" class="preview" src="#" alt="Vista previa 2">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgSombrero3" id="imgSombrero3" class="input-img-oculto" accept="image/*">
                                <label for="imgSombrero3" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewSombrero3" class="preview" src="#" alt="Vista previa 3">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgSombrero4" id="imgSombrero4" class="input-img-oculto" accept="image/*">
                                <label for="imgSombrero4" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewSombrero4" class="preview" src="#" alt="Vista previa 4">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="divButton">
                    <input type="submit" id="btnGuardarAgg" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../../public/viewImages.js"></script>
