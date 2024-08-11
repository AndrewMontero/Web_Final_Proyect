<?php
session_start(); // Iniciar la sesión


// Destruir todos los datos de la sesión
session_destroy();
// Redirigir al usuario a la página de inicio de sesión
header('Location: iniciar_sesion.php');
exit();
?>
