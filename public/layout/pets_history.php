<?php
use controllers\UserController;
require_once __DIR__ . '/../../app/controllers/UserController.php';
session_start();

$userController = new UserController();
$petsHistoryInfo = $userController->showPetsHistory($_SESSION["userId"]);
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/assets/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">

    <style>
        .pet-card {
            transition: transform 0.2s;
        }
        .pet-card:hover {
            transform: translateY(-5px);
        }
    </style>

    <title>Historial Médico - VetCare</title>
</head>

<body>

<!--Nav Bar-->
<nav class="navbar navbar-expand-lg bg-white sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="../../public/assets/images/vet-logo.png" alt="VetCare Logo" style="width: 150px; height: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-active" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../../index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="galery.php">Galería</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contacto</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link active" href="pets_history.php">Historial</a>
                </li>
                <?php if(!isset($_SESSION["userId"])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../../app/views/user/register.php">Registrarse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../app/views/user/logIn.php">Iniciar Sesión</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION["id_permisos"]) && $_SESSION["id_permisos"] == 2): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../../app/views/admin/appointment_date.php">Registro de Citas</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION["id_permisos"]) && $_SESSION["id_permisos"] == 1): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Tools
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="../../app/views/admin/dashboard.php">Dashboard</a></li>
                            <li><a class="dropdown-item" href="../../app/views/admin/user_management.php">Gestión de Usuarios</a></li>
                            <li><a class="dropdown-item" href="../../app/views/admin/appointment_date.php">Registro de Citas</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(isset($_SESSION["userId"])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../../app/controllers/validator/validator_logout.php">Cerrar Sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!--HomeP-->
<section id="hero" class="min-vh-100 d-flex align-items-center text-center" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../../public/assets/images/vet-background.jpg') center/cover;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-uppercase text-white fw-semibold display-1" data-aos="fade-down">Historial Médico</h1>
                <h4 class="text-white mb-4">Consulta el historial médico completo de tus mascotas</h4>
                <div data-aos="fade-up">
                    <?php if(isset($_SESSION["userId"])): ?>
                    <a href="../../app/views/user/appointment.php" class="btn btn-success btn-lg">Reservar Cita</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>


<section>
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
            <?php if ($petsHistoryInfo['tienesMascotas']): ?>
                <?php foreach ($petsHistoryInfo['mascotas'] as $mascota): ?>
                    <div class="col-md-8 col-lg-4">
                        <div class="card pet-card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($mascota['nombre_mascota']); ?></h5>
                                <p class="card-text text-muted">
                                    <?php echo htmlspecialchars($mascota['tipo_mascota']); ?> •
                                    <?php echo htmlspecialchars($mascota['raza']); ?> •
                                    <?php echo htmlspecialchars($mascota['edad']); ?> años
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <button class="btn btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#historialModal-<?php echo htmlspecialchars($mascota['nombre_mascota']); ?>">
                                        Ver Historial
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        Aún no has registrado ninguna mascota.
                        <a href="../../app/views/user/appointment.php" class="alert-link">Programa tu primera cita</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Modal de Historial Médico -->
<?php foreach ($petsHistoryInfo['mascotas'] as $mascota): ?>
    <div class="modal fade" id="historialModal-<?php echo htmlspecialchars($mascota['nombre_mascota']); ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Historial Médico - <?php echo htmlspecialchars($mascota['nombre_mascota']); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="timeline">
                        <?php
                        $historialMedico = $userController->getPetMedicalHistory($_SESSION["userId"], $mascota['nombre_mascota']);

                        if (!empty($historialMedico)):
                            foreach ($historialMedico as $consulta):
                                ?>
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-0"><?php echo htmlspecialchars($consulta['diagnostico']); ?></h6>
                                            <small class="text-muted"><?php echo htmlspecialchars($consulta['fecha']); ?></small>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6>Diagnóstico:</h6>
                                        <p><?php echo htmlspecialchars($consulta['diagnostico']); ?></p>
                                        <h6>Tratamiento:</h6>
                                        <p><?php echo htmlspecialchars($consulta['tratamiento']); ?></p>
                                        <h6>Veterinario:</h6>
                                        <p><?php echo htmlspecialchars($consulta['veterinario']); ?></p>
                                    </div>
                                </div>
                            <?php
                            endforeach;
                        else:
                            ?>
                            <div class="alert alert-info" role="alert">
                                No hay registros médicos para esta mascota.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Descargar Historial</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!--Footer-->
<footer class="bg-dark">
    <div class="footer-top">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <img src="../../public/assets/images/vet-logo.png" alt="" class="mb-4" style="height: 80px;">
                    <p class="text-white">Tu clínica veterinaria de confianza</p>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <h5 class="text-white">Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="">Servicios</a></li>
                        <li><a href="">Equipo</a></li>
                        <li><a href="contact.php">Contacto</a></li>
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
<script src="../../public/assets/js/fade.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
