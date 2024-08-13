<?php
require '../shared/header.php';
?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Registro</h4>
                    </div>
                    <div class="card-body">
                        <form action="/actions/register.php" method="POST" onsubmit="return validateForm()">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="apellido">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingrese su apellido" required>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ingrese su teléfono" required pattern="[0-9]{10}">
                                <small class="form-text text-muted">Debe contener 10 dígitos.</small>
                            </div>
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ingrese su dirección" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese su email" required>
                            </div>
                            <div class="form-group">
                                <label for="contraseña">Contraseña</label>
                                <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Ingrese su contraseña" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="login.php">¿Ya tienes una cuenta? Inicia sesión aquí</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            const telefono = document.getElementById('telefono').value;
            const contraseña = document.getElementById('contraseña').value;

            // Validación de número de teléfono (debe tener 10 dígitos)
            if (!/^\d{10}$/.test(telefono)) {
                alert('El número de teléfono debe contener 10 dígitos.');
                return false;
            }

            // Validación de contraseña (mínimo 8 caracteres)
            if (contraseña.length < 8) {
                alert('La contraseña debe tener al menos 8 caracteres.');
                return false;
            }

            return true; // Si todas las validaciones pasan, permite el envío del formulario
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
