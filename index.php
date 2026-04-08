<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sombreros La Herradura</title>
    <link rel="icon" type="image/x-icon" href="/LaHerradura/assets/images/favicon.ico">
    <link rel="stylesheet" href="/LaHerradura/View/css/style-Inicio.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="View/images/Logo_Herradura_head3.png">
</head>
<body>
    <header>
        <?php 
        define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/LaHerradura/');
        include(ROOT_PATH . 'View/includes/header.php')
        ?>
    </header>   
    
    <main>

    <section class="hat-bubbles">
        <div class="font-circles">
            <div class="principal">
                <h2>Sombreros La Herradura: Tradición y estilo bajo el sol</h2>
            </div>

            <div class="hat-bubbles__inner" id="bubbleContainer">
                
                <div id="bubblePill" class="bubble-pill"></div>
                
                <div id="bubbleTextContainer" class="bubble-text-container">
                    <p id="bubbleTextContent" class="bubble-text-content"></p>
                </div>
                
                <div id="avatarsHtmlContainer"></div>

                <div id="bubbleDots" class="bubble-dots"></div>
            </div>

            <div class="principal">
                <h2>Encuentra el sombrero vaquero perfecto que cuenta tu historia.</h2>
            </div>
        </div>
    </section>
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
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-puzzle-fill" viewBox="0 0 16 16">
                <path d="M3.112 3.645A1.5 1.5 0 0 1 4.605 2H7a.5.5 0 0 1 .5.5v.382c0 .696-.497 1.182-.872 1.469a.5.5 0 0 0-.115.118l-.012.025L6.5 4.5v.003l.003.01q.005.015.036.053a.9.9 0 0 0 .27.194C7.09 4.9 7.51 5 8 5c.492 0 .912-.1 1.19-.24a.9.9 0 0 0 .271-.194.2.2 0 0 0 .036-.054l.003-.01v-.008l-.012-.025a.5.5 0 0 0-.115-.118c-.375-.287-.872-.773-.872-1.469V2.5A.5.5 0 0 1 9 2h2.395a1.5 1.5 0 0 1 1.493 1.645L12.645 6.5h.237c.195 0 .42-.147.675-.48.21-.274.528-.52.943-.52.568 0 .947.447 1.154.862C15.877 6.807 16 7.387 16 8s-.123 1.193-.346 1.638c-.207.415-.586.862-1.154.862-.415 0-.733-.246-.943-.52-.255-.333-.48-.48-.675-.48h-.237l.243 2.855A1.5 1.5 0 0 1 11.395 14H9a.5.5 0 0 1-.5-.5v-.382c0-.696.497-1.182.872-1.469a.5.5 0 0 0 .115-.118l.012-.025.001-.006v-.003l-.003-.01a.2.2 0 0 0-.036-.053.9.9 0 0 0-.27-.194C8.91 11.1 8.49 11 8 11s-.912.1-1.19.24a.9.9 0 0 0-.271.194.2.2 0 0 0-.036.054l-.003.01v.002l.001.006.012.025c.016.027.05.068.115.118.375.287.872.773.872 1.469v.382a.5.5 0 0 1-.5.5H4.605a1.5 1.5 0 0 1-1.493-1.645L3.356 9.5h-.238c-.195 0-.42.147-.675.48-.21.274-.528.52-.943.52-.568 0-.947-.447-1.154-.862C.123 9.193 0 8.613 0 8s.123-1.193.346-1.638C.553 5.947.932 5.5 1.5 5.5c.415 0 .733.246.943.52.255.333.48.48.675.48h.238z"/>
            </svg>
            <div>
                <h5 class="txt-info-central-tittle">Materiales</h5>
                <h6 class="txt-info-central-text">100% Genuinos</h6>
            </div>
        </div>
        <div class="space-info-central">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-check2-square" viewBox="0 0 16 16">
                <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z"/>
                <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0"/>
            </svg>
            <div>
                <h5 class="txt-info-central-tittle">Calidad</h5>
                <h6 class="txt-info-central-text">Cada producto es hecho <br>con la mayor delicadeza</h6>
            </div>
        </div>
        <div class="space-info-central">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
            </svg>
            <div>
                <h5 class="txt-info-central-tittle">Envíos gratis</h5>
                <h6 class="txt-info-central-text">a todo México</h6>
            </div>
        </div>
        <div class="space-info-central">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
            </svg>
            <div>
                <h5 class="txt-info-central-tittle">Empaquetados</h5>
                <h6 class="txt-info-central-text">con la mayor delicadeza</h6>
            </div>
        </div>
    </div>

    <div class="legado">
        <h5 class="legado-Tittle">Nuestro legado</h5>
        <h6 class="legado-Text">
            Herederos de más de 80 años en la fabricación original de botas vaqueras hechas a mano, 
            nos hemos dado a la tarea de innovar para mejorar constantemente, incorporando nuevas técnicas 
            a la fabricación tradicional, sin olvidar que en las artesanías la mano del hombre difícilmente 
            puede sustituirse.
        </h6>

        <!-- Video de YouTube incrustado -->
        <div class="video-container" style="margin-top:20px;">
            <iframe width="560" height="315" 
                src="https://www.youtube.com/embed/e9h106V6c1A" 
                title="YouTube video player" 
                frameborder="0" 
                allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
            </iframe>
        </div>
    </div>


    <div class="ubicacion">
        <div class="ubicacion-izquierda">
            <h4 class="ubicacion-text">VISÍTANOS EN TIENDA</h4>
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
            </svg>
        </div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3737.6344290008683!2d-99.2524060888278!3d20.48020280631361!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d3e17cceb86e89%3A0x9e00d3c99095edd2!2sSombreros%20La%20Herradura!5e0!3m2!1ses-419!2smx!4v1760855304397!5m2!1ses-419!2smx" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    </main>

    <footer>
        <?php 
        include(ROOT_PATH . 'View/includes/footer.php')
        ?>
    </footer>
    
    <script>
    const POS = {
        introPositions: [20, 32, 44, 56, 68, 80], 
        
        active: {
            anchor: 20,       
            textGap: 42,       
            stackStep: 5,      
            sizeMain: 250,     
            sizeStack: 200     
        },
        
        mobile: {
            anchor: 50,        
            stackStep: 12,     
            sizeMain: 130,
            sizeStack: 50,
            mainTop: '35%',
            stackTop: '80%'
        }
    };

    const statesData = [
        { text: "Tradición con actitud:<br>ponte el sombrero", img: "assets/images/a1.png" },
        { text: "Estilo que impone,<br>sombrero que responde", img: "assets/images/a2.png" },
        { text: "Tu sombrero,<br>tu sello personal", img: "assets/images/a3.png" },
        { text: "Luce como vaquero,<br>vive como leyenda", img: "assets/images/a4.png" },
        { text: "Del rancho al asfalto,<br>siempre auténtico", img: "assets/images/a5.png" },
        { text: "No es moda,<br>es identidad vaquera", img: "assets/images/a6.png" }
    ];

    let currentIndex = -1; 
    let isMobile = window.innerWidth <= 850;

    const avatarsContainer = document.getElementById('avatarsHtmlContainer');
    const pillEl = document.getElementById('bubblePill');
    const textContainerEl = document.getElementById('bubbleTextContainer');
    const textContentEl = document.getElementById('bubbleTextContent');
    const dotsEl = document.getElementById('bubbleDots');
    let avatarsElements = []; 

    function init() {
        statesData.forEach((state, index) => {
            const img = document.createElement('img');
            img.src = state.img;
            img.className = 'avatar-anim';
            img.addEventListener('click', (e) => {
                e.stopPropagation();
                handleBubbleClick(index);
            });
            avatarsContainer.appendChild(img);
            avatarsElements.push(img);

            const dot = document.createElement('span');
            dot.className = 'bubble-dot';
            dotsEl.appendChild(dot);
        });

        updateView();
        window.addEventListener('resize', () => {
            isMobile = window.innerWidth <= 850;
            updateView();
        });
    }

    function handleBubbleClick(clickedIndex) {
        if (clickedIndex === currentIndex) {
            currentIndex = -1; 
        } else {
            currentIndex = clickedIndex;
        }
        updateView();
    }

    function updateView() {
        const dots = document.querySelectorAll('.bubble-dot');

        if (currentIndex === -1) {
            pillEl.classList.remove('is-open');
            pillEl.style.width = '0px';
            pillEl.style.opacity = '0';
            
            textContainerEl.classList.remove('is-visible');
            
            avatarsElements.forEach((img, idx) => {
                img.style.left = POS.introPositions[idx] + '%';
                img.style.top = '50%';
                img.style.width = (isMobile ? POS.mobile.sizeStack : POS.active.sizeStack) + 'px';
                img.style.height = (isMobile ? POS.mobile.sizeStack : POS.active.sizeStack) + 'px';
                img.style.zIndex = 10;
                img.style.borderWidth = '4px';
            });
            dots.forEach(d => d.classList.remove('is-active'));
            return;
        }
        
        textContainerEl.classList.remove('is-visible');
        setTimeout(() => {
            textContentEl.innerHTML = statesData[currentIndex].text;
            textContainerEl.classList.add('is-visible');
        }, 150);

        const anchor = isMobile ? POS.mobile.anchor : POS.active.anchor;
        const step = isMobile ? POS.mobile.stackStep : POS.active.stackStep;
        
       // ... (resto del código de updateView)
        avatarsElements.forEach((img, idx) => {
            let finalLeft, zIndex, size, topPos = '50%', borderW = '3px';

            if (idx === currentIndex) {
                finalLeft = anchor; 
                zIndex = 50;        
                size = isMobile ? POS.mobile.sizeMain : POS.active.sizeMain;
                topPos = isMobile ? POS.mobile.mainTop : '50%';
                borderW = '0px'; 

                if(!isMobile){
                    pillEl.style.left = (anchor) + '%'; 
                    pillEl.style.width = (POS.active.textGap + 13) + '%'; 
                    pillEl.style.opacity = '1';
                    pillEl.style.transform = 'translateY(-50%)'; // <-- RESETEA EN ESCRITORIO
                    
                    textContainerEl.style.left = (anchor + 12) + '%';
                    textContainerEl.style.transform = 'translateY(-50%)';
                }
            } 
            // ... (resto de las condiciones else if y else)  
            else if (idx < currentIndex) {
                const distance = currentIndex - idx;
                finalLeft = anchor - (distance * step);
                
                zIndex = 40 - distance; 
                size = isMobile ? POS.mobile.sizeStack : POS.active.sizeStack;
                topPos = isMobile ? POS.mobile.stackTop : '50%';
                
                if (isMobile) {
            pillEl.style.left = '50%';
            pillEl.style.width = '90%';
            pillEl.style.opacity = '1';
            pillEl.style.transform = 'translate(-50%, -50%)';  // <-- ESTA LÍNEA CENTRA LA CAJA BLANCA
            
            textContainerEl.style.left = '50%'; 
            textContainerEl.style.transform = 'translate(-50%, -50%)'; 
        } else {
            textContainerEl.style.transform = 'translateY(-50%)'; 
        } 
            } 
            else {
                const distance = idx - currentIndex;
                
                if (isMobile) {
                    finalLeft = 50 + (distance * step) + 15;
                    topPos = POS.mobile.stackTop;
                } else {
                    finalLeft = anchor + POS.active.textGap + (distance * step); 
                }

                zIndex = 40 - distance;
                size = isMobile ? POS.mobile.sizeStack : POS.active.sizeStack;
            }

            img.style.left = finalLeft + '%';
            img.style.top = topPos;
            img.style.width = size + 'px';
            img.style.height = size + 'px';
            img.style.zIndex = zIndex;
            img.style.borderWidth = borderW;
        });

        if (isMobile) {
            pillEl.style.left = '50%';
            pillEl.style.width = '90%';
            pillEl.style.opacity = '1';
            textContainerEl.style.left = '50%'; 
            textContainerEl.style.transform = 'translate(-50%, -50%)'; 
        } else {
            textContainerEl.style.transform = 'translateY(-50%)'; 
        }

        dots.forEach((d, i) => d.classList.toggle('is-active', i === currentIndex));
    }

    init();
    </script>
</body>
</html>