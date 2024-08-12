<?php

require '../utils/database.php'; // Conexión a la base de datos

// Procesar la solicitud de eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'])) {
    $productoId = intval($_POST['producto_id']);

    // Prepara la consulta para eliminar el producto
    $query = "DELETE FROM compras WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $mysqli->error);
    }
    $stmt->bind_param("i", $productoId);

    if ($stmt->execute()) {
        // Redirigir de nuevo al carrito para ver los cambios
        header("Location: ../pages/carrito.php");
        exit;
    } else {
        echo "Error al eliminar el producto: " . $stmt->error;
    }
}


