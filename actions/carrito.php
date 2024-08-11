<?php
session_start();
require '../utils/database.php'; // Incluye el archivo con la configuración de conexión a la base de datos

if (!isset($_SESSION['user_id'])) {
    echo 'Error: No estás logueado';
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=tu_base_de_datos', 'usuario', 'contraseña');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los productos en el carrito
    $stmt = $pdo->prepare('SELECT * FROM compras WHERE user_id = :user_id');
    $stmt->execute(['user_id' => $user_id]);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
