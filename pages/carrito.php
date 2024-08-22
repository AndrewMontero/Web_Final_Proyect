<?php
require '../actions/viewCarrito.php';
require '../actions/deleteProducto.php';

// Calcular el total general
$totalGeneral = 0;
if (!empty($productos)) {
    foreach ($productos as $item) {
        $cantidad = floatval($item['cantidad']);
        $totalGeneral += $cantidad * floatval($item['precio']);
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
    <script src="https://www.paypal.com/sdk/js?client-id=AfDDJ82yqDrmGJAR_x6AdQX5-WAS1HZOGidxh0YJryy6N-6qgf9gcjvEabPhUn5V-n_Mus-N6vFrSx1C&currency=USD"></script>

    <style>
        .paypal-button-container {
            margin-top: 20px;
        }

        /* Estilo para centrar el botón de PayPal */
        .paypal-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Altura de la pantalla */
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Carrito de Compras</h1>
        <form action="../actions/editProducto.php" method="post">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Presentación</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Total</th>
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
                                <td>
                                    <input type="hidden" name="productos[<?php echo htmlspecialchars($item['id']); ?>][id]"
                                        value="<?php echo htmlspecialchars($item['id']); ?>">
                                    <input type="number"
                                        name="productos[<?php echo htmlspecialchars($item['id']); ?>][cantidad]"
                                        value="<?php echo htmlspecialchars($item['cantidad']); ?>" min="1" class="form-control"
                                        style="width: 100px;">
                                </td>
                                <td><?php echo htmlspecialchars($item['precio']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($item['imagen']); ?>" alt="Imagen del producto"
                                        style="width: 100px; height: auto;"></td>
                                <td>
                                    <?php
                                    $total = floatval($item['cantidad']) * floatval($item['precio']);
                                    echo number_format($total, 2);
                                    ?>
                                </td>
                                <td>
                                    <form action="../actions/deleteProducto.php" method="post" class="d-inline">
                                        <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No hay productos en el carrito.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Botón para actualizar todas las cantidades -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <button type="submit" class="btn btn-warning">Actualizar Cantidades</button>
                <h4>Total General: <?php echo number_format($totalGeneral, 2); ?></h4>
                <a href="dashboard.php" class="btn btn-primary">Seguir Comprando</a>
            </div>
        </form>
    </div>

    <!-- Contenedor para el botón de PayPal -->
    <div class="paypal-wrapper">
        <div id="paypal-button-container"></div>
    </div>

    <script>
        // Configurar PayPal
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo number_format($totalGeneral, 2, '.', ''); ?>' // Total del carrito
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Redirigir a completar la compra después de un pago exitoso
                    window.location.href = 'dashboard.php';
                });
            },
            onError: function(err) {
                alert("Ocurrió un error en el proceso.");
            }
        }).render('#paypal-button-container'); // Renderizar el botón de PayPal en el contenedor especificado
    </script>

    <!-- Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
