<link rel="stylesheet" href="/LaHerradura/View/css/style-AggExtras.css">

<div class="modal-AggExtras" id="modal-AggHorma">
    <div class="modal-content-AggExtra">
        <span class="close">&times;</span>
        <h2 class="AggExtra-text">Agregar Horma</h2>
        <div class="cont-form-AggExtra">
            <form class="AggExtra" id="form-AggHorma" action="/LaHerradura/Controller/CRUD_Extras/CRUD_Hormas/registroHormas.php" method="POST">
                <div class="div-AggExtra">
                    <label class="lbl-AggExtra" for="NombreHorma">Nombre</label>
                    <br>
                    <input class="input-AggExtra" type="text" name="NombreHorma" id="NombreHorma" placeholder="Ingresa el nombre" required>
                    <br>
                </div>
                <div id="divButton">
                    <input class="ButtonGuardarExtras" type="submit" id="btnGuardarAggHorma" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>
