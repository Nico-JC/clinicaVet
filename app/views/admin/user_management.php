<?php
use controllers\UserController;
require_once __DIR__ . '/../../controllers/UserController.php';
session_start();

$userController = new UserController();
$filter = isset($_GET['filter']) ? $_GET['filter'] : null;
$order = isset($_GET['order']) ? $_GET['order'] : null;
$button = isset($_POST['action']) ? $_POST['action'] : null;

$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$totalRecords = count($userController->getAllUsers($filter, $button));
$totalPages = ceil($totalRecords / $itemsPerPage);
$offset = ($currentPage - 1) * $itemsPerPage;
$users = $userController->getPaginatedUsers($offset, $itemsPerPage, $filter, $order);
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
                    <a class="nav-link" href="../user/contact.php">Contacto</a>
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
            <tr>
                <th>
                    <div style="cursor: pointer"
                         onclick="window.location.href='user_management.php?filter=id&order=<?= ($filter == 'id' && $order == 'ASC') ? 'DESC' : 'ASC' ?>'">
                        ID
                    </div>
                </th>
                <th>
                    <div style="cursor: pointer"
                         onclick="window.location.href='user_management.php?filter=email&order=<?= ($filter == 'email' && $order == 'ASC') ? 'DESC' : 'ASC' ?>'">
                        Email
                    </div>
                </th>
                <th>
                    <div style="cursor: pointer"
                         onclick="window.location.href='user_management.php?filter=rol&order=<?= ($filter == 'rol' && $order == 'ASC') ? 'DESC' : 'ASC' ?>'">
                        Rol
                    </div>
                </th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $fila): ?>
                    <tr>
                        <td><?= htmlspecialchars($fila['id_user']) ?></td>
                        <td><?= htmlspecialchars($fila['email']) ?></td>
                        <td><?= htmlspecialchars($fila['id_permisos'] == 1 ? 'Administrador' : ($fila['id_permisos'] == 2 ? 'Veterinario' : 'Usuario')) ?></td>
                        <td>
                            <form action="" method="post" style="display: inline; margin-left: 5px;">
                                <input type="hidden" name="emailID" value="<?= htmlspecialchars($fila['id_user']) ?>">
                                <input type="hidden" name="currentRole" value="<?= htmlspecialchars($fila['id_permisos']) ?>">
                                <input type="hidden" name="action" value="asignar">
                                <?php $cambiarRol = ($fila['id_permisos'] == 2) ? 'Usuario' : 'Veterinario'; ?>
                                <button type="submit" class="btn btn-primary btn-sm">Cambiar Rol</button>
                            </form>
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
    <!-- Pagination -->
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
