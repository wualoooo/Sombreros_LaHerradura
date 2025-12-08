<link rel="stylesheet" href="/LaHerradura/View/css/style-Modal-Edit-Som-Tex.css">

<div class="modal-EditSom" id="modal-EditSombrero">
    <div class="modal-content-EditSom">
        <span class="close">&times;</span>
        <h2 id="EditSom-text">Editar Sombrero</h2> 
        
        <div class="cont-form-EditSom">
            <form class="EditSom" id="form-EditSom" action="/LaHerradura/Controller/CRUD_Sombreros/ActualizarSombrero.php" method="POST" enctype="multipart/form-data">
                
                <div id="div-EditSomb">
                    <div id="EditSom-left">

                        <input type="hidden" id="edit-id-sombrero" name="id_sombrero">

                        <label class="lbl-EditSom" for="edit-NombreSombrero">Nombre</label>
                        <br>
                        <input class="input-EditSom" type="text" name="NombreSombrero" id="edit-NombreSombrero" required>
                        <br>

                        <label class="lbl-EditSom" for="edit-ColorSombrero">Color</label>
                        <br>
                        <select class="input-EditSom" name="ColorSombrero" id="edit-ColorSombrero">
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

                        <label class="lbl-EditSom" for="edit-HormaSombrero">Horma</label>
                        <br>
                        <select class="input-EditSom" name="HormaSombrero" id="edit-HormaSombrero">
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

                        <label class="lbl-EditSom" for="edit-CopaSombrero">Copa</label> <br>
                        <select class="input-EditSom Selects-Edit" name="CopaSombrero" id="edit-CopaSombrero" required>
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
                                <label class="lbl-EditSom" for="edit-TamañoCopaSombrero">Tamaño copa</label> <br>
                                <input class="input-EditSom" type="number" step="0.5" name="TamañoCopaSombrero" id="edit-TamañoCopaSombrero" min="8">   
                            </div>
                            <div class="inputsTamañosAla">
                                <label class="lbl-EditSom" for="edit-TamañoAlaSombrero">Tamaño ala</label> <br>
                                <input class="input-EditSom" type="number" step="0.5" name="TamañoAlaSombrero" id="edit-TamañoAlaSombrero" min="8">
                            </div>
                        </div>

                        <label class="lbl-EditSom" for="edit-MaterialSombrero">Material</label> <br>
                        <select class="input-EditSom" name="MaterialSombrero" id="edit-MaterialSombrero">
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

                        <label class="lbl-EditSom" for="edit-PrecioSombrero">Precio</label> <br>
                        <input class="input-EditSom" type="number" step="10" name="PrecioSombrero" id="edit-PrecioSombrero" min="0" required>
                    </div>

                    <div id="EditSom-right">
                        <div class="contenedor-preview">
                            
                            <div class="caja-preview">
                                <input type="file" name="imgSombrero1" id="imgEditSombrero1" class="input-img-oculto" accept="image/*,.HEIF,.HEIC,.AVIF">
                                <label for="imgEditSombrero1" class="label-boton">Seleccionar archivo</label>
                                <img id="previewEditSombrero1" class="preview" src="#" alt="Vista previa 1">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgSombrero2" id="imgEditSombrero2" class="input-img-oculto" accept="image/*,.HEIF,.HEIC,.AVIF">
                                <label for="imgEditSombrero2" class="label-boton">Seleccionar archivo</label>
                                <img id="previewEditSombrero2" class="preview" src="#" alt="Vista previa 2">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgSombrero3" id="imgEditSombrero3" class="input-img-oculto" accept="image/*,.HEIF,.HEIC,.AVIF">
                                <label for="imgEditSombrero3" class="label-boton">Seleccionar archivo</label>
                                <img id="previewEditSombrero3" class="preview" src="#" alt="Vista previa 3">
                            </div>

                            <div class="caja-preview">
                                <input type="file" name="imgSombrero4" id="imgEditSombrero4" class="input-img-oculto" accept="image/*,.HEIF,.HEIC,.AVIF">
                                <label for="imgEditSombrero4" class="label-boton">Seleccionar archivo</label>
                                <img id="previewEditSombrero4" class="preview" src="#" alt="Vista previa 4">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="divButton">
                    <input type="submit" id="btnGuardarEditSombreros" value="Guardar Cambios">
                </div>
            </form>
        </div>
    </div>
</div>