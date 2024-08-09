<?php
function get_mysql_connection() {
    // Configuraciones de conexión
    $host = 'localhost';
    $user = 'root';
    $password = 'localF';
    $database = 'tienda';

    $conn = new mysqli($host, $user, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}