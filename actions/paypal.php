<?php
session_start();
require_once "../utils/database.php";

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total_price = 0;

// Si el carrito está vacío, muestra un mensaje
if (empty($cart)) {
    echo "<div class='container mt-5'><div class='alert alert-info text-center'>Your cart is empty.</div></div>";
    exit();
}

// Obtener todos los IDs de los productos en el carrito
$product_ids = array_keys($cart);
$placeholders = implode(',', array_fill(0, count($product_ids), '?'));

// Consulta optimizada para obtener todos los productos en una sola consulta
$query = "SELECT * FROM products WHERE id IN ($placeholders)";
$stmt = $conn->prepare($query);
$stmt->bind_param(str_repeat('i', count($product_ids)), ...$product_ids);
$stmt->execute();
$products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Calcular el total del carrito
foreach ($products as $product) {
    $quantity = $cart[$product['id']];
    $total_price += $product['price'] * $quantity;
}

$_SESSION['total_amount'] = $total_price;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- PayPal SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=AfDDJ82yqDrmGJAR_x6AdQX5-WAS1HZOGidxh0YJryy6N-6qgf9gcjvEabPhUn5V-n_Mus-N6vFrSx1C&currency=USD"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Your Cart</h1>
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Product</th>
                    <th>Price per unit</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <?php
                    $quantity = $cart[$product['id']];
                    $total_item_price = $product['price'] * $quantity;
                    ?>
                    <tr id="product-<?php echo $product['id']; ?>">
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td>$<span class="price-per-unit"><?php echo htmlspecialchars($product['price']); ?></span></td>
                        <td><?php echo $quantity; ?></td>
                        <td>$<span class="total-price"><?php echo number_format($total_item_price, 2); ?></span></td>
                        <td>
                            <button class="btn btn-danger remove-item" data-product-id="<?php echo $product['id']; ?>">Remove</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-right">Total Price</th>
                    <th colspan="2">$<span id="cart-total"><?php echo number_format($total_price, 2); ?></span></th>
                </tr>
            </tfoot>
        </table>
        <div class="text-right">
            <!-- Botón de PayPal -->
            <div id="paypal-button-container"></div>
        </div>
    </div>

    <script>
        // Inicializar PayPal Button
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo number_format($total_price, 2); ?>' // Total del carrito
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Guardar la orden en la base de datos y limpiar el carrito
                    $.post('../controller/complete_purchase.php', {
                        orderID: data.orderID
                    }, function(response) {
                        window.location.href = '../pages/profile.php'; // Redirigir a la página de perfil
                    });
                });
            }
        }).render('#paypal-button-container'); // Renderizar el botón de PayPal en el contenedor

        // Manejar la eliminación de un artículo del carrito
        $(document).on('click', '.remove-item', function() {
            var productId = $(this).data('product-id');
            $.post('../controller/remove_from_cart.php', { product_id: productId }, function(response) {
                $('#product-' + productId).remove();
                // Actualizar el total del carrito
                location.reload();
            });
        });
    </script>
</body>
</html>
