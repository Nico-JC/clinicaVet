<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <link rel="stylesheet" href="../../../public/assets/css/registro.css">
    <title>Formulario</title>
</head>

<body>
<!--Nav Bar-->
<nav class="navbar navbar-expand-lg bg-white sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="../../../public/assets/images/vet-logo.png" alt="VetCare Logo" style="width: 150px; height: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../../../index.php">Inicio</a>
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
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Registrarse</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link active" href="logIn.php">Iniciar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!--HomeP-->
<section id="hero" class="min-vh-100 d-flex align-items-center text-center" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../../../public/assets/images/vet-background.jpg') center/cover;">

    <!--Formulario-->
    <div class="form-overlay2 position-absolute top-50 start-50 translate-middle">
        <div class="p-4 rounded">
            <h1 style="color: white;">Iniciar Sesión</h1>
            <?php if(isset($_GET["error"])&& $_GET["error"] == 1): ?>
            <div class="btn btn-outline-danger" style="color:black">credenciales incorrectas</div>
            <?php endif;  ?>
            <form action="/tp-clinica-vet/app/controllers/validator/validator_logIn.php" method="POST">
                <div class="mb-3 mt-3">
                    <label class="fw-bold text-white ">Correo electronico <span class="text-danger">*</span></label>
                    <input id="email" name="email" type="email" class="form-control" placeholder="Email" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label class="fw-bold text-white">Contraseña <span class="text-danger">*</span></label>
                    <input id="userPassword" name="userPassword" type="password" class="form-control" placeholder="Ingresa tu contraseña" autocomplete="off" required>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Confirmar</button>
            </form>
        </div>
    </div>
</section>

<!--Footer-->
<footer class="bg-dark">
    <div class="footer-top">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <img src="../assets/images/vet-logo.png" alt="" class="mb-4" style="height: 80px;">
                    <p class="text-white">Tu clínica veterinaria de confianza</p>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <h5 class="text-white">Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="">Servicios</a></li>
                        <li><a href="">Equipo</a></li>
                        <li><a href="contacto.php">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <h5 class="text-white">Servicios</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Consultas</a></li>
                        <li><a href="#">Cirugía</a></li>
                        <li><a href="#">Vacunación</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="text-white">Contacto</h5>
                    <ul class="list-unstyled text-white">
                        <li>Dirección: Calle Principal 123</li>
                        <li>Teléfono: (123) 456-7890</li>
                        <li>Email: info@vetcare.com</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom py-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="mb-0 text-white text-center">&copy; 2024 VetCare - Todos los derechos reservados</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="../../../public/assets/js/fade.js"></script>
</body>
</html>
