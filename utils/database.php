
<?php
$mysqli = new mysqli("localhost", "root", "", "tienda");
if (mysqli_connect_errno()) {
    printf("Conexión fallida", mysqli_connect_error());
} else {
    printf("Conectado a la BD");
}
?>