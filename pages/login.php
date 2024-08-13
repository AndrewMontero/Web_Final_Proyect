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
                        <form action="/models/register.php" method="POST" onsubmit="return validateForm()">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese su email" required>
                            </div>
                            <div class="form-group">
                                <label for="contraseña">Contraseña</label>
                                <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Ingrese su contraseña" required>
                            </div>
                            <div class="form-group">
                                <label for="confirmarContraseña">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="confirmarContraseña" name="confirmarContraseña" placeholder="Confirme su contraseña" required>
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
            const password = document.getElementById('contraseña').value;
            const confirmPassword = document.getElementById('confirmarContraseña').value;

            if (password !== confirmPassword) {
                alert('Las contraseñas no coinciden.');
                return false;
            }

            // Puedes agregar más validaciones aquí según sea necesario

            return true;
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
