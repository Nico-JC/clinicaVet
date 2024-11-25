<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
    <link rel="stylesheet" href="../../../assets/css/registro.css">

    <title>Registro</title>
</head>

<body>
<!--Nav Bar-->
<nav class="navbar navbar-expand-lg bg-white sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="../../../assets/images/vet-logo.png" alt="VetCare Logo" style="width: 150px; height: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../galeria.php">Galería</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../contacto.php">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../historial.php">Historial</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link active" href="registro.php">Registrarse</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="inicioSesion.php">Iniciar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!--HomeP-->
<section id="hero" class="min-vh-100 d-flex align-items-center text-center" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../../../assets/images/vet-background.jpg') center/cover;">

    <!--Registro-->
    <div class="form-overlay position-absolute top-50 start-50 translate-middle mt-5">
        <div class=" p-4 rounded" style="backdrop-filter: blur(10px);">
            <h1 style="color: white;">¿Ya tienes cuenta una cuenta?</h1>
            <h5 class="text-white mb-3 mt-4">Puedes iniciar sesión con:</h5>
            <div class="form-group">
                <button class="btn btn-border-red text-white mr-2 mb-3 fw-bold"><i class="ri-google-fill lead align-midle"></i> Google</button>
                <button class="btn btn-border-blue text-white mb-3 fw-bold"><i class="ri-facebook-box-fill lead align-midle"></i> Facebook</button>
                <button class="btn btn-border-white text-white mb-3 fw-bold"><i class="ri-apple-line lead align-midle"></i> Apple</button>
            </div>
                    <?php if (isset($_GET["error"]) && $_GET["error"] == 1): ?>
                        <div class="btn btn-outline-danger" style="color: black">El nombre de usuaruio ya esta en uso</div>
                    <?php endif; ?>
                    <?php if (isset($_GET["error"]) && $_GET["error"] == 2): ?>
                        <div class=" btn btn-outline-danger" style="color: black">Las contraseñas no coinciden</div>
                    <?php endif; ?>
            <form action="../../backOffice/validator/register_validator.php" method="post">
                <div class="container">
                    <div class="form-group col-md-12 mb-3">
                        <label class="fw-bold text-white">Nombre de Usuario <span class="text-danger">*</span></label>
                        <input id="userName" name="userName" type="text" class="form-control" placeholder="Tu nombre de usuario" autocomplete="off" required>
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <label class="fw-bold text-white">Contraseña <span class="text-danger">*</span></label>
                        <input id="userPassword" name="userPassword" type="password" class="form-control" placeholder="Ingresa tu contraseña" autocomplete="off" required>
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <label class="fw-bold text-white">Reingresar Contraseña <span class="text-danger">*</span></label>
                        <input id="userPassword" name="confirm_password" type="password" class="form-control" placeholder="Reingresar contraseña" autocomplete="off" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Registrarse</button>
                </div>
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
<script src="../../../assets/js/fade.js"></script>
</body>
</html>
