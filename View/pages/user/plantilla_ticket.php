<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Compra</title>
    <style>
        /* Reset y fondo general (simula el fondo gris clarito de la app) */
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            background-color: #f7f7f7; 
            margin: 0; 
            padding: 20px;
        }
        
        /* Contenedor principal estilo "Hoja" */
        /* Contenedor principal sin curvas */
        .ticket-container { 
            background-color: #ffffff; 
            padding: 30px; 
            /* Eliminamos el border-radius para evitar lag */
            border: 1px solid #ddd; 
        }

        /* Diseño de "Card" cuadrado y fluido */
        .card-producto { 
            width: 100%; 
            border-collapse: collapse; 
            background-color: #ffffff; 
            border: 1px solid #ddd; 
            /* Eliminamos el border-radius */
            margin-bottom: 15px; 
        }

        /* Imagen sin curvas */
        .img-producto { 
            max-width: 80px; 
            max-height: 80px; 
            object-fit: contain; 
            /* Eliminamos el border-radius */
        }

        /* Cabecera (Logo y Folio) */
        .cabecera { width: 100%; margin-bottom: 25px; border-bottom: 2px solid #f0f0f0; padding-bottom: 15px; }
        .cabecera table { width: 100%; }
        .logo { max-width: 130px; }
        .titulo-ticket { color: #333; font-size: 20px; margin: 0; font-weight: bold; }
        .fecha-folio { color: #777; font-size: 13px; margin-top: 5px; }

        /* Datos del Cliente */
        .seccion-titulo { font-size: 16px; font-weight: bold; color: #444; margin-bottom: 10px; margin-top: 25px; }
        .datos-cliente { background-color: #fafafa; padding: 15px; border-radius: 8px; border: 1px solid #eeeeee; margin-bottom: 25px; }
        .datos-cliente p { margin: 4px 0; font-size: 14px; color: #333; }

        /* =========================================
           DISEÑO TIPO "CARD" MERCADO LIBRE 
           ========================================= */
        /*.card-producto { 
            width: 100%; 
            border-collapse: collapse; 
            background-color: #ffffff; 
            border: 1px solid #e0e0e0; 
            border-radius: 8px; 
            margin-bottom: 15px; 
        }*/
        
        .card-producto td { padding: 15px; vertical-align: middle; }
        
        /* Columna Izquierda: Imagen */
        .td-imagen { width: 90px; text-align: center; border-right: 1px solid #f0f0f0; }
        /*.img-producto { max-width: 80px; max-height: 80px; object-fit: contain; border-radius: 5px; }*/

        /* Columna Central: Detalles del Producto */
        .td-info { vertical-align: top; padding-left: 15px; }
        .prod-nombre { font-size: 16px; font-weight: bold; color: #333; margin: 0 0 6px 0; }
        .prod-detalles { font-size: 13px; color: #666; margin: 0; line-height: 1.5; }
        .cantidad-tag { 
            display: inline-block; 
            background-color: #f0f0f0; 
            color: #555; 
            font-size: 12px; 
            padding: 3px 8px; 
            border-radius: 4px; 
            margin-top: 8px; 
        }

        /* Columna Derecha: Precio */
        .td-precio { width: 120px; text-align: right; vertical-align: top; }
        .precio-subtotal { font-size: 22px; font-weight: bold; color: #333; margin: 0; }

        /* Totales (Abajo) */
        .resumen-pago { width: 100%; margin-top: 35px; text-align: right; }
        .resumen-pago table { width: 100%; }
        .texto-total { font-size: 18px; color: #555; text-align: right; padding-right: 15px; }
        .monto-total { font-size: 28px; font-weight: bold; color: #8B0000; text-align: right; width: 160px; }

        /* Footer */
        .footer { text-align: center; font-size: 12px; color: #aaa; margin-top: 50px; }
    </style>
    <link rel="shortcut icon" href="../../images/Logo_Herradura_head3.png" type="image/x-icon">
</head>
<body>
    <div class="ticket-container">
        <div class="cabecera">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="50%">
                        <?php 
                            $ruta_logo = $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/View/images/herraduraNegro.png'; 
                        ?>
                        <img src="<?php echo $ruta_logo; ?>" class="logo" alt="Logo">
                    </td>
                    <td width="50%" align="right">
                        <h1 class="titulo-ticket">Comprobante de Pago</h1>
                        <div class="fecha-folio">
                            Código de rastreo: <strong><?php echo ($datos_pedido['codigo_rastreo']); ?></strong><br>
                            <?php echo date('d/m/Y H:i', strtotime($datos_pedido['fecha'])); ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="seccion-titulo">Productos Adquiridos</div>

        <?php 
        // Empezamos a recorrer el JSON de productos
        foreach ($lista_productos as $producto) { 
        ?>
            <table class="card-producto">
                <tr>
                    <td class="td-imagen">
                        <?php 
                            // Construimos la ruta dependiendo del tipo de producto
                            $tipo_carpeta = strtolower($producto['tipo']); // Ej: sombreros, texanas
                            $nombre_imagen = $producto['imagen'];
                            $ruta_imagen = $_SERVER['DOCUMENT_ROOT'] . "/LaHerradura/uploads/{$tipo_carpeta}/{$nombre_imagen}";
                            
                            // Si por algo se borró la imagen del servidor, ponemos el logo por defecto para que no explote
                            if (!file_exists($ruta_imagen)) {
                                $ruta_imagen = $ruta_logo;
                            }
                        ?>
                        <img src="<?php echo $ruta_imagen; ?>" class="img-producto" alt="Producto">
                    </td>
                    <td class="td-info">
                        <p class="prod-nombre"><?php echo htmlspecialchars($producto['nombre']); ?></p>
                        <p class="prod-detalles">
                            SKU: <?php echo htmlspecialchars($producto['sku']); ?><br>
                            Talla: <strong><?php echo htmlspecialchars($producto['talla']); ?></strong>
                        </p>
                        <span class="cantidad-tag">Cantidad: <?php echo $producto['cantidad']; ?></span>
                    </td>
                    <td class="td-precio">
                        <p class="precio-subtotal">
                            $<?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?>
                        </p>
                    </td>
                </tr>
            </table>
        <?php 
        } // Fin del foreach 
        ?>

        <div class="resumen-pago">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="texto-total">Total pagado:</td>
                    <td class="monto-total">$<?php echo number_format($datos_pedido['total'], 2); ?></td>
                </tr>
            </table>
        </div>

        <div class="footer">
            ¡Gracias por tu preferencia!<br>
            <strong>Sombreros La Herradura</strong> • www.sombreroslaherradura.com
        </div>
    </div>
</body>
</html>