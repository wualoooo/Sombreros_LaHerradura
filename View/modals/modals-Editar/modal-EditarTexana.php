<link rel="stylesheet" href="/LaHerradura/View/css/style-ModalEdit.css">

<div class="modal-Edit" id="modal-EditTexana">
    <div class="modal-content-Edit">
        <span class="close">&times;</span>
        <h2 class="Edit-text">Editar Texana</h2> 
        
        <div class="cont-form-EditSom">
            <form class="EditSom" id="form-EditTexana" action="/LaHerradura/Controller/CRUD_Texanas/ActualizarTexana.php" method="POST" enctype="multipart/form-data">
                
                <div class="div-Edit">
                    <div class="Edit-left">

                        <input type="hidden" id="edit-id-texana" name="id_texana">

                        <label class="lbl-Edit" for="edit-NombreTexana">Nombre</label>
                        <br>
                        <input class="input-Edit" type="text" name="NombreTexana" id="edit-NombreTexana" required>
                        <br>

                        <label class="lbl-Edit" for="edit-ColorTexana">Color</label>
                        <br>
                        <select class="input-Edit" name="ColorTexana" id="edit-ColorTexana">
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

                        <label class="lbl-Edit" for="edit-HormaTexana">Horma</label>
                        <br>
                        <select class="input-Edit" name="HormaTexana" id="edit-HormaTexana">
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

                        <label class="lbl-Edit" for="edit-CopaTexana">Copa</label> <br>
                        <select class="input-Edit Selects-Edit" name="CopaTexana" id="edit-CopaTexana" required>
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
                                <label class="lbl-Edit" for="edit-TamañoCopaTexana">Tamaño copa</label> <br>
                                <input class="input-Edit" type="number" step="0.5" name="TamañoCopaTexana" id="edit-TamañoCopaTexana" min="8">   
                            </div>
                            <div class="inputsTamañosAla">
                                <label class="lbl-Edit" for="edit-TamañoAlaTexana">Tamaño ala</label> <br>
                                <input class="input-Edit" type="number" step="0.5" name="TamañoAlaTexana" id="edit-TamañoAlaTexana" min="8">
                            </div>
                        </div>

                        <label class="lbl-Edit" for="edit-MaterialTexana">Material</label> <br>
                        <select class="input-Edit" name="MaterialTexana" id="edit-MaterialTexana">
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

                        <label class="lbl-Edit" for="edit-PrecioTexana">Precio</label> <br>
                        <input class="input-Edit" type="number" step="10" name="PrecioTexana" id="edit-PrecioTexana" min="0" required>
                    </div>

                    <div class="Edit-right">
                        <div class="contenedor-preview">
                            
                            <div class="caja-preview">
                                <input type="file" name="imgTexana1" id="imgEditTexana1" class="input-img-oculto" accept="image/*,.HEIF,.HEIC,.AVIF">
                                <label for="imgEditTexana1" class="label-boton">Seleccionar archivo</label>
                                <img id="previewEditTexana1" class="preview" src="#" alt="Vista previa 1">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgTexana2" id="imgEditTexana2" class="input-img-oculto" accept="image/*,.HEIF,.HEIC,.AVIF">
                                <label for="imgEditTexana2" class="label-boton">Seleccionar archivo</label>
                                <img id="previewEditTexana2" class="preview" src="#" alt="Vista previa 2">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgTexana3" id="imgEditTexana3" class="input-img-oculto" accept="image/*,.HEIF,.HEIC,.AVIF">
                                <label for="imgEditTexana3" class="label-boton">Seleccionar archivo</label>
                                <img id="previewEditTexana3" class="preview" src="#" alt="Vista previa 3">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgTexana4" id="imgEditTexana4" class="input-img-oculto" accept="image/*,.HEIF,.HEIC,.AVIF">
                                <label for="imgEditTexana4" class="label-boton">Seleccionar archivo</label>
                                <img id="previewEditTexana4" class="preview" src="#" alt="Vista previa 4">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divButton">
                    <input type="submit" class="ButtonGuardarEdit" id="btnGuardarEditTexanas" value="Guardar Cambios">
                </div>
            </form>
        </div>
    </div>
</div>