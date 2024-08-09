<?php
require_once "../utils/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $mysqli->real_escape_string($_POST['email']);
    $contraseña = $mysqli->real_escape_string($_POST['contraseña']);

    $sql = "SELECT id, contraseña FROM usuarios WHERE email = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $email);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $hash_contraseña);
            $stmt->fetch();

            if (password_verify($contraseña, $hash_contraseña)) {
                session_start();
                $_SESSION['user_id'] = $user_id;
                $_SESSION['email'] = $email;

                header("Location: ../pages/dashboard.php");
                exit();
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "No se encontró una cuenta con ese email.";
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $mysqli->error;
    }
}
$mysqli->close();
