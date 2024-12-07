<?php
use controllers\UserController;
require_once __DIR__ . '/../../controllers/UserController.php';
session_start();

$userController = new UserController();
$filter = isset($_GET['filter']) ? $_GET['filter'] : null;
$button = isset($_POST['action']) ? $_POST['action'] : null;
$mascotas = $userController->getAllCitas($filter, $button);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <title>Registro de Mascotas</title>
</head>
<body>

<!--Nav var-->
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
                <li class="nav-item">
                    <a class="nav-link" href="../../../public/layout/contact.php">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../../public/layout/pets_history.php">Historial</a>
                </li>
                <?php if(!isset($_SESSION["userId"])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../user/register.php">Registrarse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../user/logIn.php">Iniciar Sesión</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION["accessLevel"]) && $_SESSION["accessLevel"] == 1): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Tools
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                            <li><a class="dropdown-item" href="user_management.php">Gestión de Usuarios</a></li>
                            <li><a class="dropdown-item active" href="appointment_date.php">Registro de Citas</a></li>
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

<div class="container mt-5">
    <h1 class="mb-4">Registro de Mascotas</h1>

    <a href="/tp-clinica-vet/app/views/user/appointment.php" class="btn btn-success mb-3">
        Agregar Nueva Mascota
    </a>

    <div class="table-responsive">
        <table class="table table-striped ">
            <thead>
            <tr> <!--window location, para recargar la pagina en el onclick para el filtrado (https://www.w3schools.com/js/js_window_location.asp)-->
                <th><div style="cursor: pointer" onclick="window.location.href='user_management.php?filter=id'">ID</div>
                <th><div style="cursor: pointer" onclick="window.location.href='user_management.php?filter=email'">Nombre</div></th>
                <th><div style="cursor: pointer" onclick="window.location.href='user_management.php?filter=consulta'">Tipo</div></th>
                <th>Raza</th>
                <th>Peso</th>
                <th>Edad</th>
                <th>Fecha Y Hora del turno</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($mascotas)): ?>
                <?php foreach ($mascotas as $fila): ?>
                    <tr>
                        <!-- Datos de usuarios -->
                        <td><?= isset($fila['id_cita']) ? htmlspecialchars($fila['id_cita']) : 'N/A'; ?></td>
                        <td><?= isset($fila['nombre_mascota']) ? htmlspecialchars($fila['nombre_mascota']) : 'N/A'; ?></td>
                        <td><?= isset($fila['tipo_mascota']) ? htmlspecialchars($fila['tipo_mascota']) : 'N/A'; ?></td>
                        <td><?= isset($fila['raza']) ? htmlspecialchars($fila['raza']) : 'N/A'; ?></td>
                        <td><?= isset($fila['peso']) ? htmlspecialchars($fila['peso']) : 'N/A'; ?></td>
                        <td><?= isset($fila['edad']) ? htmlspecialchars($fila['edad']) : 'N/A'; ?></td>
                        <td><?= isset($fila['fecha']) ? htmlspecialchars($fila['fecha']) : 'N/A' ;echo " ",isset($fila['hora']) ? htmlspecialchars($fila['hora']) : 'N/A'; ?></td>
                        <td>
                            <!-- Botón de Eliminar -->
                            <form action="" method="post" style="display: inline; margin-left: 5px;">
                                <input type="hidden" name="userId" value="<?= htmlspecialchars($fila['id_user']) ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No se encontraron registros.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
