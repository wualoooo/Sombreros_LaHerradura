<link rel="stylesheet" href="/LaHerradura/View/css/style-AggExtras.css">

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
                </div>
                <div id="divButton">
                    <input class="ButtonGuardarExtras" type="submit" id="btnGuardarAggColor" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>
