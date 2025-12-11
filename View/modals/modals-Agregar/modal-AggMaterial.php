<link rel="stylesheet" href="/LaHerradura/View/css/style-ModalAgregar.css">

<div class="modal-AggExtras" id="modal-AggMaterial">
    <div class="modal-content-AggExtra" id="AgregarMaterial">
        <span class="close">&times;</span>
        <h2 class="AggExtra-text">Agregar Material</h2>
        <div class="cont-form-AggExtra">
            <form class="AggExtra" id="form-AggMaterial" action="/LaHerradura/Controller/CRUD_Extras/CRUD_Materiales/registroMateriales.php" method="POST">

                <div class="div-AggExtra">
                    <label class="lbl-AggExtra" for="NombreMaterial">Nombre</label>
                    <br>
                    <input class="input-AggExtra" type="text" name="NombreMaterial" id="NombreMaterial" placeholder="Ingresa el nombre" required>
                    <br>
                    <label class="lbl-AggExtra" for="NombreProducto">Material de:</label>
                    <br>
                    <select class="input-AggExtra" name="ProductoMaterial" id="ProductoMaterial">
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                        <option value="Sombreros">Sombreros</option>
                        <option value="Texanas">Texanas</option>
                        <option value="Cinturones">Cinturones</option>
                        <option value="Botines">Botines</option>
                        <option value="Adornos">Adornos</option>
                        <option value="Suelas">Suelas</option>
                    </select>
                    <br>
                </div>
                <div id="divButton">
                    <input class="ButtonGuardar" type="submit" id="btnGuardarAggMaterial" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>
