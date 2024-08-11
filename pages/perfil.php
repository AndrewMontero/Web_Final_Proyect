<?php
require '../shared/header.php';
session_start();
require_once "../utils/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

$userId = $_SESSION['user_id'];

$sql = "SELECT nombre, apellido, telefono, direccion, email FROM usuarios WHERE id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($nombre, $apellido, $telefono, $direccion, $email);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Error en la consulta: " . $mysqli->error;
}

$mysqli->close();
?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h4>Editar Perfil</h4>
                    </div>
                    <div class="card-body">
                        <form action="../actions/editUser.php" method="POST">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="apellido">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($apellido); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($direccion); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="contraseña">Nueva Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Ingrese una nueva contraseña (opcional)">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">Mostrar</button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="index.html">Volver a la página principal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/perfil.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
</body>

</html>
