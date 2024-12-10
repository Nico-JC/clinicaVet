<?php
session_start();
//si el formulario se envio con exito mostramos mensaje
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo '<div class="alert alert-success text-center" role="alert">
              ¡Tu consulta se ha enviado con éxito!
         </div>';
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1" >
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <link rel="stylesheet" href="../../public/assets/css/style.css">
    <link rel="stylesheet" href="../../public/assets/css/registro.css">
    <title>Formulario</title>

</head>
<body>
<!--Nav Bar-->

<nav class="navbar navbar-expand-lg bg-white sticky-top ">
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
                <li class="nav-item ">
                    <a class="nav-link " href="../../index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="galery.php">Galería</a>
                </li>
                    <li class="nav-item active">
                        <a class="nav-link active" href="contact.php">Contacto</a>
                    </li>
                <li class="nav-item">
                    <a class="nav-link" href="pets_history.php">Historial</a>
                </li>
                <?php if(!isset($_SESSION["userId"])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../../app/views/user/register.php">Registrarse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../app/views/user/logIn.php">Iniciar Sesión</a>
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
                            <?php if ($_SESSION["id_permisos"] != 1): ?>
                            <li><a class="dropdown-item" href="../../app/views/admin/appointment_date.php">Registro de Citas</a></li>
                            <?php endif; ?>
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

<!-- Primero consulto si la pregunta fue enviada y tiene los datos de la misma -->
<?php if (isset($_GET["modal"]) && $_GET["modal"] == 1 && isset($_SESSION["modalMail"]) && isset($_SESSION["modalContenido"])): ?>
    <!--Creo el modal basado en: https://getbootstrap.com/docs/5.3/components/modal/ -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Consulta Enviada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Correo electrónico:</strong> <span><?php echo htmlspecialchars($_SESSION["modalMail"]); ?></span></p>
                    <p><strong>Contenido de la consulta:</strong></p>
                    <p id="modalConsulta"><?php echo htmlspecialchars($_SESSION["modalContenido"]); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>




<!--HomeP-->
<section id="hero" class="min-vh-100 d-flex align-items-center text-center" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../../public/assets/images/vet-background.jpg') center/cover;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-uppercase text-white fw-semibold display-1" data-aos="fade-down">Contacto</h1>
                <div data-aos="fade-up">
                    <?php if(isset($_SESSION["userId"])): ?>
                    <a href="../../app/views/user/appointment.php" class="btn btn-success btn-lg">Reservar Cita</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!--Registro-->
<section id="form" class="mb-5 mt-5 bg-dark" style="margin-right: 12px;">
    <div class="d-flex justify-content-center align-items-center">
        <div class="col-md-12">
            <div class="container">
                <h1 style="color: white;">Contáctanos</h1>
                <h6 class="mt-4 mb-3" style="color: white;">Ingresa la siguiente informacion para contactarnos.</h6>
                <form action="../../config/Data/consultas.php" method="post">
                    <div class="container">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="fw-bold text-white">Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Tu nombre" autocomplete="off" required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-white">Apellido <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Tu apellido" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label class="fw-bold text-white">Correo electronico <span class="text-danger">*</span></label>
                            <input id="email" name="email" type="email" class="form-control" placeholder="Ingresa tu correo" autocomplete="off" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="fw-bold text-white">Prefijo <span class="text-danger">*</span></label>
                                <select id="phonePrefix" name="phonePrefix" class="form-control">
                                    <option value="+54">+54 (Argentina)</option>
                                    <option value="+55">+55 (Brasil)</option>
                                    <option value="+56">+56 (Chile)</option>
                                    <option value="+57">+57 (Colombia)</option>
                                    <option value="+58">+58 (Venezuela)</option>
                                    <option value="+591">+591 (Bolivia)</option>
                                    <option value="+593">+593 (Ecuador)</option>
                                    <option value="+595">+595 (Paraguay)</option>
                                    <option value="+598">+598 (Uruguay)</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="fw-bold text-white">Numero de telefono <span class="text-danger">*</span></label>
                                <input id="userPhone" name="userPhone" type="text" class="form-control" placeholder="*(11 1234-5678)" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label class="fw-bold text-white">Texto adicional <span class="text-danger">*</span></label>
                                <textarea id="consultaUser" name="consultaUser" class="form-control" rows="5" style="resize: none;" placeholder="Ingresa tu mensaje adicional" autocomplete="off" required></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="userId" value="<?php echo $_SESSION["userId"]; ?>">
                        <button type="submit" class="btn btn-primary mt-4">Enviar</button>
                    </div>
                </form>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="../../public/assets/js/fade.js"></script>

<script>
    $(document).ready(function() {
        // Mostrar el modal si está presente en el DOM
        if ($('#successModal').length) {
            $('#successModal').modal('show');
        }
    });
</script>
</body>

</html>