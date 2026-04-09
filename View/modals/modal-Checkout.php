<link rel="stylesheet" href="/LaHerradura/View/css/style-Checkout.css">
<script src="https://sdk.mercadopago.com/js/v2"></script>

<div id="modal-checkout" class="modal-overlay" style="display: none;">
    <div class="modal-content checkout-container">
        
        <div class="modal-header">
            <h2>Finalizar Compra</h2>
            <span class="close" onclick="cerrarModalCheckout()">&times;</span>
        </div>

        <div class="checkout-steps">
            <div class="step active" id="indicator-1">1. Resumen</div>
            <div class="step" id="indicator-2">2. Envío</div>
            <div class="step" id="indicator-3">3. Pago</div>
        </div>

        <div class="modal-body">
            <div id="step-view-1" class="step-view">
                <h3>Resumen de tu Pedido</h3>
                <div class="table-responsive">
                    <table class="table-checkout">
                        <thead>
                            <tr>
                                <th>Producto</th><th>Talla</th><th>Cant.</th><th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="checkout-lista-productos"></tbody>
                    </table>
                </div>
                <div class="checkout-total">Total a Pagar: <span id="checkout-total-monto">$0.00</span></div>
                <div class="checkout-actions">
                    <button class="btn-cancelar" onclick="cerrarModalCheckout()">Seguir Comprando</button>
                    <button class="btn-siguiente" onclick="cambiarPaso(2)">Siguiente: Envío &rarr;</button>
                </div>
            </div>

            <?php
                // Recuperar Direcciones (Tu lógica original)
                $direcciones = []; 
                if (isset($_SESSION['id_usuario']) && isset($conn)) {
                    $id_usuario = $_SESSION['id_usuario'];
                    $sqlDir = "SELECT * FROM direcciones WHERE id_usuario = ?";
                    $stmtD = $conn->prepare($sqlDir);
                    if ($stmtD) {
                        $stmtD->bind_param("i", $id_usuario);
                        if ($stmtD->execute()) {
                            $resultDir = $stmtD->get_result();
                            while ($row = $resultDir->fetch_assoc()) {
                                $direcciones[] = $row;
                            }
                        }
                        $stmtD->close();
                    }
                }
            ?>

            <div id="step-view-2" class="step-view" style="display: none;">
                <h3>Selecciona una Dirección</h3>
                <button class="Botonverde" id="AgregarDireccion2">+ Agregar Nueva Dirección</button>
                
                <div id="lista-direcciones" class="direcciones-grid">
                    <label class="card-direccion">
                        <input type="radio" name="direccion_envio" value="1" checked>
                        <div class="info-dir">
                            <strong>Recoger en tienda</strong>
                            <p>Carretera Ixmiquilpan-Tasquillo km 25 Panales, Ixmiquilpan 42326</p>
                        </div>
                    </label>
                    <?php if (!empty($direcciones)): ?>
                        <?php foreach($direcciones as $dir): ?>
                            <label class="card-direccion">
                                <input type="radio" name="direccion_envio" value="<?php echo $dir['id_direccion']; ?>">
                                <div class="info-dir">
                                    <strong><?php echo htmlspecialchars($dir['calle'] ?? 'Calle'); ?> <?php echo htmlspecialchars($dir['numero'] ?? ''); ?></strong>
                                    <p><?php echo htmlspecialchars(($dir['colonia'] ?? '') . ', ' . ($dir['municipio'] ?? '') . ', ' . ($dir['estado'] ?? '') . ' CP: ' . ($dir['cp'] ?? '')); ?></p>
                                </div>
                            </label>
                    <?php endforeach; else: ?>
                        <p>No tienes ninguna dirección registrada.</p>
                    <?php endif; ?>
                </div>

                <div class="checkout-actions">
                    <button class="btn-atras" onclick="cambiarPaso(1)">&larr; Atrás</button>
                    <button class="btn-siguiente" onclick="cambiarPaso(3)">Siguiente: Pago &rarr;</button>
                </div>
            </div>

            <div id="step-view-3" class="step-view" style="display: none;">
                <h3>Método de Pago Seguro</h3>
                <div class="pago-simulado">
                    <div class="resumen-final-pago">
                        <p>Total a cargar: <strong id="pago-total-final">$0.00</strong></p>
                    </div>
                </div>

                <div id="wallet_container"></div>

                <div class="checkout-actions">
                    <button class="btn-atras" onclick="cambiarPaso(2)">&larr; Atrás</button>
                    <button id="btn-preparar-pago" class="btn-finalizar" onclick="procesarCompraFinal()">CONTINUAR AL PAGO</button>
                </div>
            </div>

        </div>
    </div>
</div>

<?php 
include('modal-AggDireccion.php');
?>