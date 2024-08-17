<?php
require '../shared/header.php';
require '../actions/loadData.php';
require '../utils/database.php';

// Obtener pedidos del usuario logueado
$sql = "SELECT nombre, precio, cantidad FROM compras WHERE user_id = ?";
$pedidos = [];

if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $pedidos[] = $row;
    }
    $stmt->close();
} else {
    echo "Error al obtener los pedidos: " . $mysqli->error;
}

$mysqli->close();
?>

<link rel="stylesheet" href="/styles/perfil.css">

<body>
    <div class="container">
        <div class="row">
            <!-- Tabla de editar perfil -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Editar Perfil</h4>
                    </div>
                    <div class="card-body">
                        <form action="/actions/editUser.php" method="POST">
                            <!-- Campos del perfil -->
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
                                <label for="contraseña">Contraseña</label>
                                <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Ingrese su contraseña" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabla de mis pedidos -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-secondary text-white">
                        <h4>Mis Pedidos</h4>
                    </div>
                    <div class="card-body">
                        <?php if (empty($pedidos)): ?>
                            <p>No tienes pedidos registrados.</p>
                        <?php else: ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pedidos as $pedido): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($pedido['nombre']); ?></td>
                                            <td>₡<?php echo htmlspecialchars($pedido['precio']); ?></td>
                                            <td><?php echo htmlspecialchars($pedido['cantidad']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>

</html>