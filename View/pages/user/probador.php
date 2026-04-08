<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personalizador 3D - Sombreros La Herradura</title>
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"></script>
    <style>
        .Contenido { 
            font-family: Arial, sans-serif; 
            display: flex; 
            background-color: #f4f4f9; 
            padding: 20px;
        }

        .visor-container { 
            flex: 2; 
            background: #fff; 
            border-radius: 10px; 
            height: 80vh; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);  
            margin-top: 7rem;
        }

        model-viewer { 
            width: 100%; 
            height: 100%; 
        }

        .controles-container { 
            flex: 1; 
            margin-left: 20px; 
            padding: 20px; 
            background: #fff; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
            margin-top: 9rem;
        }

        h2 { 
            border-bottom: 2px solid #333; 
            padding-bottom: 10px; 
        
        }
        .control-group { 
            margin-bottom: 20px; 
        }

        label { 
            display: block; 
            font-weight: bold; 
            margin-bottom: 8px; 
            font-size: 14px;
        }

        .color-btn { 
            width: 35px; 
            height: 35px; 
            border-radius: 50%; 
            border: 2px solid #ccc; 
            cursor: pointer; 
            margin-right: 5px; 
        }

        input[type="range"] { width: 100%; cursor: pointer; }

        .btn_tt {
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 3px 5px rgb(0, 0, 0); 
            border: none; }

    </style>
    <link rel="shortcut icon" href="../../images/Logo_Herradura_head3.png" type="image/x-icon">
</head>
<header>
        <?php 
        include('../../includes/header.php');
        ?>
</header>
<body>
    
    <div class="Contenido">
        <div class="visor-container">
            <model-viewer id="visor-sombrero" src="texana_CUSTOM_08_04_v2.glb" camera-controls auto-rotate shadow-intensity="0.5"></model-viewer>
        </div>

        <div class="controles-container">
            <h2>Personaliza tu Texana</h2>

            <div class="control-group">
                <label>Color del Fieltro (Gamuza):</label>
                <button class="color-btn" style="background-color: #000000;" onclick="cambiarColorFieltro([0.05, 0.05, 0.05, 1])"></button>
                <button class="color-btn" style="background-color: #8B4513;" onclick="cambiarColorFieltro([0.54, 0.27, 0.07, 1])"></button>
                <button class="color-btn" style="background-color: #262626;" onclick="cambiarColorFieltro([0.15, 0.15, 0.15, 1])"></button>
                <button class="color-btn" style="background-color: #402614;" onclick="cambiarColorFieltro([0.25, 0.15, 0.08, 1])"></button>
                <button class="color-btn" style="background-color: #66050D;" onclick="cambiarColorFieltro([0.40, 0.02, 0.05, 1])"></button>
            </div>

            <div class="control-group">
                <label>Color de la Cinta:</label>
                <button class="color-btn" style="background-color: #000000;" onclick="cambiarColorCinta([0.05, 0.05, 0.05, 1])"></button>
                <button class="color-btn" style="background-color: #8B4513;" onclick="cambiarColorCinta([0.54, 0.27, 0.07, 1])"></button>
                <button class="color-btn" style="background-color: #262626;" onclick="cambiarColorCinta([0.15, 0.15, 0.15, 1])"></button>
                <button class="color-btn" style="background-color: #402614;" onclick="cambiarColorCinta([0.25, 0.15, 0.08, 1])"></button>
                <button class="color-btn" style="background-color: #66050D;" onclick="cambiarColorCinta([0.40, 0.02, 0.05, 1])"></button>
            </div>

            <div class="control-group">
                <label>Altura de la Copa:</label>
                <input type="range" id="copaSlider" min="0" max="1" step="0.05" value="0">
            </div>

            <div class="control-group">
                <label>Ancho del Ala:</label>
                <input type="range" id="alaSlider" min="0" max="1" step="0.05" value="0">
            </div>

            <div class="control-group">
                <label>Curvatura del Ala (Estilo):</label>
                <input type="range" id="curvaSlider" min="0" max="1" step="0.05" value="0">
            </div>

            <button class="btn_tt">
                <li style="list-style: none;">
                    <a href="https://www.tiktok.com/referral/v1/filter/ID_DE_TU_FILTRO" target="_blank" style="display: flex; align-items: center; text-decoration: none; color: #000000; font-family: sans-serif; font-weight: bold; font-size: 18px;">
                        <img src="https://cdn-icons-png.flaticon.com/512/3046/3046121.png" alt="TikTok" style="width: 40px; margin-right: 8px;">
                        <span>¡Prueba nuestro filtro en Tik Tok!</span>
                    </a>
                </li>
            </button>
        </div>
    </div>

    <script>
        const modelViewer = document.querySelector('model-viewer#visor-sombrero');

        // MUY IMPORTANTE: Esperar a que el modelo cargue para que no de error "null"
        modelViewer.addEventListener('load', () => {
            
            console.log("Modelo cargado. Configurando controles...");

            // 1. Lógica de Colores (Hacemos las funciones globales para el onclick)
            window.cambiarColorFieltro = function(colorRGB) {
                // Usamos includes() por si Blender le cambia el nombre ligeramente
                const material = modelViewer.model.materials.find(m => m.name.includes("Mat_Gamuza"));
                if (material) material.pbrMetallicRoughness.setBaseColorFactor(colorRGB);
            };

            window.cambiarColorCinta = function(colorRGB) {
                const material = modelViewer.model.materials.find(m => m.name.includes("Mat_Cinta"));
                if (material) material.pbrMetallicRoughness.setBaseColorFactor(colorRGB);
            };

            // 2. Lógica de Forma (El hack para acceder a los Shape Keys)
            const sceneSymbol = Object.getOwnPropertySymbols(modelViewer).find(x => x.description === 'scene');
            const internalScene = modelViewer[sceneSymbol];

            function actualizarForma(nombreVariable, valor) {
                if (!internalScene) return;
                
                // Recorremos la estructura interna buscando las mallas 3D
                internalScene.traverse((nodo) => {
                    if (nodo.isMesh && nodo.morphTargetDictionary) {
                        const indice = nodo.morphTargetDictionary[nombreVariable];
                        if (indice !== undefined) {
                            // Aplicamos la fuerza de la deformación (de 0 a 1)
                            nodo.morphTargetInfluences[indice] = parseFloat(valor);
                        }
                    }
                });
            }

            // 3. Conectar Sliders
            document.getElementById('copaSlider').addEventListener('input', (e) => actualizarForma('Altura_Copa', e.target.value));
            document.getElementById('alaSlider').addEventListener('input', (e) => actualizarForma('Ancho_Ala', e.target.value));
            document.getElementById('curvaSlider').addEventListener('input', (e) => actualizarForma('Curvatura', e.target.value));
            
        });
    </script>
</body>
<footer>
        <?php 
        include('../../includes/footer.php')
        ?>
    </footer>
</html>