<?php
use controllers\UserController;
require_once __DIR__ . '/../../controllers/UserController.php';
session_start();

$userController = new UserController();
$filter = isset($_GET['filter']) ? $_GET['filter'] : null;
$order = isset($_GET['order']) ? $_GET['order'] : null;
$button = isset($_POST['action']) ? $_POST['action'] : null;


// Paginación
$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$totalRecords = count($userController->getAllCitas($filter, $button));
$totalPages = ceil($totalRecords / $itemsPerPage);
$offset = ($currentPage - 1) * $itemsPerPage;
$mascotas = $userController->getPaginatedCitas($offset, $itemsPerPage, $filter, $order);
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
                <?php if (isset($_SESSION["id_permisos"]) && $_SESSION["id_permisos"] == 3): ?>
                    <li class="nav-item">
                    <a class="nav-link" href="../../../public/layout/contact.php">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../../public/layout/pets_history.php">Historial</a>
                </li>
                <?php endif; ?>
                <?php if (isset($_SESSION["id_permisos"]) && $_SESSION["id_permisos"] == 2): ?>
                <li class="nav-item active">
                    <a class="nav-link active" href="appointment_date.php">Registro de Citas</a>
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

<div class="container mt-5">
    <h1 class="mb-4">Registro de Mascotas</h1>
    <a href="/tp-clinica-vet/app/views/user/appointment.php" class="btn btn-success mb-3">Agregar Nueva Mascota</a>
    <a href="/tp-clinica-vet/app/views/admin/appointment_date.php" class="btn btn-warning mb-3">Limpiar filtro</a>
    <div class="table-responsive">
        <table class="table table-striped ">
            <thead>
            <th>
                <div style="cursor: pointer"
                     onclick="window.location.href='appointment_date.php?filter=id&order=<?= ($filter == 'id' && $order == 'ASC') ? 'DESC' : 'ASC' ?>'">
                    ID
                </div>
            </th>
            <th>
                <div style="cursor: pointer"
                     onclick="window.location.href='appointment_date.php?filter=nombre&order=<?= ($filter == 'nombre' && $order == 'ASC') ? 'DESC' : 'ASC' ?>'">
                    Nombre
                </div>
            </th>
            <th>Tipo</th>
            <th>Raza</th>
            <th>Peso</th>
            <th>Edad</th>
            <th>
                <div style="cursor: pointer"
                     onclick="window.location.href='appointment_date.php?filter=fecha&order=<?= ($filter == 'fecha' && $order == 'ASC') ? 'DESC' : 'ASC' ?>'">
                    Fecha Y Hora del turno
                </div>
            </th>

            </thead>
            <tbody>
            <?php if (!empty($mascotas)): ?>
                <?php foreach ($mascotas as $fila): ?>
                    <tr>
                        <td><?= htmlspecialchars(isset($fila['id_cita']) ? $fila['id_cita'] : 'N/A') ?></td>
                        <td><?= htmlspecialchars(isset($fila['nombre_mascota']) ? $fila['nombre_mascota'] : 'N/A') ?></td>
                        <td><?= htmlspecialchars(isset($fila['tipo_mascota']) ? $fila['tipo_mascota'] : 'N/A') ?></td>
                        <td><?= htmlspecialchars(isset($fila['raza']) ? $fila['raza'] : 'N/A') ?></td>
                        <td><?= htmlspecialchars(isset($fila['peso']) ? $fila['peso'] : 'N/A') ?></td>
                        <td><?= htmlspecialchars(isset($fila['edad']) ? $fila['edad'] : 'N/A') ?></td>
                        <td><?= htmlspecialchars(isset($fila['fecha']) ? $fila['fecha'] : 'N/A') . ' ' . htmlspecialchars(isset($fila['hora']) ? $fila['hora'] : 'N/A') ?></td>
                        <td>
                            <form action="" method="post" style="display: inline;">
                                <input type="hidden" name="citaId" value="<?= htmlspecialchars($fila['id_cita']) ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No se encontraron registros.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav aria-label="Paginación de mascotas">
        <ul class="pagination justify-content-center">
            <!-- Previous Page -->
            <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= max(1, $currentPage - 1) ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <!-- Page Numbers -->
            <?php
            $startPage = max(1, $currentPage - 2);
            $endPage = min($totalPages, $currentPage + 2);

            for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <!-- Next Page -->
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
