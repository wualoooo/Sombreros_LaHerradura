<?php
session_start();

// 1. Declarar que SIEMPRE devolveremos JSON (Debe ir antes de cualquier echo)
header('Content-Type: application/json');

// 2. FILTRO DE SEGURIDAD VITAL: Verificar si hay sesión ANTES de hacer nada
if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
    // Si no hay sesión, detenemos todo y le avisamos al JS amablemente
    echo json_encode(['success' => false, 'message' => 'Sesión expirada o no iniciada. Por favor, vuelve a iniciar sesión para comprar.']);
    exit;
}

require_once '../Model/conexion.php'; 
require_once '../vendor/autoload.php'; 

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

// 3. RECIBIR DATOS DEL FETCH
$inputJSON = file_get_contents('php://input');
$datosCompra = json_decode($inputJSON, true);

if (!$datosCompra || empty($datosCompra['carrito'])) {
    echo json_encode(['success' => false, 'message' => 'Carrito vacío o datos inválidos.']);
    exit;
}

$carrito = $datosCompra['carrito'];
$id_direccion = (int)$datosCompra['id_direccion'];
$id_usuario = $_SESSION['id_usuario']; // Ya estamos 100% seguros de que esto existe

try {
    // 4. CALCULAR TOTAL Y PREPARAR JSON PARA LA BASE DE DATOS
    $total_calculado = 0;
    foreach ($carrito as $prod) {
        $total_calculado += ($prod['precio'] * $prod['cantidad']);
    }
    
    $productos_json = json_encode($carrito);
    $codigo_rastreo = "LH-" . date('Y') . "-" . time();

    // 5. GUARDAR EN MYSQL CON TUS COLUMNAS REALES
    $sqlPedido = "INSERT INTO pedidos (id_usuario, id_direccion, total, productos, estado_pago, estado_envio, fecha, codigo_rastreo) 
                VALUES (?, ?, ?, ?, 'PENDIENTE', 1, NOW(), ?)";

    $stmt = $conn->prepare($sqlPedido);
    $stmt->bind_param("iidss", $id_usuario, $id_direccion, $total_calculado, $productos_json, $codigo_rastreo);
    $stmt->execute();
    
    $id_pedido_interno = $conn->insert_id; 

    // 6. CONFIGURAR MERCADO PAGO 
    MercadoPagoConfig::setAccessToken("APP_USR-8083355483045380-033123-94c8d46063527a1b88721c4d2d2dcca8-3307374496");


    $items_mp = [];
    foreach ($carrito as $prod) {
        $items_mp[] = [
            "title" => $prod['nombre'],
            "quantity" => (int)$prod['cantidad'],
            "unit_price" => (float)$prod['precio'],
            "currency_id" => "MXN"
        ];
    }

    $client = new PreferenceClient();
    $preference = $client->create([
        "items" => $items_mp,
        "external_reference" => (string)$codigo_rastreo,
        "back_urls" => [
            "success" => "https://sombreroslaherradura.com/View/pages/user/pago_exitoso.php",
            "failure" => "https://sombreroslaherradura.com/View/pago_fallido.php",
            "pending" => "https://sombreroslaherradura.com/View/pago_pendiente.php"
        ],
        "auto_return" => "approved"
    ]);

    // 7. RESPONDER AL FRONTEND
    echo json_encode([
        'success' => true,
        'id_preferencia' => $preference->id
    ]);


} catch (\MercadoPago\Exceptions\MPApiException $e) {
    // ESTO ATRAPA EL ERROR EXACTO DE MERCADO PAGO
    $respuesta_cruda = $e->getApiResponse()->getContent();
    echo json_encode([
        'success' => false,
        'message' => 'Mercado Pago dice: ' . json_encode($respuesta_cruda)
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error general: ' . $e->getMessage()
    ]);
}
?>