<link rel="stylesheet" href="/LaHerradura/View/css/style-AddDireccion.css">

<div class="modal-Cc" id="modal-AgregarDirección">
    <div class="modal-content-AgregarDirección">
        <span class="close">&times;</span>
        <h2>Agregar una dirección nueva</h2>
        <div class="Cont-Form-AgregarDireccion">
            <form class="Registro-Dirección" id="Form-AgregarDirección" action="/LaHerradura/Controller/CRUD_Direcciones/Agregar_Direccion.php" method="post">
                    <label class="Label-AddDireccion">Código Postal</label>
                    <br>
                    <input class="input-AddDireccion" type="text" name="cp" id="cp" maxlength="5" required>
                    <br>
                    <label class="Label-AddDireccion" >Estado</label>
                    <br>
                    <input class="input-AddDireccion" type="text" name="estado" id="estado" readonly>
                    <br>
                    <label class="Label-AddDireccion" >Municipio</label>
                    <br>
                    <input class="input-AddDireccion" type="text" name="municipio" id="municipio" readonly >
                    <br>
                    <label class="Label-AddDireccion" >Colonia</label>
                    <br>
                    <select class="input-AddDireccion" name="colonia" id="colonia" >
                        <option value="Null" selected disabled hidden>Selecciona una opcion</option>
                    </select>
                    <br>
                    <label class="Label-AddDireccion" >Calle</label>
                    <br>
                    <input class="input-AddDireccion" type="text" name="calle" id="calle" >
                    <br>
                    <label class="Label-AddDireccion" >Número de calle</label>
                    <br>
                    <input class="input-AddDireccion" type="text" name="numCalle" id="numCalle">
                    <br>
                    <label class="Label-AddDireccion" >Número de télefono</label>
                    <br>
                    <input class="input-AddDireccion" type="text" name="numTel"  minlength="10" id="numTel">
                    <br>
                    <label class="Label-AddDireccion" >Referencia</label>
                    <br>
                    <textarea class="input-AddDireccion" name="referencia" id="referencia" placeholder="Decribe como llegar a tu domicilio (Max 200 caracteres)." maxlength="200"></textarea>
                    <br>
                    <div class="divButton">
                        <input class="ButtonGuardar" type="submit" name="ButtonGuardarDireccion" id="ButtonGuardarDireccion" value="Guardar dirección">
                    </div>
                    </form>
                    <script src="/LaHerradura/public/cp.js"></script>

                    <script>
                    document.getElementById("Form-AgregarDirección").addEventListener("submit", function(e){
                        e.preventDefault(); // Evita que la página se recargue

                        // 1. Empaquetar los datos del formulario
                        let datos = new FormData(this);

                        // 2. Enviarlos al PHP corregido
                        fetch(this.action, {
                            method: "POST",
                            body: datos
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert("¡Éxito! " + data.mensaje);
                                // Opcional: Cerrar modal o recargar para ver la nueva dirección
                                location.reload(); 
                            } else {
                                alert("Error: " + data.message);
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("Hubo un error en la conexión");
                        });
                    });
                    </script>
        </div>
    </div>
</div>

