<?php

require '../shared/header.php';

// Iniciar la sesión
session_start();

// Verificar si el array 'carrito' existe en la sesión
if (isset($_SESSION['carrito'])) {
    $carrito = $_SESSION['carrito'];
} else {
    $carrito = [];
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Carrito de Compras</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Presentación</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($carrito) > 0): ?>
                    <?php foreach ($carrito as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($producto['Marca']); ?></td>
                            <td><?php echo htmlspecialchars($producto['Presentación']); ?></td>
                            <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                            <td>₡<?php echo number_format($producto['Precio'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay productos en el carrito.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="dashboard.php" class="btn btn-primary">Seguir Comprando</a>
        </div>
    </div>
</body>

</html>