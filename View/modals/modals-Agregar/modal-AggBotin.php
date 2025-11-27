<link rel="stylesheet" href="/LaHerradura/View/css/style-AggSombrero.css">

<div class="modal-AggSom" id="modal-AggBotin">
    <div class="modal-content-AggSom">
        <span class="close">&times;</span>
        <h2 id="AggSom-text">Agregar Botin</h2>
        <div class="cont-form-AggSom">
            <form class="AggSom" id="form-AggSom" action="/LaHerradura/Controller/CRUD_Botines/registroBotines.php" method="POST" enctype="multipart/form-data">
                
                <div id="div-AggCinturon">
                    <div id="AggSCinturon-left">
                        
                        <label class="lbl-AggSom" for="NombreTexana">Nombre</label>
                        <br>
                        <input class="input-AggSom" type="text" name="NombreBotin" id="NombreBotin" placeholder="Ingresa el nombre completo">
                        <br>

                        <label class="lbl-AggSom" for="">Talla</label> <br>
                        <input class="input-AggSom" type="text" name="TallaBotin" id="TallaBotin" placeholder="(Numeros)"> 

                        <label class="lbl-AggSom"  for="Material">Material</label>
                        <br>
                        <select class="input-AggSom Selects-Agg" name="MaterialBotin" id="MaterialBotin">
                            <option value="Null">Selecciona una opcion</option>
                            <option value="Piel">Piel</option>
                            <option value="Gamuza">Gamuza</option>
                        </select>
                        <br>

                        <label class="lbl-AggSom" for="Adorno">Suela</label>
                        <br>
                        <select class="input-AggSom Selects-Agg" name="SuelaBotin" id="SuelaBotin">
                            <option value="Null">Selecciona una opcion</option>
                            <option value="Hule con cerco">Hule con cerco</option>
                            <option value="Hule sin cerco">Hule sin cerco</option>
                            <option value="Piel">Piel</option>
                            <option value="Doble suela">Doble suela</option>
                            <option value="Cuadros">Cuadros</option>
                            <option value="Tractor">Tractor</option>
                        </select>
                        <br>
                        
                        <label class="lbl-AggSom"for="">Precio</label>
                        <br>
                        <input class="input-AggSom" type="text" name="PrecioBotin" id="PrecioBotin" placeholder="Solo numeros     Ej: 500">

                    </div>

                    <div id="AggSom-right">
                        <div class="contenedor-preview">
            
                            <div class="caja-preview">
                                <input type="file" name="imgBotin1" id="imgBotin1" class="input-img-oculto" accept="image/*">
                                <label for="imgBotin1" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewBotin1" class="preview" src="#" alt="Vista previa 1">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgBotin2" id="imgBotin2" class="input-img-oculto" accept="image/*">
                                <label for="imgBotin2" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewBotin2" class="preview" src="#" alt="Vista previa 2">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgBotin3" id="imgBotin3" class="input-img-oculto" accept="image/*">
                                <label for="imgBotin3" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewBotin3" class="preview" src="#" alt="Vista previa 3">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgBotin4" id="imgBotin4" class="input-img-oculto" accept="image/*">
                                <label for="imgBotin4" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewBotin4" class="preview" src="#" alt="Vista previa 4">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="divButton">
                    <input type="submit" id="btnGuardarAggBotin" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>
