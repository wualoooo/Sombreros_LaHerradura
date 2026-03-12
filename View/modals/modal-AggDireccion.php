<link rel="stylesheet" href="/LaHerradura/View/css/style-AddDireccion.css">

<div class="modal-Cc" id="modal-AgregarDirección">
    <div class="modal-content-AgregarDirección">
        
        <div class="Cont-Form-AgregarDireccion">
            <span class="close">&times;</span>
            <h2>Agregar Dirección</h2>
            
            <div class="indicador-pasos">
                <span class="paso-dot-dir active">1</span>
                <span class="paso-dot-dir">2</span>
            </div>

            <form class="Registro-Dirección" id="Form-AgregarDirección" action="/LaHerradura/Controller/CRUD_Direcciones/Agregar_Direccion.php" method="post">
                
                <div class="pasarela-step-dir active" id="step-dir-1">
                    <label class="Label-AddDireccion">Código Postal</label>
                    <input class="input-AddDireccion" type="text" name="cp" id="cp" maxlength="5" placeholder="Ej: 42380" required>
                    
                    <label class="Label-AddDireccion">Estado</label>
                    <input class="input-AddDireccion" type="text" name="estado" id="estado" readonly required>
                    
                    <label class="Label-AddDireccion">Municipio</label>
                    <input class="input-AddDireccion" type="text" name="municipio" id="municipio" readonly required>
                    
                    <label class="Label-AddDireccion">Colonia</label>
                    <select class="input-AddDireccion" name="colonia" id="colonia" required>
                        <option value="" selected disabled hidden>Ingresa un CP primero</option>
                    </select>

                    <div class="divButton-pasarela">
                        <button type="button" class="btn-pasarela btn-siguiente" onclick="cambiarPasoDir(1, 2)">Siguiente</button>
                    </div>
                </div>

                <div class="pasarela-step-dir" id="step-dir-2" style="display:none;">
                    <label class="Label-AddDireccion">Calle</label>
                    <input class="input-AddDireccion" type="text" name="calle" id="calle" placeholder="Nombre de tu calle" required>
                    
                    <label class="Label-AddDireccion">Número (Ext / Int)</label>
                    <input class="input-AddDireccion" type="text" name="numCalle" id="numCalle" placeholder="Ej: Mz 4 Lt 2 o #150" required>
                    
                    <label class="Label-AddDireccion">Número de télefono</label>
                    <input class="input-AddDireccion" type="text" name="numTel" minlength="10" maxlength="10" id="numTel" placeholder="A 10 dígitos" required>
                    
                    <label class="Label-AddDireccion">Referencia de entrega</label>
                    <textarea class="input-AddDireccion" name="referencia" id="referencia" placeholder="Color de casa, entre calles, etc. (Max 200 caracteres)." maxlength="200" required></textarea>
                    
                    <div class="divButton-pasarela">
                        <button type="button" class="btn-pasarela btn-anterior" onclick="cambiarPasoDir(2, 1)">Anterior</button>
                        <button type="submit" class="ButtonGuardar">Guardar Dirección</button>
                    </div>
                </div>
            </form>
            
            <script src="/LaHerradura/public/cp.js"></script>
            <script>
            // Función para cambiar de pasos
            function cambiarPasoDir(pasoActual, pasoSiguiente) {
                if (pasoSiguiente > pasoActual) {
                    const contenedorPaso = document.getElementById(`step-dir-${pasoActual}`);
                    const inputs = contenedorPaso.querySelectorAll('input, select');
                    let valido = true;

                    for (let input of inputs) {
                        if (input.tagName === 'SELECT' && input.value === '') {
                            Swal.fire({icon: 'warning', title: 'Falta colonia', text: 'Busca un Código Postal válido y selecciona tu colonia.'});
                            valido = false; break;
                        }
                        if (!input.checkValidity()) {
                            input.reportValidity();
                            valido = false; break;
                        }
                    }
                    if (!valido) return;
                }

                document.getElementById(`step-dir-${pasoActual}`).style.display = 'none';
                document.getElementById(`step-dir-${pasoSiguiente}`).style.display = 'block';

                const dots = document.querySelectorAll('.paso-dot-dir');
                dots.forEach((dot, index) => {
                    if (index < pasoSiguiente) dot.classList.add('active');
                    else dot.classList.remove('active');
                });
            }

            // Manejo del Submit con Fetch y SweetAlert
            document.getElementById("Form-AgregarDirección").addEventListener("submit", function(e){
                e.preventDefault();
                let datos = new FormData(this);

                fetch(this.action, { method: "POST", body: datos })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('¡Éxito!', data.mensaje, 'success').then(() => { location.reload(); });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire('Error', 'Hubo un problema de conexión', 'error');
                });
            });
            </script>
        </div>
    </div>
</div>