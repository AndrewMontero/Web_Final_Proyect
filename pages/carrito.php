<?php

require '../actions/viewCarrito.php';
require '../actions/deleteProducto.php';

// Calcular el total general
$totalGeneral = 0;
if (!empty($productos)) {
    foreach ($productos as $item) {
        $totalGeneral += $item['cantidad'] * $item['precio'];
    }
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
                    <th>Imagen</th>
                    <th>Total</th> <!-- Nueva columna -->
                    <th>Acciones</th>
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
                            <td>
                                <?php
                                $total = htmlspecialchars($item['cantidad']) * htmlspecialchars($item['precio']);
                                echo number_format($total, 2); // Formatea el total con dos decimales
                                ?>
                            </td> <!-- Nueva columna -->
                            <td>
                                <form action="../actions/deleteProducto.php" method="post">
                                    <input type="hidden" name="producto_id"
                                        value="<?php echo htmlspecialchars($item['id']); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">No hay productos en el carrito.</td>
                        <!-- Actualiza el colspan -->
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Total general y botón de finalizar compra -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <h4>Total General: <?php echo number_format($totalGeneral, 2); ?></h4>
            <a href="finalizarCompra.php" class="btn btn-success">Finalizar Compra</a>
            <!-- Botón de finalizar compra -->
        </div>

        <div class="text-center mt-4">
            <a href="dashboard.php" class="btn btn-primary">Seguir Comprando</a>
        </div>
    </div>
</body>

</html>