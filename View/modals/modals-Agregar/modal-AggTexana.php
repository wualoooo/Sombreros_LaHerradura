<link rel="stylesheet" href="/LaHerradura/View/css/style-ModalAgregar.css">

<div class="modal-Agregar" id="modal-AggTexana">
    <div class="modal-content-Agregar">
        <span class="close">&times;</span>
        <h2 class="Agregar-text">Agregar texana</h2>
        <div class="cont-form-Agregar">
            <form class="formAgregar" id="form-AggTexana" action="/LaHerradura/Controller/CRUD_Texanas/registroTexanas.php" method="POST" enctype="multipart/form-data">
                
                <div class="div-Agregar">
                    <div class="Agregar-left">

                        <label class="lbl-Agregar" for="NombreTexana">Nombre</label>
                        <br>
                        <input class="input-Agregar" type="text" name="NombreTexana" id="NombreTexana" placeholder="Ingresa el nombre completo" required>
                        <br>

                        <label class="lbl-Agregar" for="Color">Color</label>
                        <br>
                        <select class="input-Agregar Selects-Agregar" name="ColorTexana" id="ColorTexana">
                            <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                            <?php 
                                define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
                                include(ROOT_PATH . 'Model/conexion.php') ;

                                $verColores = "SELECT id_color, Nombre FROM colores WHERE Producto = 'Texanas'";
                                $resultColores = $conn->query($verColores);

                                    while ($rowColores = $resultColores -> fetch_assoc()){
                                        echo "
                                        <option value=".$rowColores['id_color'].">".$rowColores['Nombre']."</option>
                                        ";
                                    }
                            ?>
                        </select>
                        <br>

                        <label class="lbl-Agregar" for="Horma">Horma</label>
                        <br>
                        <select class="input-Agregar Selects-Agregar" name="HormaTexana" id="HormaTexana">
                            <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                            <?php 
                                include(ROOT_PATH . 'Model/conexion.php') ;

                                $verhormas = "SELECT id_horma, Nombre FROM hormas";
                                $resulthormas = $conn->query($verhormas);

                                    while ($rowhormas = $resulthormas -> fetch_assoc()){
                                        echo "
                                        <option value=".$rowhormas['id_horma'].">".$rowhormas['Nombre']."</option>
                                        ";
                                    }
                            ?>
                        </select>
                        <br>

                        <label class="lbl-Agregar" for="">Copa</label>
                        <br>
                        <select class="input-Agregar Selects-Agregar" name="CopaTexana" id="CopaTexana">
                            <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                            <?php 
                                include(ROOT_PATH . 'Model/conexion.php') ;

                                $verCopas = "SELECT id_copa, Nombre FROM copas";
                                $resultcopas = $conn->query($verCopas);

                                    while ($rowcopas = $resultcopas -> fetch_assoc()){
                                        echo "
                                        <option value=".$rowcopas['id_copa'].">".$rowcopas['Nombre']."</option>
                                        ";
                                    }
                            ?>
                        </select>
                        <br>

                        <div class="inputsTamaños">
                            <div class="inputsTamañosCopa">
                                <label class="lbl-Agregar" for="">Tamaño copa</label> <br>
                                <input class="input-Agregar" type="number" name="TamañoCopaTexana" id="TamañoCopaTexana" step="0.5" min="8">   
                            </div>
                            <div class="inputsTamañosAla">
                                <label class="lbl-Agregar" for="">Tamaño ala</label> <br>
                                <input class="input-Agregar" type="number" name="TamañoAlaTexana" id="TamañoAlaTexana" step="0.5" min="8" >
                            </div>
                        </div>

                        <label class="lbl-Agregar"  for="">Material</label>
                        <br>
                        <select class="input-Agregar Selects-Agregar" name="MaterialTexana" id="MaterialTexana">
                            <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                            <?php 
                                include(ROOT_PATH . 'Model/conexion.php') ;

                                $verMateriales = "SELECT id_material, Nombre FROM materiales WHERE Producto = 'Texanas'";
                                $resultMateriales = $conn->query($verMateriales);

                                    while ($rowMateriales = $resultMateriales -> fetch_assoc()){
                                        echo "
                                        <option value=".$rowMateriales['id_material'].">".$rowMateriales['Nombre']."</option>
                                        ";
                                    }
                            ?>
                        </select>
                        <br>

                        <label class="lbl-Agregar"for="">Precio</label>
                        <br>
                        <input class="input-Agregar" type="number" name="PrecioTexana" id="PrecioTexana" placeholder="Ingresa el precio" step="10" required min="0">
                    </div>

                    <div class="Agregar-right">
                        <div class="contenedor-preview">
            
                            <div class="caja-preview">
                                <input type="file" name="imgTexana1" id="imgTexana1" class="input-img-oculto" accept="image/*" >
                                <label for="imgTexana1" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewTexana1" class="preview" src="#" alt="Vista previa 1">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgTexana2" id="imgTexana2" class="input-img-oculto" accept="image/*" >
                                <label for="imgTexana2" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewTexana2" class="preview" src="#" alt="Vista previa 2">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgTexana3" id="imgTexana3" class="input-img-oculto" accept="image/*" >
                                <label for="imgTexana3" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewTexana3" class="preview" src="#" alt="Vista previa 3">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgTexana4" id="imgTexana4" class="input-img-oculto" accept="image/*" >
                                <label for="imgTexana4" class="label-boton">
                                    Seleccionar archivo
                                </label>
                                <img id="previewTexana4" class="preview" src="#" alt="Vista previa 4">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divButton">
                    <input type="submit" class="ButtonGuardar" id="btnGuardarAggTexana" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>