<?php
require_once "../utils/database.php"; // Asegúrate de tener la conexión a la base de datos en este archivo

// Verificar si se enviaron datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productos'])) {
    $productos = $_POST['productos'];

    foreach ($productos as $producto) {
        $producto_id = intval($producto['id']);
        $cantidad = $mysqli->real_escape_string($producto['cantidad']);

        // Preparar la consulta SQL para actualizar la cantidad
        $consulta = "UPDATE compras SET cantidad = ? WHERE id = ?";
        $stmt = $mysqli->prepare($consulta);
        $stmt->bind_param('si', $cantidad, $producto_id);

        if (!$stmt->execute()) {
            echo "Error al actualizar producto ID $producto_id: " . $stmt->error;
        }

        $stmt->close();
    }

    $mysqli->close();

    // Redirigir de nuevo al carrito de compras
    header("Location: ../pages/carrito.php");
    exit();
} else {
    // No se enviaron datos válidos
    echo "No se enviaron datos válidos.";
}
?>