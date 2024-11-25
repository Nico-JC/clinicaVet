<?php
session_start()
?>

<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
        <link rel="stylesheet" href="../../assets/css/style.css">

    <title>Messipedia®</title>
</head>
<body>
    <!--Nav Bar-->
    <nav class="navbar navbar-expand-lg bg-white sticky-top">
        <div class="container">

            <a class="navbar-brand" href="#">
                <img src="../../assets/images/vet-logo.png" alt="VetCare Logo" style="width: 150px; height: auto;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse nav-active" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link active" href="galeria.php">Galería</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacto.php">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="historial.php">Historial</a>
                    </li>
                    <?php if(!isset($_SESSION["userId"])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="log/registro.php">Registrarse</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="log/inicioSesion.php">Iniciar Sesión</a>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION["userPermisos"]) && $_SESSION["userPermisos"] == 1): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Herramientas Admin
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                <li><a class="dropdown-item" href="../adminTools/dashboard.php">Dashboard</a></li>
                                <li><a class="dropdown-item" href="../adminTools/user-management.php">Gestión de Usuarios</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if(isset($_SESSION["userId"])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../backOffice/validator/validator_logout.php">Cerrar Sesión</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!--HomeP-->
    <section id="hero" class="min-vh-100 d-flex align-items-center text-center" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../../assets/images/vet-background.jpg') center/cover;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-uppercase text-white fw-semibold display-1" data-aos="fade-down">Galería</h1>
                    <div data-aos="fade-up">
                        <a href="cita.php" class="btn btn-success btn-lg">Reservar Cita</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--Stats Section-->
    <section class="gallery-stats bg-light py-4 mt-4">
        <div class="container">
            <div class="d-flex justify-content-center gap-4">
                <div class="text-center">
                    <h6 class="mb-0">Hechale un vistazo a algunas de las mascotas con las que hemos trabajado</h6>
                </div>
            </div>
        </div>
    </section>

    <!-- Galería -->
    <section class="gallery-grid">
        <div class="container">
            <h2 class="gallery-title text-center">Galería de Imágenes</h2>
            <div class="row g-4"> <!-- Añadido g-4 para espaciado entre imágenes -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="gallery-item">
                        <img src="../../assets/images/hamster.jpg" alt="Imagen 1" class="gallery-img">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="gallery-item">
                        <img src="../../assets/images/carpincho.jpg" alt="Imagen 2" class="gallery-img">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="gallery-item">
                        <img src="../../assets/images/perroP.jpg" alt="Imagen 3" class="gallery-img">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="gallery-item">
                        <img src="../../assets/images/galgo-fresh.jpg" alt="Imagen 4" class="gallery-img">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="gallery-item">
                        <img src="../../assets/images/gato.jpg" alt="Imagen 5" class="gallery-img">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="gallery-item">
                        <img src="../../assets/images/husky.jpg" alt="Imagen 6" class="gallery-img">
                    </div>
                </div>
                <!-- Repetir para las demás imágenes -->
            </div>
        </div>
    </section>

    <!--Footer-->

    <footer class="bg-dark">
        <div class="footer-top">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-4">
                        <img src="../../assets/images/vet-logo.png" alt="" class="mb-4" style="height: 80px;">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="../../assets/js/fade.js"></script>
</body>
</html>