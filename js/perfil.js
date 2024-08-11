function togglePassword() {
    var passwordField = document.getElementById("contraseña");
    var toggleButton = event.currentTarget;
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleButton.textContent = "Ocultar";
    } else {
        passwordField.type = "password";
        toggleButton.textContent = "Mostrar";
    }
}