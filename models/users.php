<?php
session_start();

require_once "../utils/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $mysqli->real_escape_string($_POST['email']);
    $contraseña = $mysqli->real_escape_string($_POST['contraseña']);

    $sql = "SELECT id, contraseña FROM usuarios WHERE email = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($userId, $hashedPassword);
                $stmt->fetch();

                if (password_verify($contraseña, $hashedPassword)) {
                    $_SESSION['user_id'] = $userId;
                    $_SESSION['email'] = $email;

                    header("Location: ../pages/dashboard.php");
                    exit();
                }
            }
        }

        echo "<script>alert('Correo o contraseña incorrectos.'); window.location.href='../pages/login.php';</script>";

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $mysqli->error;
    }

    $mysqli->close();
}
