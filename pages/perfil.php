<?php
require '../shared/header.php';
require '../actions/loadData.php'
?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Editar Perfil</h4>
                    </div>
                    <div class="card-body">
                        <form action="/actions/editUser.php" method="POST">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="Deivis" required>
                            </div>
                            <div class="form-group">
                                <label for="apellido">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" value="Jiménez Montero" required>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" value="89482317" required>
                            </div>
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" value="San Ramon" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="deivisjm1205@gmail.com" required>
                            </div>
                            <div class="form-group form-control-container">
                                <label for="contraseña">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Nueva Contraseña">
                                <button type="button" class="toggle-password" onclick="togglePassword()">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/perfil.js"> </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

</body>

</html>