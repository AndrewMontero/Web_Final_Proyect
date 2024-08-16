<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $nombreTarjeta = trim($_POST['nombreTarjeta']);
    $numeroTarjeta = trim($_POST['numeroTarjeta']);
    $fechaVencimiento = trim($_POST['fechaVencimiento']);
    $codigoCVV = trim($_POST['codigoCVV']);
    $total = floatval($_POST['total']); 

  
    if (empty($nombreTarjeta) || empty($numeroTarjeta) || empty($fechaVencimiento) || empty($codigoCVV)) {
      
        header('Location: ../pages/carrito.php?error=complete_all_fields');
        exit;
    }

    // Simulación del proceso de pago
    // Aquí es donde se integraría una pasarela de pago real (Stripe, PayPal, etc.)
    $pagoExitoso = true; // Simulando que el pago fue exitoso

    if ($pagoExitoso) {

      
        header('Location: ../pages/confirmacion.php');
        exit;
    } else {
       
        header('Location: ../pages/carrito.php?error=pago_fallido');
        exit;
    }
} else {

    header('Location: ../pages/carrito.php');
    exit;
}
