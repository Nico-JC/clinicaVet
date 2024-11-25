<?php
session_start();

//gaurdamos los datos traidos del formulario y usamos trim y htmlspecialchars para hacerlo mas seguro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['userName']);
    $password = trim($_POST['userPassword']);
    $finalUser = htmlspecialchars($username);

    // Conexión a la base de datos
    $conexion = new mysqli('localhost', 'root', '', 'messiPediaDB');

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Verificar si el nombre de usuario ya existe
    $consulta = $conexion->prepare("SELECT * FROM user WHERE nombre=? ");
    $consulta->bind_param("s", $finalUser);
    $consulta->execute();
    $resultado = $consulta->get_result();


    if ($resultado->num_rows > 0 ) {
        //guardamos los datos traidos en una varaiable
        $fila = $resultado->fetch_assoc();//forma de aceder al array pero Orientado a Obj
        //verificamos que las contraseñas coincidan y si lo hacen los redirigimos al index
        if (password_verify($password, $fila['password'])) {
            $_SESSION["userName"] = $fila["nombre"];
            $_SESSION["userId"] = $fila["id_user"];
            $_SESSION["userPermisos"] = $fila["id_permisos"];
            header("Location: ../../index.php");
            exit();
        } else {
            //si no coinciden las contraseñas mostramos error=1
            header("Location: ../../inicioSesion.php?error=1");
            exit();
        }
    } else {
        //si el nombre esta mal mostramos error=1
        header("Location: ../../inicioSesion.php?error=1");
        exit();
    }
}

