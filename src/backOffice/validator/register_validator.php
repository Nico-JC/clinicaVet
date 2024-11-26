<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['userName']);
    $password = trim($_POST['userPassword']);
    $confirm_password = trim($_POST['confirm_password']);

    $finalUser = htmlspecialchars($username);

    // Conexión a la base de datos
    $conexion = new mysqli('localhost', 'root', '', 'veterinaria');

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Verificar si el nombre de usuario ya existe
    $consulta = $conexion->prepare("SELECT * FROM user WHERE username=?");

    $consulta->bind_param("s", $finalUser);
    $consulta->execute();
    $result = $consulta->get_result();

    //si devuelve un resultado mayor a 0 es porque ya existe, redirigimos y mostramos error=1
    if ($result->num_rows > 0) {
        header("Location: ../../layout/forms/log/register_form.php?error=1");
        exit();
    } elseif ($password !== $confirm_password) {
        //si las contraseñas no coinciden mostramos error=2
        header("Location: ../../layout/forms/log/register_form.php?error=2");
        exit();
    } else {
        //si esta todo bien hacemos mas segura la contraseña y continuaos
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        // Insertar el nuevo usuario en la base de datos
        $insert = $conexion->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
        if (!$insert) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }

        $insert->bind_param("ss", $finalUser, $hashedPassword);


        if ($insert->execute()) {
            header("Location: ../../layout/forms/log/logIn_form.php");
        } else {
            echo "Error: " . $conexion->error;
        }
    }

    $consulta->close();
    $conexion->close();
}
