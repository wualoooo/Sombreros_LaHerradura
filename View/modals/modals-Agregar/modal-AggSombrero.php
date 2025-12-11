<link rel="stylesheet" href="/LaHerradura/View/css/style-ModalAgregar.css">

<div class="modal-Agregar" id="modal-AggSombrero">
    <div class="modal-content-Agregar">
        <span class="close">&times;</span>
        <h2 class="Agregar-text">Agregar sombrero</h2>
        <div class="cont-form-Agregar">
            <form class="formAgregar" id="form-AggSombrero" action="/LaHerradura/Controller/CRUD_Sombreros/registroSombreros.php" method="POST" enctype="multipart/form-data">
                
                <div class="div-Agregar">
                    <div class="Agregar-left">

                        <label class="lbl-Agregar" for="NombreSombrero">Nombre</label>
                        <br>
                        <input class="input-Agregar" type="text" name="NombreSombrero" id="NombreSombrero" placeholder="Ingresa el nombre completo" required>
                        <br>

                        <label class="lbl-Agregar" for="Color">Color</label>
                        <br>
                        <select class="input-Agregar Selects-Agg" name="ColorSombrero" id="ColorSombrero">
                            <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                            <?php 
                                define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
                                include(ROOT_PATH . 'Model/conexion.php') ;

                                $verColores = "SELECT id_color, Nombre FROM colores WHERE Producto = 'Sombreros'";
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
                        <select class="input-Agregar Selects-Agregar" name="HormaSombrero" id="HormaSombrero">
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
                        <select class="input-Agregar Selects-Agregar" name="CopaSombrero" id="CopaSombrero">
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
                                <input class="input-Agregar" type="number" name="TamañoCopaSombrero" id="TamañoCopaSombrero" step="0.5" min="8">   
                            </div>
                            <div class="inputsTamañosAla">
                                <label class="lbl-Agregar" for="">Tamaño ala</label> <br>
                                <input class="input-Agregar" type="number" name="TamañoAlaSombrero" id="TamañoAlaSombrero" step="0.5" min="8" >
                            </div>
                        </div>

                        <label class="lbl-Agregar"  for="">Material</label>
                        <br>
                        <select class="input-Agregar Selects-Agregar" name="MaterialSombrero" id="MaterialSombrero">
                            <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                            <?php 
                                include(ROOT_PATH . 'Model/conexion.php') ;

                                $verMateriales = "SELECT id_material, Nombre FROM materiales WHERE Producto = 'Sombreros'";
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
                        <input class="input-Agregar" type="number" name="PrecioSombrero" id="PrecioSombrero" placeholder="Ingresa el precio" step="10" required min="0">
                    </div>

                    <div class="Agregar-right">
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
                <div class="divButton">
                    <input type="submit" class="ButtonGuardar" id="btnGuardarAggSombrero" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>