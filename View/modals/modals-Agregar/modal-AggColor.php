<link rel="stylesheet" href="/LaHerradura/View/css/style-Agregar.css">

<div class="modal-AggExtras" id="modal-AggColor">
    <div class="modal-content-AggExtra">
        <span class="close">&times;</span>
        <h2 class="AggExtra-text">Agregar Color</h2>
        <div class="cont-form-AggExtra">
            <form class="AggExtra" id="form-AggColor" action="/LaHerradura/Controller/CRUD_Extras/CRUD_Colores/registroColores.php" method="POST">
                <div class="div-AggExtra">
                    <label class="lbl-AggExtra" for="NombreColor">Nombre</label>
                    <br>
                    <input class="input-AggExtra" type="text" name="NombreColor" id="NombreColor" placeholder="Ingresa el nombre" required>
                    <br>
                    <label class="lbl-AggExtra" for="NombreProducto">Color de:</label>
                    <br>
                    <select class="input-AggExtra" name="ProductoColor" id="ProductoColor">
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
                    <input class="ButtonGuardar"type="submit" id="btnGuardarAggColor" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>
