<?php
// 1. Configuración para evitar que el PDF se trabe o se quede sin memoria
ini_set('memory_limit', '1024M'); 
set_time_limit(120);

// 2. Conectar a la base de datos (Ajusta la ruta si es diferente)
require_once '../Model/conexion.php'; 

// 3. Validar que recibimos el ID del pedido
if (!isset($_GET['id_pedido']) || empty($_GET['id_pedido'])) {
    die("<h3>Error: No se especificó un número de pedido.</h3>");
}

$id_pedido = intval($_GET['id_pedido']);

// 4. Consultar el pedido en la base de datos
$sql = "SELECT id_pedido, fecha, total, productos, codigo_rastreo FROM pedidos WHERE id_pedido = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_pedido);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("<h3>Error: El pedido #" . $id_pedido . " no existe.</h3>");
}

$datos_pedido = $resultado->fetch_assoc();

// 5. Decodificar el JSON de los productos a un arreglo de PHP
// El "true" al final es vital para que se convierta en un Array y no en Objeto
$lista_productos = json_decode($datos_pedido['productos'], true);

// Verificamos que el JSON se haya leído bien
if (!$lista_productos || !is_array($lista_productos)) {
    die("<h3>Error: No se pudieron leer los productos del pedido.</h3>");
}

// 6. Cargar la librería Dompdf
require_once '../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// 7. Preparar las opciones de Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true); 
$options->set('defaultFont', 'Helvetica');
$options->set('chroot', $_SERVER['DOCUMENT_ROOT']); // Para que pueda leer tu logo

$dompdf = new Dompdf($options);

// 8. Cargar la plantilla HTML y pasarle las variables
ob_start();
// Las variables $datos_pedido y $lista_productos ya estarán disponibles dentro de la plantilla
require_once '../View/pages/user/plantilla_ticket.php'; 
$html = ob_get_clean();

// 9. Crear y renderizar el PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// 10. Mostrar el PDF en la pantalla
$dompdf->stream("Ticket_Pedido_" . $id_pedido . ".pdf", ["Attachment" => false]);
?>