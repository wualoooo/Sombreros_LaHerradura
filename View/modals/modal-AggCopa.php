<link rel="stylesheet" href="/LaHerradura/View/css/style-AggExtras.css">

<div class="modal-AggExtras" id="modal-AggCopa">
    <div class="modal-content-AggExtra">
        <span class="close">&times;</span>
        <h2 class="AggExtra-text">Agregar Copa</h2>
        <div class="cont-form-AggExtra">
            <form class="AggExtra" id="form-AggCopa" action="/LaHerradura/Controller/CRUD_Extras/CRUD_Copas/registroCopas.php" method="POST">
                <div class="div-AggExtra">
                    <label class="lbl-AggExtra" for="NombreCopa">Nombre</label>
                    <br>
                    <input class="input-AggExtra" type="text" name="NombreCopa" id="NombreCopa" placeholder="Ingresa el nombre" required>
                    <br>
                </div>
                <div id="divButton">
                    <input class="ButtonGuardarExtras" type="submit" id="btnGuardarAggCopa" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>
