<?php

require '../shared/header.php';
require '../actions/viewCarrito.php';
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
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($item['marca']); ?></td>
                            <td><?php echo htmlspecialchars($item['presentacion']); ?></td>
                            <td><?php echo htmlspecialchars($item['cantidad']); ?></td>
                            <td><?php echo htmlspecialchars($item['precio']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($item['imagen']); ?>" alt="Imagen del producto"
                                    style="width: 100px; height: auto;"></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No hay productos en el carrito.</td>
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