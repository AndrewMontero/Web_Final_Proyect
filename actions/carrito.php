<?php
session_start();
require_once "../utils/database.php";

// Lee el cuerpo de la solicitud
$carrito = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'No estás autenticado.']);
    exit;
}

$user_id = $_SESSION['user_id'];

foreach ($carrito as $item) {
    $name = $mysqli->real_escape_string($item['nombre']);
    $brand = $mysqli->real_escape_string($item['Marca']);
    $presentation = $mysqli->real_escape_string($item['Presentación']);
    $price = $item['Precio'];
    $quantity = $item['cantidad'];
    $image = $mysqli->real_escape_string($item['Imagen']);

    // Verificar si el producto ya existe en la tabla `compras`
    $query = "SELECT cantidad FROM compras WHERE user_id = ? AND nombre = ? AND marca = ? AND presentacion = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('isss', $user_id, $name, $brand, $presentation);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Si el producto ya existe, actualiza la cantidad
        $stmt->bind_result($existing_quantity);
        $stmt->fetch();
        $new_quantity = $existing_quantity + $quantity;
        $update_query = "UPDATE compras SET cantidad = ? WHERE user_id = ? AND nombre = ? AND marca = ? AND presentacion = ?";
        $update_stmt = $mysqli->prepare($update_query);
        $update_stmt->bind_param('iisss', $new_quantity, $user_id, $name, $brand, $presentation);
        $update_stmt->execute();
    } else {
        // Si el producto no existe, lo inserta
        $insert_query = "INSERT INTO compras (user_id, nombre, marca, presentacion, cantidad, precio, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $mysqli->prepare($insert_query);
        $insert_stmt->bind_param('issssds', $user_id, $name, $brand, $presentation, $quantity, $price, $image);
        $insert_stmt->execute();
    }
}

echo json_encode(['success' => 'Carrito guardado con éxito.']);
