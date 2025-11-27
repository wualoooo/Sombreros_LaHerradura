<link rel="stylesheet" href="../../css/style-AggSombrero.css">

<div class="modal-AggSom" id="modal-AggSombrero">
    <div class="modal-content-AggSom">
        <span class="close">&times;</span>
        <h2 id="AggSom-text">Agregar sombrero</h2>
        <div class="cont-form-AggSom">
            <form class="AggSom" id="form-AggSom" action="/LaHerradura/Controller/CRUD_Sombreros/registroSombreros.php" method="POST" enctype="multipart/form-data">
                
                <div id="div-AggSomb">
                    <div id="AggSom-left">

                        <label class="lbl-AggSom" for="NombreSombrero">Nombre</label>
                        <br>
                        <input class="input-AggSom" type="text" name="NombreSombrero" id="NombreSombrero" placeholder="Ingresa el nombre completo" required>
                        <br>

                        <label class="lbl-AggSom" for="Color">Color</label>
                        <br>
                        <select class="input-AggSom Selects-Agg" name="ColorSombrero" id="ColorSombrero">
                            <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                            <?php 
                                define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
                                include(ROOT_PATH . 'Model/conexion.php') ;

                                $verColores = "SELECT id_color, Nombre FROM colores";
                                $resultColores = $conn->query($verColores);

                                    while ($rowColores = $resultColores -> fetch_assoc()){
                                        echo "
                                        <option value=".$rowColores['Nombre'].">".$rowColores['Nombre']."</option>
                                        ";
                                    }
                            ?>
                        </select>
                        <br>

                        <label class="lbl-AggSom" for="Horma">Horma</label>
                        <br>
                        <select class="input-AggSom Selects-Agg" name="HormaSombrero" id="HormaSombrero">
                            <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                            <?php 
                                include(ROOT_PATH . 'Model/conexion.php') ;

                                $verhormas = "SELECT id_horma, Nombre FROM hormas";
                                $resulthormas = $conn->query($verhormas);

                                    while ($rowhormas = $resulthormas -> fetch_assoc()){
                                        echo "
                                        <option value=".$rowhormas['Nombre'].">".$rowhormas['Nombre']."</option>
                                        ";
                                    }
                            ?>
                        </select>
                        <br>

                        <label class="lbl-AggSom" for="">Copa</label>
                        <br>
                        <select class="input-AggSom Selects-Agg" name="CopaSombrero" id="CopaSombrero">
                            <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                            <?php 
                                include(ROOT_PATH . 'Model/conexion.php') ;

                                $verCopas = "SELECT id_copa, Nombre FROM copas";
                                $resultcopas = $conn->query($verCopas);

                                    while ($rowcopas = $resultcopas -> fetch_assoc()){
                                        echo "
                                        <option value=".$rowcopas['Nombre'].">".$rowcopas['Nombre']."</option>
                                        ";
                                    }
                            ?>
                        </select>
                        <br>

                        <div class="inputsTamaños">
                            <div class="inputsTamañosCopa">
                                <label class="lbl-AggSom" for="">Tamaño copa</label> <br>
                                <input class="input-AggSom" type="number" name="TamañoCopaSombrero" id="TamañoCopaSombrero" step="0.5" min="8">   
                            </div>
                            <div class="inputsTamañosAla">
                                <label class="lbl-AggSom" for="">Tamaño ala</label> <br>
                                <input class="input-AggSom" type="number" name="TamañoAlaSombrero" id="TamañoAlaSombrero" step="0.5" min="8" >
                            </div>
                        </div>

                        <label class="lbl-AggSom"  for="">Material</label>
                        <br>
                        <select class="input-AggSom Selects-Agg" name="MaterialSombrero" id="MaterialSombrero">
                            <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                            <?php 
                                include(ROOT_PATH . 'Model/conexion.php') ;

                                $verMateriales = "SELECT id_material, Nombre FROM materiales";
                                $resultMateriales = $conn->query($verMateriales);

                                    while ($rowMateriales = $resultMateriales -> fetch_assoc()){
                                        echo "
                                        <option value=".$rowMateriales['Nombre'].">".$rowMateriales['Nombre']."</option>
                                        ";
                                    }
                            ?>
                        </select>
                        <br>

                        <label class="lbl-AggSom"for="">Precio</label>
                        <br>
                        <input class="input-AggSom" type="number" name="PrecioSombrero" id="PrecioSombrero" placeholder="Ingresa el precio" step="10" required min="0">
                    </div>

                    <div id="AggSom-right">
                        <div class="contenedor-preview">
            
                            <div class="caja-preview">
                                <input type="file" name="imgSombrero1" id="imgSombrero1" class="input-img-oculto" accept="image/*" >
                                <label for="imgSombrero1" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewSombrero1" class="preview" src="#" alt="Vista previa 1">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgSombrero2" id="imgSombrero2" class="input-img-oculto" accept="image/*" >
                                <label for="imgSombrero2" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewSombrero2" class="preview" src="#" alt="Vista previa 2">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgSombrero3" id="imgSombrero3" class="input-img-oculto" accept="image/*" >
                                <label for="imgSombrero3" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewSombrero3" class="preview" src="#" alt="Vista previa 3">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgSombrero4" id="imgSombrero4" class="input-img-oculto" accept="image/*" >
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
