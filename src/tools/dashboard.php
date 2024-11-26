<?php
require_once("../backOffice/Data/DBcon.php");

session_start();

//varificamos que el nivel de acceso del usuario sea User y no admin
$consulta = "SELECT count(*) as cantidad FROM user where id_permisos = 0";
$resultado = mysqli_query($conexion, $consulta);

//creamos la variable que va a contar la cant de usuarios nuevos
$newUser = 0;


if ($resultado){
    //guardamos en fila los datos traidos de la BD como un array asociativo
    $fila = mysqli_fetch_assoc($resultado);
    $newUser = $fila['cantidad'];
}

//consulta para traer la cantidad de consultas sin una respuesta y las almacenamos en una variable para despues mostrarlo
$consulta = "SELECT count(*) as cantidad FROM consulta where respuestaStatus = false;";
$resultado = mysqli_query($conexion, $consulta);//
$consultasSinRespuesta = 0;

if ($resultado) {
    $fila = mysqli_fetch_assoc($resultado);
    $consultasSinRespuesta = $fila['cantidad'];
}

// Consulta para obtener el nombre del último usuario registrado y lo almacenamos en una variable para mostrarlo
$consulta = "SELECT nombre FROM user ORDER BY id_user DESC LIMIT 1";
$resultado = mysqli_query($conexion, $consulta);
$ultimoUsuarioNombre = '';

if ($resultado) {
    $fila = mysqli_fetch_assoc($resultado);
    $ultimoUsuario = $fila['nombre'];
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/custom-styles.css">
    <title>Messipedia®</title>

</head>

<body>

<!--Nav Bar-->
<nav class="navbar navbar-expand-lg bg-white sticky-top ">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="../../assets/images/logopng.png" alt="" style="width: 50px; height: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-active" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item ">
                    <a class="nav-link active" href="../layout/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../layout/galery.php">Carrera</a>
                </li>
                <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Admin Tools
                    </a>
                    <ul class="dropdown-menu " aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item active" href="./adminTools/dashboard.php">Dashboard</a></li>
                        <li><a class="dropdown-item" href="./user-management.php">Gestión de Usuarios</a></li>
                    </ul>
                </li>
                <?php if(isset($_SESSION["userId"])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../backOffice/validator/validator_logout.php">Cerrar Sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenido del Dashboard -->
<div class="container mt-5">
    <h1 class="mb-4">Admin Dashboard</h1>

    <!-- Resumen de Actividad -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ri-bar-chart-box-line card-icon me-3"></i>
                        <div>
                            <h5 class="card-title">Visitas</h5>
                            <p class="card-text">12,345</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ri-user-add-line card-icon me-3"></i>
                        <div>
                            <h5 class="card-title">Nuevos Usuarios</h5>
                            <?php
                            echo "<p class='card-text'>$newUser</p>"
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ri-chat-3-line card-icon me-3"></i>
                        <div>
                            <h5 class="card-title">Consultas sin responder</h5>
                            <?php
                            echo "<p class='card-text'>$consultasSinRespuesta</p>"
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notificaciones -->
    <div class="card mb-4">
        <div class="card-header">
            Notificaciones
        </div>
        <div class="card-body">
            <ul class="list-group">
                <?php
                echo "<li class='list-group-item'>Nuevo usuario registrado: <strong>$ultimoUsuario</strong></li>";
                ?>
                <li class="list-group-item">Publicación denunciada por contenido inapropiado.</li>
                <li class="list-group-item">Solicitud de soporte técnico recibida.</li>
                <li class="list-group-item">Comentario nuevo en la publicación: <strong>"Messi 2004"</strong></li>
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
