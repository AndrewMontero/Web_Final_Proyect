function togglePassword() {
    var passwordField = document.getElementById("contraseña");
    var toggleButton = event.currentTarget;
    var icon = toggleButton.querySelector("i");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}