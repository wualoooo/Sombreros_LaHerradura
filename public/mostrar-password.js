document.addEventListener("DOMContentLoaded", function() {

    const formulario = document.getElementById("form-registroAdmin");
    const pass1 = document.getElementById("passwordAdmin1");
    const pass2 = document.getElementById("passwordAdmin2");
    const mensajeError = document.getElementById("mensajeError");

    if (!formulario || !pass1 || !pass2) return;

    formulario.addEventListener("submit", function(evento) {
        const v1 = pass1.value.trim();
        const v2 = pass2.value.trim();

        if (!v1 || !v2) {
            if (mensajeError) mensajeError.textContent = "Ambas contraseñas son obligatorias.";
            evento.preventDefault();
            (v1 ? pass2 : pass1).focus();
            return;
        }

        if (v1.length < 8) {
            if (mensajeError) mensajeError.textContent = "La contraseña debe tener al menos 8 caracteres.";
            evento.preventDefault();
            pass1.focus();
            return;
        }

        if (v1 !== v2) {
            if (mensajeError) mensajeError.textContent = "Las contraseñas no coinciden.";
            evento.preventDefault();
            pass2.focus();
        } else {
            if (mensajeError) mensajeError.textContent = "";
        }
    });
});

function togglePassword() {
    const input = document.getElementById("password");
    input.type = input.type === "password" ? "text" : "password";
}

function togglePassword2() {
    const input = document.getElementById("password2");
    input.type = input.type === "password" ? "text" : "password";
}

function togglePassword3() {
    const input = document.getElementById("password3");
    input.type = input.type === "password" ? "text" : "password";
}

function togglePassword4() {
    const input = document.getElementById("passwordAdmin1");
    input.type = input.type === "password" ? "text" : "password";
}

function togglePassword5() {
    const input = document.getElementById("passwordAdmin2");
    input.type = input.type === "password" ? "text" : "password";
}