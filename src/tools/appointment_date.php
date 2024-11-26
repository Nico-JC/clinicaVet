<?php
require_once("../backOffice/Data/DBcon.php");

session_start();

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// varificamos que el nivel de acceso del usuario sea User y no admin
$consulta = "SELECT count(*) as cantidad FROM user where accessLevel = 0";
$resultado = mysqli_query($conexion, $consulta);

// Obtener el número de página actual
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 10;

// Calcular el offset
$offset = ($current_page - 1) * $records_per_page;

// Consulta para obtener los registros de pacientes
$sql = "SELECT * FROM pacientes LIMIT $offset, $records_per_page";
$result = $conexion->query($sql);

// Obtener el número total de registros
if ($resultado) {
    $total_records = $conexion->query("SELECT COUNT(*) AS total FROM user")->fetch_assoc()['total'];
    $total_pages = ceil($total_records / $records_per_page);
}

?>





<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <title>Registro de Pacientes</title>
</head>
<body>

<!--Nav var-->
<nav class="navbar navbar-expand-lg bg-white sticky-top ">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="../../assets/images/vet-logo.png" alt="VetCare Logo" style="width: 150px; height: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-active" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item ">
                    <a class="nav-link active" href="../layout/index.php">Inicio</a>
                </li>
                <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Admin Tools
                    </a>
                    <ul class="dropdown-menu " aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="./dashboard.php">Dashboard</a></li>
                        <li><a class="dropdown-item active" href="user_management.php">Gestión de Usuarios</a></li>
                        <li><a class="dropdown-item" href="appointment_date.php">Registro de Citas</a></li>
                    </ul>
                </li>
                <?php if(isset($_SESSION["userId"])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../backOffice/validator/validator_logout.php">Cerrar Sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


<div class="container my-5">
    <h1 class="mb-4">Registro de Pacientes</h1>

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Especie</th>
            <th>Raza</th>
            <th>Edad</th>
            <th>Dueño</th>
            <th>Fecha de Atención</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result != false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["especie"] . "</td>";
                echo "<td>" . $row["raza"] . "</td>";
                echo "<td>" . $row["edad"] . "</td>";
                echo "<td>" . $row["dueno"] . "</td>";
                echo "<td>" . $row["fecha_atencion"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No se encontraron registros.</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php
            if ($current_page > 1) {
                echo "<li class='page-item'><a class='page-link' href='?page=" . ($current_page - 1) . "'>Anterior</a></li>";
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                $active = ($i == $current_page) ? "active" : "";
                echo "<li class='page-item " . $active . "'><a class='page-link' href='?page=" . $i . "'>$i</a></li>";
            }

            if ($current_page < $total_pages) {
                echo "<li class='page-item'><a class='page-link' href='?page=" . ($current_page + 1) . "'>Siguiente</a></li>";
            }
            ?>
        </ul>
    </nav>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
