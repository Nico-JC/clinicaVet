<?php
use controllers\UserController;
require_once __DIR__ . '/../../controllers/UserController.php';
session_start();

$userController = new UserController();
$filter = isset($_GET['filter']) ? $_GET['filter'] : null;
$order = isset($_GET['order']) ? $_GET['order'] : null;
$button = isset($_POST['action']) ? $_POST['action'] : null;

//modal
$success = isset($_GET['success']) ? $_GET['success'] : null;
$error = isset($_GET['error']) ? $_GET['error'] : null;

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

<?php if ($success == 1): ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">Éxito</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                El feedback se ha guardado correctamente.
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($error == 1): ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger text-white">
                <strong class="me-auto">Error</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Hubo un problema al guardar el feedback. Por favor, intente nuevamente.
            </div>
        </div>
    </div>
<?php endif; ?>

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
                    <a class="nav-link" href="../user/contact.php">Contacto</a>
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
                            <li><a class="dropdown-item" href="dashboard.php">Consultas</a></li>
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
            <th>Acciones</th>
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
                            <?php if ($fila['diagnostico'] != null || $fila['tratamiento'] != null || $fila['veterinario'] != null): ?>
                                <button type="button"
                                        class="btn btn-info btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewFeedbackModal"
                                        data-diagnostico="<?= htmlspecialchars(isset($fila['diagnostico']) ? $fila['diagnostico'] : 'N/A') ?>"
                                        data-tratamiento="<?= htmlspecialchars(isset($fila['tratamiento']) ? $fila['tratamiento'] : 'N/A') ?>"
                                        data-veterinario="<?= htmlspecialchars(isset($fila['veterinario']) ? $fila['veterinario'] : 'N/A') ?>"
                                        data-mascota-nombre="<?= htmlspecialchars($fila['nombre_mascota']) ?>">
                                    Ver Feedback
                                </button>
                            <?php else: ?>
                                <button type="button"
                                        class="btn btn-primary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#feedbackModal"
                                        data-cita-id="<?= htmlspecialchars($fila['id_cita']) ?>"
                                        data-mascota-nombre="<?= htmlspecialchars($fila['nombre_mascota']) ?>">
                                    Feedback
                                </button>
                            <?php endif; ?>
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

<!-- Feedback Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feedbackModalLabel">Agregar Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="feedbackForm" action="../../controllers/validator/validator_feedback.php" method="POST">
                    <input type="hidden" id="citaIdInput" name="citaId" value="">

                    <div class="mb-3">
                        <label for="mascotaInput" class="form-label">Mascota</label>
                        <input type="text" class="form-control" id="mascotaInput" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="diagnosticoInput" class="form-label">Diagnóstico <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="diagnosticoInput" name="diagnostico" rows="3" required></textarea>
                        <div class="invalid-feedback">
                            Por favor, ingrese un diagnóstico.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tratamientoInput" class="form-label">Tratamiento <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="tratamientoInput" name="tratamiento" rows="3" required></textarea>
                        <div class="invalid-feedback">
                            Por favor, ingrese un tratamiento.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="veterinarioInput" class="form-label">Veterinario <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="veterinarioInput" name="veterinario" required>
                        <div class="invalid-feedback">
                            Por favor, ingrese el nombre del veterinario.
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewFeedbackModal" tabindex="-1" aria-labelledby="viewFeedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewFeedbackModalLabel">Detalles del Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="viewMascotaInput" class="form-label">Mascota</label>
                    <input type="text" class="form-control" id="viewMascotaInput" readonly>
                </div>

                <div class="mb-3">
                    <label for="viewDiagnosticoInput" class="form-label">Diagnóstico</label>
                    <textarea class="form-control" id="viewDiagnosticoInput" rows="3" readonly></textarea>
                </div>

                <div class="mb-3">
                    <label for="viewTratamientoInput" class="form-label">Tratamiento</label>
                    <textarea class="form-control" id="viewTratamientoInput" rows="3" readonly></textarea>
                </div>

                <div class="mb-3">
                    <label for="viewVeterinarioInput" class="form-label">Veterinario</label>
                    <input type="text" class="form-control" id="viewVeterinarioInput" readonly>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const feedbackModal = document.getElementById('feedbackModal');
        const viewFeedbackModal = document.getElementById('viewFeedbackModal');

        <?php if ($success == 1): ?>
        var successToast = new bootstrap.Toast(document.getElementById('successToast'));
        successToast.show();
        <?php endif; ?>

        <?php if ($error == 1): ?>
        var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
        errorToast.show();
        <?php endif; ?>

        feedbackModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const citaId = button.getAttribute('data-cita-id');
            const mascotaNombre = button.getAttribute('data-mascota-nombre');

            const citaIdInput = document.getElementById('citaIdInput');
            const mascotaInput = document.getElementById('mascotaInput');

            citaIdInput.value = citaId;
            mascotaInput.value = mascotaNombre;
        });

        const feedbackForm = document.getElementById('feedbackForm');
        feedbackForm.addEventListener('submit', function(event) {
            if (!feedbackForm.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            feedbackForm.classList.add('was-validated');
        }, false);
        viewFeedbackModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const mascotaNombre = button.getAttribute('data-mascota-nombre');
            const diagnostico = button.getAttribute('data-diagnostico');
            const tratamiento = button.getAttribute('data-tratamiento');
            const veterinario = button.getAttribute('data-veterinario');

            const mascotaInput = document.getElementById('viewMascotaInput');
            const diagnosticoInput = document.getElementById('viewDiagnosticoInput');
            const tratamientoInput = document.getElementById('viewTratamientoInput');
            const veterinarioInput = document.getElementById('viewVeterinarioInput');

            mascotaInput.value = mascotaNombre;
            diagnosticoInput.value = diagnostico;
            tratamientoInput.value = tratamiento;
            veterinarioInput.value = veterinario;
        });
    });
</script>
</body>

</html>
