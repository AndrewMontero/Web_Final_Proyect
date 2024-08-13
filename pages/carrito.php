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
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Botón para actualizar todas las cantidades -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <button type="submit" class="btn btn-warning">Actualizar Cantidades</button>
                <h4>Total General: <?php echo number_format($totalGeneral, 2); ?></h4>
                <!-- Botón para abrir el modal de finalizar compra -->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#finalizarCompraModal">Finalizar Compra</button>
            </div>
        </form>

        <div class="text-center mt-4">
            <a href="dashboard.php" class="btn btn-primary">Seguir Comprando</a>
        </div>
    </div>

    <!-- Modal para finalizar compra -->
    <div class="modal fade" id="finalizarCompraModal" tabindex="-1" role="dialog" aria-labelledby="finalizarCompraModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="finalizarCompraModalLabel">Finalizar Compra</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="../actions/procesarPago.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombreTarjeta">Nombre en la Tarjeta</label>
                            <input type="text" class="form-control" id="nombreTarjeta" name="nombreTarjeta" required>
                        </div>
                        <div class="form-group">
                            <label for="numeroTarjeta">Número de Tarjeta</label>
                            <input type="text" class="form-control" id="numeroTarjeta" name="numeroTarjeta" required>
                        </div>
                        <div class="form-group">
                            <label for="fechaVencimiento">Fecha de Vencimiento</label>
                            <input type="text" class="form-control" id="fechaVencimiento" name="fechaVencimiento" placeholder="MM/AA" required>
                        </div>
                        <div class="form-group">
                            <label for="codigoCVV">Código CVV</label>
                            <input type="text" class="form-control" id="codigoCVV" name="codigoCVV" required>
                        </div>
                        <input type="hidden" name="total" value="<?php echo $totalGeneral; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Pagar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
