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
    <link rel="stylesheet" href="public/assets/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <title>VetCare - Clínica Veterinaria</title>
</head>

<body>

<!--Nav Bar-->
<nav class="navbar navbar-expand-lg bg-white sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="public/assets/images/vet-logo.png" alt="VetCare Logo" style="width: 150px; height: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-active" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item active">
                    <a class="nav-link active" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="public/layout/galery.php">Galería</a>
                </li>
                <?php if (isset($_SESSION["accessLevel"]) && $_SESSION["accessLevel"] == 0): ?>
                <li class="nav-item">
                    <a class="nav-link" href="public/layout/contact.php">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="public/layout/pets_history.php">Historial</a>
                </li>
                <?php endif; ?>
                <?php if(!isset($_SESSION["userId"])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="app/views/user/register.php">Registrarse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="app/views/user/logIn.php">Iniciar Sesión</a>
                    </li>
                <?php endif; ?>

                <?php if (isset($_SESSION["accessLevel"]) && $_SESSION["accessLevel"] == 1): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Tools
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="app/views/admin/dashboard.php">Dashboard</a></li>
                            <li><a class="dropdown-item" href="app/views/admin/user_management.php">Gestión de Usuarios</a></li>
                            <li><a class="dropdown-item" href="app/views/admin/appointment_date.php">Registro de Citas</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(isset($_SESSION["userId"])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="app/controllers/validator/validator_logout.php">Cerrar Sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!--HomeP-->
<section id="hero" class="min-vh-100 d-flex align-items-center text-center" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('public/assets/images/vet-background.jpg') center/cover;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-uppercase text-white fw-semibold display-1" data-aos="fade-down">Bienvenido a VetCare</h1>
                <div data-aos="fade-up">
                    <h5 class="text-white mt-3 mb-4">Cuidamos de tus mascotas como si fueran nuestras.
                        Servicio veterinario profesional las 24 horas del día.</h5>
                    <?php if(isset($_SESSION["userId"])): ?>
                    <a href="app/views/user/appointment.php" class="btn btn-success btn-lg">Reservar Cita</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Servicios -->
<section id="servicios" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="section-title">
                    <h1 class="display-4 fw-semibold mt-5">Nuestros Servicios</h1>
                    <div class="line"></div>
                    <p>Ofrecemos una amplia gama de servicios veterinarios para el cuidado integral de tu mascota.</p>
                </div>
            </div>
            <div class="row justify-content-between text-center g-4">
                <div class="col-lg-4">
                    <div class="service-card p-4 shadow rounded">
                        <i class="ri-heart-pulse-line ri-3x text-success mb-4"></i>
                        <h4>Consultas Generales</h4>
                        <p>Chequeos rutinarios, vacunaciones y atención preventiva para mantener la salud de tu mascota.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="service-card p-4 shadow rounded">
                        <i class="ri-surgical-mask-line ri-3x text-success mb-4"></i>
                        <h4>Cirugía</h4>
                        <p>Procedimientos quirúrgicos realizados por nuestro equipo de expertos en instalaciones modernas.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="service-card p-4 shadow rounded">
                        <i class="ri-microscope-line ri-3x text-success mb-4"></i>
                        <h4>Laboratorio</h4>
                        <p>Análisis clínicos y diagnósticos precisos para un tratamiento efectivo.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Equipo Médico -->
<section id="equipo" class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="section-title">
                    <h1 class="display-4 fw-semibold mt-5">Nuestro Equipo Médico</h1>
                    <div class="line"></div>
                    <p>Contamos con un equipo de profesionales altamente calificados y comprometidos con el bienestar de tu mascota.</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Doctor 1 -->
            <div class="col-lg-3 col-md-6">
                <div class="team-member bg-white p-4 rounded shadow">
                    <img src="public/assets/images/doctor1.jpg" alt="Dr. Carlos Rodríguez" class="img-fluid rounded-circle mb-4 w-100">
                    <div class="text-center">
                        <h5 class="mb-1">Dr. Carlos Rodríguez</h5>
                        <p class="mb-2 text-success fw-semibold">Director Médico</p>
                        <p class="small text-muted mb-3">Especialista en Cirugía y Medicina Interna</p>
                        <p class="text-muted">+34 612 345 678</p>
                        <p class="text-muted">carlos@vetcare.com</p>
                    </div>
                </div>
            </div>

            <!-- Doctor 2 -->
            <div class="col-lg-3 col-md-6">
                <div class="team-member bg-white p-4 rounded shadow">
                    <img src="public/assets/images/doctor2.jpg" alt="Dra. Ana Martínez" class="img-fluid rounded-circle mb-4 w-100">
                    <div class="text-center">
                        <h5 class="mb-1">Dra. Ana Martínez</h5>
                        <p class="mb-2 text-success fw-semibold">Veterinaria Senior</p>
                        <p class="small text-muted mb-3">Especialista en Dermatología</p>
                        <p class="text-muted">+34 623 456 789</p>
                        <p class="text-muted">ana@vetcare.com</p>
                    </div>
                </div>
            </div>

            <!-- Doctor 3 -->
            <div class="col-lg-3 col-md-6">
                <div class="team-member bg-white p-4 rounded shadow">
                    <img src="public/assets/images/doctor3.jpg" alt="Dr. Miguel Sánchez" class="img-fluid rounded-circle mb-4 w-100">
                    <div class="text-center">
                        <h5 class="mb-1">Dr. Miguel Sánchez</h5>
                        <p class="mb-2 text-success fw-semibold">Veterinario</p>
                        <p class="small text-muted mb-3">Especialista en Traumatología</p>
                        <p class="text-muted">+34 634 567 890</p>
                        <p class="text-muted">miguel@vetcare.com</p>
                    </div>
                </div>
            </div>

            <!-- Doctor 4 -->
            <div class="col-lg-3 col-md-6">
                <div class="team-member bg-white p-4 rounded shadow">
                    <img src="public/assets/images/doctor4.jpg" alt="Dra. Laura González" class="img-fluid rounded-circle mb-4 w-100">
                    <div class="text-center">
                        <h5 class="mb-1">Dra. Laura González</h5>
                        <p class="mb-2 text-success fw-semibold">Veterinaria</p>
                        <p class="small text-muted mb-3">Especialista en Medicina Preventiva</p>
                        <p class="text-muted">+34 645 678 901</p>
                        <p class="text-muted">laura@vetcare.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--Footer-->
<footer class="bg-dark">
    <div class="footer-top">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <img src="public/assets/images/vet-logo.png" alt="" class="mb-4" style="height: 80px;">
                    <p class="text-white">Tu clínica veterinaria de confianza</p>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <h5 class="text-white">Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="">Servicios</a></li>
                        <li><a href="equipo.php">Equipo</a></li>
                        <li><a href="public/layout/contact.php">Contacto</a></li>
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
<script src="public/assets/js/fade.js"></script>
</body>
</html>