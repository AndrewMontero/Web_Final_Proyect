<?php
require '../utils/database.php';
require '../models/users.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    $conn = get_mysql_connection();

    $user_data = [
        'nombre' => $nombre,
        'apellido' => $apellido,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'email' => $email,
        'contraseña' => $contraseña
    ];

    $new_user_id = insert($conn, $user_data);
    if (is_int($new_user_id)) {
            echo "<script>alert('Usuario registrado exitosamente! ID: $new_user_id');</script>";
        } else {
            echo "<script>alert('Error al registrar el usuario.');</script>";
    }

    $conn->close();
}
?>