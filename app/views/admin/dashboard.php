<?php
session_start()
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <title>Dashboard</title>
</head>
<body>
<!--Nav Bar-->
<nav class="navbar navbar-expand-lg bg-white sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="../../../public/assets/images/vet-logo.png" alt="VetCare Logo" style="width: 150px; height: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-active" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item ">
                    <a class="nav-link " href="../../../index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../../public/layout/galery.php">Galería</a>
                </li>
                <?php if (isset($_SESSION["id_permisos"]) && $_SESSION["id_permisos"] == 3): ?>
                <li class="nav-item">
                    <a class="nav-link" href="../../../public/layout/contact.php">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../../public/layout/pets_history.php">Historial</a>
                </li>
                <?php endif; ?>
                <?php if(!isset($_SESSION["userId"])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="../user/register.php">Registrarse</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../user/logIn.php">Iniciar Sesión</a>
                </li>
                <?php endif; ?>

                <?php if (isset($_SESSION["id_permisos"]) && $_SESSION["id_permisos"] == 1): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Tools
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item active" href="dashboard.php">Dashboard</a></li>
                            <li><a class="dropdown-item" href="user_management.php">Gestión de Usuarios</a></li>
                            <li><a class="dropdown-item" href="appointment_date.php">Registro de Citas</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(isset($_SESSION["userId"])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../../controllers/validator/validator_logout.php">Cerrar Sesión</a>
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
