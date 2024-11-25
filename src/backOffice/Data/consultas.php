<?php
session_start();

//guardamos todos los datos traidos del formulario en variables
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $consultaUser = $_POST['consultaUser'];
    $email = $_POST['email'];
    $telefono = $_POST['phonePrefix'] . ' ' . $_POST['userPhone'];
    $id_user = $_POST['userId'];
    $_SESSION["modalMail"] = $email;
    $_SESSION["modalContenido"] = $consultaUser;

    // Conexión a la base de datos
    $conexion = new mysqli('localhost', 'root', '', 'messiPediaDB');

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    //preparamos la consulta para ingresar los datos a la BD (forma mas segura con prepare())
    $insert = $conexion->prepare("INSERT INTO consulta (contenido, email, telefono, id_user) VALUES (?, ?, ?, ?)");
    if (!$insert) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    // Vincular parámetros con bind_param
    $insert->bind_param("sssi", $consultaUser, $email, $telefono, $id_user);

    //ejecutamos la consulta y si es exitosa redirigimos a la misma pagina con un modal para mostrar la consulta
    if ($insert->execute()) {
        header("Location: ../contacto.php?success=1&modal=1");
    } else {
        echo "Error al insertar consulta: " . $conexion->error;
    }
}
