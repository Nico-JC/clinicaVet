<?php
use controllers\UserController;
require_once __DIR__ . '/../../controllers/UserController.php';
session_start();

$userController = new UserController();
$button = isset($_POST['action']) ? $_POST['action'] : null;

//Modal
$success = isset($_GET['success']) ? $_GET['success'] : null;
$error = isset($_GET['error']) ? $_GET['error'] : null;

// Paginación
$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$totalRecords = count($userController->showConsult($button));
$totalPages = ceil($totalRecords / $itemsPerPage);
$offset = ($currentPage - 1) * $itemsPerPage;
$consultas = $userController->getPaginatedConsult($offset, $itemsPerPage);

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
                <li class="nav-item">
                    <a class="nav-link" href="../user/contact.php">Contacto</a>
                </li>
                <?php if (isset($_SESSION["id_permisos"]) && $_SESSION["id_permisos"] == 3): ?>
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
    <h1 class="mb-4">Dashboard</h1>

    <!-- Notificaciones -->
    <div class="card mb-4">
        <div class="card-header">
            Notificaciones
        </div>
        <div class="card-body">
            <ul class="list-group">
                <div class="container mt-5">
                    <h3 class="mb-4">Consultas</h3>
                    <div class="table-responsive">
                        <table class="table table-striped ">
                            <thead>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Telefono</th>
                            <th>Consulta</th>
                            </thead>
                            <tbody>
                            <?php if (!empty($consultas)): ?>
                                <?php foreach ($consultas as $fila): ?>
                                    <tr>
                                        <td><?= htmlspecialchars(isset($fila['id_consulta']) ? $fila['id_consulta'] : 'N/A') ?></td>
                                        <td><?= htmlspecialchars(isset($fila['email']) ? $fila['email'] : 'N/A') ?></td>
                                        <td><?= htmlspecialchars(isset($fila['name']) ? $fila['name'] : 'N/A') ?></td>
                                        <td><?= htmlspecialchars(isset($fila['last_name']) ? $fila['last_name'] : 'N/A') ?></td>
                                        <td><?= htmlspecialchars(isset($fila['phone_number']) ? $fila['phone_number'] : 'N/A') ?></td>
                                        <td><?= htmlspecialchars(isset($fila['text']) ? $fila['text'] : 'N/A') ?></td>
                                        <td>
                                            <form action="" method="post" style="display: inline;">
                                                <input type="hidden" name="id_consulta" value="<?= htmlspecialchars($fila['id_consulta']) ?>">
                                                <input type="hidden" name="action" value="delete">
                                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No hay consultas.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
            </ul>
        </div>
    </div>
    <nav aria-label="Paginación de mascotas">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= max(1, $currentPage - 1) ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <?php
            $startPage = max(1, $currentPage - 2);
            $endPage = min($totalPages, $currentPage + 2);

            for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= min($totalPages, $currentPage + 1) ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
