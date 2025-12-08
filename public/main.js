/* * Archivo: main.js
 * Responsabilidad: Lógica global del sitio (Menú, Login, Registro, Footer)
 * Requiere: alertas.js (cargado antes en el HTML)
 */

document.addEventListener('DOMContentLoaded', () => {

    // =======================================================
    // 1. LÓGICA DE INICIO DE SESIÓN (LOGIN) - CON VALIDACIONES
    // =======================================================
    const loginForm = document.getElementById('loginForm');
    const loginError = document.getElementById('loginError'); // Opcional

    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            // 1. ¡CRUCIAL! Evita que el formulario se mande solo
            event.preventDefault(); 
            
            // 2. OBTENER LOS CAMPOS (Asegúrate que los IDs coincidan con tu HTML)
            // He puesto 'correoLogin' y 'passwordLogin'. Revisa tu HTML.
            const emailInput = document.getElementById('correoLogin'); 
            const passInput = document.getElementById('passwordLogin');
            
            const email = emailInput ? emailInput.value.trim() : '';
            const pass = passInput ? passInput.value.trim() : '';

            // 3. BLOQUE DE VALIDACIONES (Aquí es donde frenamos todo)
            
            // A) Validar campos vacíos
            if (email === '' || pass === '') {
                Alerta.error("Por favor, completa todos los campos.");
                // Ponemos el foco en el campo vacío
                if(email === '') emailInput.focus();
                else passInput.focus();
                return; // <--- ESTO DETIENE EL ENVÍO A LA BASE DE DATOS
            }

            // B) Validar formato de correo (Opcional pero recomendado)
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                Alerta.error("El formato del correo no es válido.");
                emailInput.focus();
                return; // <--- DETIENE EL ENVÍO
            }

            // 4. SI PASA LAS VALIDACIONES, PREPARAMOS EL ENVÍO
            if(loginError) loginError.textContent = ''; // Limpiamos errores viejos

            const btnSubmit = loginForm.querySelector('button[type="submit"]');
            const textoOriginal = btnSubmit ? btnSubmit.innerText : 'Entrar';
            
            if(btnSubmit) {
                btnSubmit.innerText = "Verificando...";
                btnSubmit.disabled = true; // Evita doble clic
            }

            const formData = new FormData(loginForm);

            // 5. ENVIAMOS AL SERVIDOR (PHP)
            fetch('/LaHerradura/Controller/InicioSesion.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) 
            .then(data => {
                // Restauramos el botón
                if(btnSubmit) {
                    btnSubmit.innerText = textoOriginal;
                    btnSubmit.disabled = false;
                }

                console.log("Respuesta Login:", data);

                if (data.status === 'success') {
                    // --- ÉXITO ---
                    if (data.role === 'admin') {
                        Alerta.exito('Bienvenido Administrador.')
                            .then(() => {
                                window.location.href = '/LaHerradura/View/pages/admin/pedidos.php'; 
                            });
                    } else {
                        Alerta.toast('¡Bienvenido de nuevo!');
                        // Cerrar modal y actualizar UI...
                        const modalLogin = document.getElementById('modal-Login');
                        if(modalLogin) modalLogin.style.display = 'none';
                        loginForm.reset();
                    }
                } else {
                    // --- ERROR DESDE PHP (Contraseña mal, usuario no existe) ---
                    Alerta.error(data.message || 'Usuario o contraseña incorrectos.');
                }
            })
            .catch(error => {
                console.error('Error login:', error);
                Alerta.error('Error de conexión con el servidor.');
                if(btnSubmit) {
                    btnSubmit.innerText = textoOriginal;
                    btnSubmit.disabled = false;
                }
            });
        });
    }

    // ==========================================
    // 2. LÓGICA DE LOGIN (Similar al registro)
    // ==========================================
    const formLogin = document.getElementById('form-login'); // Asegúrate que tu form tenga este ID
    
    if (formLogin) {
        formLogin.addEventListener('submit', function (e) {
            e.preventDefault();
            
            // ... Aquí iría la lógica fetch parecida a la de registro ...
            // Si quieres te la puedo escribir completa después.
            console.log("Intentando iniciar sesión...");
        });
    }

    // ==========================================
    // 3. UTILIDADES GLOBALES (Ejemplos)
    // ==========================================
    
    // Ejemplo: Actualizar año en el footer automáticamente
    const yearSpan = document.getElementById('current-year');
    if(yearSpan) {
        yearSpan.innerText = new Date().getFullYear();
    }

    // Ejemplo: Menú Hamburguesa (Si lo tienes)
    const menuBtn = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    if(menuBtn && navLinks) {
        menuBtn.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    }

    // =======================================================
    // 4. LÓGICA DE REGISTRO DE ADMINISTRADOR (Validaciones extra)
    // =======================================================
    const formAdmin = document.getElementById('form-registroAdmin');

    if (formAdmin) {
        formAdmin.addEventListener('submit', function (e) {
            e.preventDefault();

            const pass1 = document.getElementById("passwordAdmin1");
            const pass2 = document.getElementById("passwordAdmin2");
            
            // --- VALIDACIONES PREVIAS (Antes de enviar) ---
            
            // 1. Campos vacíos
            if (!pass1.value.trim() || !pass2.value.trim()) {
                Alerta.error("Ambas contraseñas son obligatorias.");
                return;
            }

            // 2. Longitud
            if (pass1.value.length < 8) {
                Alerta.error("La contraseña debe tener al menos 8 caracteres.");
                pass1.focus();
                return;
            }

            // 3. Coincidencia
            if (pass1.value !== pass2.value) {
                Alerta.error("Las contraseñas no coinciden.");
                pass2.focus();
                return;
            }

            // --- SI TODO ESTÁ BIEN, ENVIAMOS ---
            const btnSubmit = formAdmin.querySelector('button[type="submit"]');
            const textoOriginal = btnSubmit ? btnSubmit.innerText : 'Registrar Admin';
            
            if(btnSubmit) {
                btnSubmit.innerText = "Procesando...";
                btnSubmit.disabled = true;
            }

            const formData = new FormData(this);

            fetch(this.action, {
                method: this.method,
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if(btnSubmit) {
                    btnSubmit.innerText = textoOriginal;
                    btnSubmit.disabled = false;
                }

                if (data.includes("correctamente") || data.includes("exitoso")) {
                    Alerta.exito('Administrador registrado correctamente.')
                        .then(() => {
                            // Cerrar modal y limpiar
                            const modalAdmin = document.getElementById('modal-RegAdmin'); // Ajusta el ID si es diferente
                            if(modalAdmin) modalAdmin.style.display = 'none';
                            formAdmin.reset();
                        });
                } else {
                    Alerta.error(data || "Error al registrar administrador.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Alerta.error('Error de conexión.');
                if(btnSubmit) {
                    btnSubmit.innerText = textoOriginal;
                    btnSubmit.disabled = false;
                }
            });
        });
    }

}); // <--- AQUÍ TERMINA EL DOMContentLoaded


// =======================================================
// 5. FUNCIÓN GLOBAL: MOSTRAR/OCULTAR CONTRASEÑA
// =======================================================
// Esta función va FUERA del DOMContentLoaded para que el HTML la encuentre fácil.

function toggleVisibility(idInput) {
    const input = document.getElementById(idInput);
    if (input) {
        input.type = input.type === "password" ? "text" : "password";
    } else {
        console.warn(`No se encontró el input con id="${idInput}"`);
    }
}
