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

    $query = "INSERT INTO compras (user_id, nombre, marca, presentacion, cantidad, precio, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    
    $stmt->bind_param('issssds', $user_id, $name, $brand, $presentation, $quantity, $price, $image);

    if (!$stmt->execute()) {
        echo json_encode(['error' => $stmt->error]);
        exit;
    }
}

echo json_encode(['success' => 'Carrito guardado con éxito.']);
?>