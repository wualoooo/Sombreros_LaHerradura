<link rel="stylesheet" href="/LaHerradura/View/css/style-AggExtras.css">

<div class="modal-AggExtras" id="modal-AggMaterial">
    <div class="modal-content-AggExtra">
        <span class="close">&times;</span>
        <h2 class="AggExtra-text">Agregar Material</h2>
        <div class="cont-form-AggExtra">
            <form class="AggExtra" id="form-AggMaterial" action="/LaHerradura/Controller/CRUD_Extras/CRUD_Materiales/registroMateriales.php" method="POST">
                <div class="div-AggExtra">
                    <label class="lbl-AggExtra" for="NombreMaterial">Nombre</label>
                    <br>
                    <input class="input-AggExtra" type="text" name="NombreMaterial" id="NombreMaterial" placeholder="Ingresa el nombre" required>
                    <br>
                </div>
                <div id="divButton">
                    <input class="ButtonGuardarExtras" type="submit" id="btnGuardarAggMaterial" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>
