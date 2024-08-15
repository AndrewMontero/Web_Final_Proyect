function validateForm() {
    const telefono = document.getElementById('telefono').value;
    const contraseña = document.getElementById('contraseña').value;

    // Validación de número de teléfono (debe tener 8 dígitos)
    if (!/^\d{8}$/.test(telefono)) {
        alert('El número de teléfono debe contener exactamente 8 dígitos.');
        return false;
    }

    // Validación de contraseña (mínimo 8 caracteres)
    if (contraseña.length < 8) {
        alert('La contraseña debe tener al menos 8 caracteres.');
        return false;
    }

    return true; // Si todas las validaciones pasan, permite el envío del formulario
}