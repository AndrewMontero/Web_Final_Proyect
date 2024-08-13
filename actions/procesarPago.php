<?php
// procesarPago.php

// Verificar si se recibieron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombreTarjeta = trim($_POST['nombreTarjeta']);
    $numeroTarjeta = trim($_POST['numeroTarjeta']);
    $fechaVencimiento = trim($_POST['fechaVencimiento']);
    $codigoCVV = trim($_POST['codigoCVV']);
    $total = floatval($_POST['total']); // Asegurarse de que sea un número flotante

    // Aquí deberías hacer validaciones adicionales para cada campo
    if (empty($nombreTarjeta) || empty($numeroTarjeta) || empty($fechaVencimiento) || empty($codigoCVV)) {
        // Si alguno de los campos está vacío, redirigir de nuevo al carrito con un mensaje de error
        header('Location: ../pages/carrito.php?error=complete_all_fields');
        exit;
    }

    // Simulación del proceso de pago
    // Aquí es donde se integraría una pasarela de pago real (Stripe, PayPal, etc.)
    $pagoExitoso = true; // Simulando que el pago fue exitoso

    if ($pagoExitoso) {
        // Si el pago fue exitoso, puedes procesar la compra, almacenar la orden en la base de datos, etc.
        
        // Ejemplo: guardar en la base de datos la orden (esto es solo un ejemplo, necesitarías un código real)
        /*
        $sql = "INSERT INTO ordenes (nombre_tarjeta, numero_tarjeta, total) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssd', $nombreTarjeta, $numeroTarjeta, $total);
        $stmt->execute();
        */

        // Redirigir al usuario a una página de confirmación o agradecerle por su compra
        header('Location: ../pages/confirmacion.php');
        exit;
    } else {
        // Si el pago falló, redirigir al carrito con un mensaje de error
        header('Location: ../pages/carrito.php?error=pago_fallido');
        exit;
    }
} else {
    // Si se intenta acceder directamente al archivo, redirigir al carrito
    header('Location: ../pages/carrito.php');
    exit;
}
