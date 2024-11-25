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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">

    <style>
        .pet-card {
            transition: transform 0.2s;
        }
        .pet-card:hover {
            transform: translateY(-5px);
        }
        .bg-pawprint {
            background-color: #f8f9fa;
            position: relative;
            overflow: hidden;
        }
        .header-image {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('/api/placeholder/1200/300');
            background-size: cover;
            background-position: center;
            color: white;
        }
    </style>

    <title>Historial Médico - VetCare</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="galeria.php">Galería</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contacto.php">Contacto</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link active" href="historial.php">Historial</a>
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
                <h1 class="text-uppercase text-white fw-semibold display-1" data-aos="fade-down">Historial Médico</h1>
                <h4 class="text-white mb-4">Consulta el historial médico completo de tus mascotas</h4>
                <div data-aos="fade-up">
                    <a href="cita.php" class="btn btn-success btn-lg">Reservar Cita</a>
                </div>
            </div>
        </div>
    </div>
</section>


<section>
    <!-- Main Content -->
    <div class="container my-5 py-5">
        <!-- Filtro de búsqueda -->
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Buscar mascota...">
                    <button class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </div>

        <!-- Lista de Mascotas -->
        <div class="row g-4 mb-5">
            <!-- Mascota 1 -->
            <div class="col-md-8 col-lg-4">
                <div class="card pet-card h-100 shadow-sm">
                    <img src="../../assets/images/golden.jpg" class="card-img-top" alt="Foto de Max">
                    <div class="card-body">
                        <h5 class="card-title">Max</h5>
                        <p class="card-text text-muted">Labrador Retriever • 3 años</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#historialModal">
                                Ver Historial
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mascota 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="card pet-card h-100 shadow-sm">
                    <img src="/api/placeholder/400/300" class="card-img-top" alt="Foto de Luna">
                    <div class="card-body">
                        <h5 class="card-title">Luna</h5>
                        <p class="card-text text-muted">Gato Siamés • 2 años</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#historialModal">
                                Ver Historial
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal de Historial -->
<div class="modal fade" id="historialModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Historial Médico - Max</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="timeline">
                    <!-- Consulta 1 -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0">Consulta de Rutina</h6>
                                <small class="text-muted">15/11/2023</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6>Diagnóstico:</h6>
                            <p>Revisión general. Estado de salud óptimo.</p>
                            <h6>Tratamiento:</h6>
                            <p>Vacuna contra la rabia aplicada.</p>
                            <h6>Veterinario:</h6>
                            <p>Dr. García</p>
                        </div>
                    </div>

                    <!-- Consulta 2 -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0">Emergencia</h6>
                                <small class="text-muted">03/09/2023</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6>Diagnóstico:</h6>
                            <p>Problemas digestivos por ingesta de alimento inadecuado.</p>
                            <h6>Tratamiento:</h6>
                            <ul>
                                <li>Medicamento antiemético</li>
                                <li>Dieta especial por 3 días</li>
                            </ul>
                            <h6>Veterinario:</h6>
                            <p>Dra. Martínez</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Descargar Historial</button>
            </div>
        </div>
    </div>
</div>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
