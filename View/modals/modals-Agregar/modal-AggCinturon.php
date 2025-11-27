<link rel="stylesheet" href="../../css/style-AggSombrero.css">

<div class="modal-AggSom" id="modal-AggCinturon">
    <div class="modal-content-AggSom">
        <span class="close">&times;</span>
        <h2 id="AggSom-text">Agregar Cinturon</h2>
        <div class="cont-form-AggSom">
            <form class="AggSom" id="form-AggSom" action="../../../Controller/CRUD_Cinturones/registroCinturones.php" method="POST" enctype="multipart/form-data">
                
                <div id="div-AggCinturon">
                    <div id="AggSCinturon-left">
                        
                        <label class="lbl-AggSom" for="NombreTexana">Nombre</label>
                        <br>
                        <input class="input-AggSom" type="text" name="NombreCinturon" id="NombreCinturon" placeholder="Ingresa el nombre completo">
                        <br>

                        <label class="lbl-AggSom"for="">Precio</label>
                        <br>
                        <input class="input-AggSom" type="text" name="PrecioCinturon" id="PrecioCinturon" placeholder="Solo numeros     Ej: 500">

                        <label class="lbl-AggSom"  for="">Material</label>
                        <br>
                        <input class="input-AggSom" type="text" name="MaterialCinturon" id="MaterialCinturon" placeholder="Ingresa el material">
                        <br>

                        <label class="lbl-AggSom" for="Adorno">Adorno:</label>
                        <br>
                        <select class="input-AggSom Selects-Agg" name="AdornoCinturon" id="AdornoCinturon">
                            <option value="Null">Selecciona una opcion</option>
                            <option value="Hilo">Hilo</option>
                            <option value="Pita">Pita</option>
                            <option value="Plata">Plata</option>
                            <option value="Cincelado">Cincelado</option>
                            <option value="Herraje">Herraje</option>
                            <option value="Laser">Laser</option>
                        </select>
                        <br>

                        <label class="lbl-AggSom" for="">Tamaño</label> <br>
                        <input class="input-AggSom" type="text" name="TamañoCinturon" id="TamañoCinturon" placeholder="(Numeros)">   

                    </div>

                    <div id="AggSom-right">
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
                <div id="divButton">
                    <input type="submit" id="btnGuardarAggCinturon" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>
