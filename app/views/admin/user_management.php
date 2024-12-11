<?php
use controllers\UserController;
require_once __DIR__ . '/../../controllers/UserController.php';
session_start();

$userController = new UserController();
$filter = isset($_GET['filter']) ? $_GET['filter'] : null;
$button = isset($_POST['action']) ? $_POST['action'] : null;
$users = $userController->getAllUsers($filter, $button);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <title>Gestión de Usuarios</title>
</head>
<body>

<!-- Nav var -->
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
                            <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                            <li><a class="dropdown-item active" href="user_management.php">Gestión de Usuarios</a></li>
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

 <!-- Contenido principal de Gestión de Usuarios -->
<div class="container mt-5">
    <h1 class="mb-4">Gestión de Usuarios</h1>
    <!-- Botónes para el Filtro -->
    <div class="table-responsive">
        <table class="table table-striped ">
            <thead>
            <tr> <!--window location, para recargar la pagina en el onclick para el filtrado (https://www.w3schools.com/js/js_window_location.asp)-->
                <th><div style="cursor: pointer" onclick="window.location.href='user_management.php?filter=id'">ID</div>
                <th><div style="cursor: pointer" onclick="window.location.href='user_management.php?filter=email'">Email</div></th>
                <th><div style="cursor: pointer" onclick="window.location.href='user_management.php?filter=consulta'">Consultas</div></th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $fila): ?>
                    <tr>
                        <!-- Datos de usuarios -->
                        <td><?= htmlspecialchars($fila['id_user']) ?></td>
                        <td><?= htmlspecialchars($fila['email']) ?></td>
                        <td><?= htmlspecialchars($fila['consultCount']) ?></td>
                        <td><?= htmlspecialchars($fila['id_permisos'] == 1 ? 'Administrador' : ($fila['id_permisos'] == 2 ? 'Veterinario' : 'Usuario')) ?></td>
                        <td>
                            <!-- Botón de Asignar Rol -->
                            <form action="" method="post" style="display: inline; margin-left: 5px;">
                                <input type="hidden" name="emailID" value="<?= htmlspecialchars($fila['id_user']) ?>">
                                <input type="hidden" name="currentRole" value="<?= htmlspecialchars($fila['id_permisos']) ?>">
                                <input type="hidden" name="action" value="asignar">
                                <?php $cambiarRol = ($fila['id_permisos'] == 1) ? 'Usuario' : 'Administrador'; ?>
                                <button type="submit" class="btn btn-primary btn-sm">Cambiar Rol</button>
                            </form>

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
                    <td colspan="5">No se encontraron usuarios.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
