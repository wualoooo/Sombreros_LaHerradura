<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/LaHerradura/View/css/style-Inicio.css">
    <link rel="stylesheet" href="/LaHerradura/View/css/style-login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <?php 
        define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
        include(ROOT_PATH . 'View/includes/header.php')
        ?>
    </header>
    
    <main>


        <!-- === INICIO: Burbuja interactiva (1 burbuja, 6 estados) === -->
    <section class="hat-bubbles">
    <div class="font-circles">

        <div class="principal">
        <h2>Sombreros La Herradura: Tradición y estilo bajo el sol</h2>
        </div>

        <div class="hat-bubbles__inner">
        <!-- Burbuja única (clickeable) -->
        <div id="hatBubble" class="bubble bubble--single" role="button" tabindex="0"
            aria-label="Cambiar estado" title="Haz clic para cambiar">
            <div id="bubbleLeft" class="bubble__side"></div>
            <div id="bubbleText" class="bubble__text"></div>
            <div id="bubbleRight" class="bubble__side"></div>
        </div>

        <!-- Indicador opcional (puntitos) -->
        <div id="bubbleDots" class="bubble-dots" aria-hidden="true"></div>
        </div>

        <!-- Aquí metes el segundo título -->
        <div class="principal">
        <h2>Encuentra el sombrero vaquero perfecto que cuenta tu historia.</h2>
        </div>

    </div>
    </section>
        <!-- === FIN: Burbuja interactiva === -->



    <div class="three-category">
        <div class="category">
            <img src="assets/images/Category1.png" alt="">
        </div>
        <div class="category">
            <img src="assets/images/Category2.png" alt="">
        </div>
        <div class="category">
            <img src="assets/images/Category3.png" alt="">
        </div>
    </div>

    <div class="info-central">
        <div class="space-info-central">
            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-puzzle-fill" viewBox="0 0 16 16">
                <path d="M3.112 3.645A1.5 1.5 0 0 1 4.605 2H7a.5.5 0 0 1 .5.5v.382c0 .696-.497 1.182-.872 1.469a.5.5 0 0 0-.115.118l-.012.025L6.5 4.5v.003l.003.01q.005.015.036.053a.9.9 0 0 0 .27.194C7.09 4.9 7.51 5 8 5c.492 0 .912-.1 1.19-.24a.9.9 0 0 0 .271-.194.2.2 0 0 0 .036-.054l.003-.01v-.008l-.012-.025a.5.5 0 0 0-.115-.118c-.375-.287-.872-.773-.872-1.469V2.5A.5.5 0 0 1 9 2h2.395a1.5 1.5 0 0 1 1.493 1.645L12.645 6.5h.237c.195 0 .42-.147.675-.48.21-.274.528-.52.943-.52.568 0 .947.447 1.154.862C15.877 6.807 16 7.387 16 8s-.123 1.193-.346 1.638c-.207.415-.586.862-1.154.862-.415 0-.733-.246-.943-.52-.255-.333-.48-.48-.675-.48h-.237l.243 2.855A1.5 1.5 0 0 1 11.395 14H9a.5.5 0 0 1-.5-.5v-.382c0-.696.497-1.182.872-1.469a.5.5 0 0 0 .115-.118l.012-.025.001-.006v-.003l-.003-.01a.2.2 0 0 0-.036-.053.9.9 0 0 0-.27-.194C8.91 11.1 8.49 11 8 11s-.912.1-1.19.24a.9.9 0 0 0-.271.194.2.2 0 0 0-.036.054l-.003.01v.002l.001.006.012.025c.016.027.05.068.115.118.375.287.872.773.872 1.469v.382a.5.5 0 0 1-.5.5H4.605a1.5 1.5 0 0 1-1.493-1.645L3.356 9.5h-.238c-.195 0-.42.147-.675.48-.21.274-.528.52-.943.52-.568 0-.947-.447-1.154-.862C.123 9.193 0 8.613 0 8s.123-1.193.346-1.638C.553 5.947.932 5.5 1.5 5.5c.415 0 .733.246.943.52.255.333.48.48.675.48h.238z"/>
            </svg>
            <div>
                <h5 class="txt-info-central-tittle">
                    Materiales
                </h5>
                <h6 class="txt-info-central-text">
                    100% Genuinos
                </h6>
            </div>
        </div>
        <div class="space-info-central">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-check2-square" viewBox="0 0 16 16">
                <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z"/>
                <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0"/>
            </svg>
            <div>
                <h5 class="txt-info-central-tittle">
                    Calidad
                </h5>
                <h6 class="txt-info-central-text">
                    Cada producto es hecho <br>
                    con la mayor delicadeza
                </h6>
            </div>
        </div>
        <div class="space-info-central">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
            </svg>
            <div>
                <h5 class="txt-info-central-tittle">
                    Envíos gratis
                </h5>
                <h6 class="txt-info-central-text">
                    a todo México
                </h6>
            </div>
        </div>
        <div class="space-info-central">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
            </svg>
            <div>
                <h5 class="txt-info-central-tittle">
                    Empaquetados
                </h5>
                <h6 class="txt-info-central-text">
                    con  la mayor delicadeza
                </h6>
            </div>
        </div>
    </div>

    <div class="legado">
        <h5 class="legado-Tittle">
            Nuestro legado
        </h5>
        <h6 class="legado-Text">
            Herederos de más de 80 años en la fabricación original de botas vaqueras hechas a mano, nos hemos dado a la tarea de innovar para mejorar constantemente, incorporando nuevas técnicas a la fabricación tradicional, sin olvidar que en las artesanías la mano del hombre difícilmente puede sustituirse.
        </h6>
    </div>

    <div class="ubicacion">
        <div class="ubicacion-izquierda">
            <h4 class="ubicacion-text">
                VISITANOS EN TIENDA 
            </h4>
            <svg xmlns="http://www.w3.org/2000/svg" width="30%" height="30%" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
            </svg>
        </div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3737.6344290008683!2d-99.2524060888278!3d20.48020280631361!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d3e17cceb86e89%3A0x9e00d3c99095edd2!2sSombreros%20La%20Herradura!5e0!3m2!1ses-419!2smx!4v1760855304397!5m2!1ses-419!2smx" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    </main>

    <footer>
        <?php 
        include(ROOT_PATH . 'View/includes/footer.php')
        ?>
    </footer>
                <script>
        // =========================
        // 6 ESTADOS (edita aquí)
        // =========================
        const states = [
            {
            text: "Tradición con actitud:\nponte el sombrero",
            left:  ["assets/images/a1.png"],
            right: ["assets/images/a2.png","assets/images/a3.png","assets/images/a4.png","assets/images/a5.png","assets/images/a6.png"]
            },
            {
            text: "Estilo que impone,\nsombrero que responde",
            left:  ["assets/images/a1.png", "assets/images/a2.png"],
            right: ["assets/images/a3.png","assets/images/a4.png","assets/images/a5.png","assets/images/a6.png"]
            },
            {
            text: "Tu sombrero,\ntu sello personal",
            left:  ["assets/images/a1.png","assets/images/a2.png","assets/images/a3.png"],
            right: ["assets/images/a4.png","assets/images/a5.png","assets/images/a6.png"]
            },
            {
            text: "Luce como vaquero,\nvive como leyenda",
            left:  ["assets/images/a1.png","assets/images/a2.png","assets/images/a3.png","assets/images/a4.png"],
            right: ["assets/images/a5.png","assets/images/a6.png"]
            },
            {
            text: "Del rancho al asfalto,\nsiempre auténtico",
            left:  ["assets/images/a1.png","assets/images/a2.png","assets/images/a3.png","assets/images/a4.png","assets/images/a5.png"],
            right: ["assets/images/a6.png"]
            },
            {
            text: "No es moda,\nes identidad vaquera",
            left:  ["assets/images/a1.png","assets/images/a2.png","assets/images/a3.png","assets/images/a4.png","assets/images/a5.png","assets/images/a6.png"],
            right: []
            }
        ];

        // =========================
        // Helpers
        // =========================
        function buildAvatarStack(urls){
            const wrap = document.createElement("div");
            wrap.className = "avatar-stack";
            urls.forEach(url=>{
            const img = document.createElement("img");
            img.className = "avatar";
            img.src = url;
            img.alt = "avatar";
            wrap.appendChild(img);
            });
            return wrap;
        }

        function renderDots(activeIndex){
            const dotsHost = document.getElementById("bubbleDots");
            if(!dotsHost) return;
            dotsHost.innerHTML = "";

            states.forEach((_, idx)=>{
            const dot = document.createElement("span");
            dot.className = "bubble-dot" + (idx === activeIndex ? " is-active" : "");
            dotsHost.appendChild(dot);
            });
        }

        function setBubbleState(i){
            const state = states[i];
            if(!state) return;

            const leftHost  = document.getElementById("bubbleLeft");
            const rightHost = document.getElementById("bubbleRight");
            const textHost  = document.getElementById("bubbleText");

            leftHost.innerHTML = "";
            rightHost.innerHTML = "";
            textHost.innerHTML = "";

            leftHost.appendChild(buildAvatarStack(state.left));
            rightHost.appendChild(buildAvatarStack(state.right));
            textHost.innerHTML = String(state.text).replace(/\n/g, "<br>");

            renderDots(i);
        }

        // =========================
        // Interacción: click en la burbuja = siguiente estado
        // =========================
        let current = 0;

        function nextState(){
            current = (current + 1) % states.length;
            setBubbleState(current);
        }

        // Init
        setBubbleState(current);

        const bubble = document.getElementById("hatBubble");
        if(bubble){
            bubble.addEventListener("click", nextState);

            // Accesibilidad: Enter/Espacio también cambian estado
            bubble.addEventListener("keydown", (e)=>{
            if(e.key === "Enter" || e.key === " "){
                e.preventDefault();
                nextState();
            }
            // Opcional: Flechas para atrás/adelante
            if(e.key === "ArrowRight"){
                e.preventDefault();
                nextState();
            }
            if(e.key === "ArrowLeft"){
                e.preventDefault();
                current = (current - 1 + states.length) % states.length;
                setBubbleState(current);
            }
            });
        }
        </script>

</body>
</html>