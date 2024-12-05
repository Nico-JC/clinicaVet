<?php
require_once("../../config/Data/DBcon.php");
session_start();

//llamamos todos los datos de la tabla user para mostrar
$consulta = "SELECT * FROM user";
$resultado = mysqli_query($conexion, $consulta);

//Botones
if (isset($_POST['action'])):

        // ELIMINAR
    if ($_POST['action'] == 'delete'):
        $userId = $_POST['userId'];
    //primero borramos las consultas que hizo que ulsuario de la tabla consulta
        $deleteConsulta = "DELETE FROM consult WHERE id_user = $userId";
        mysqli_query($conexion, $deleteConsulta);
        //despues borramos al usuario de la tabla user
        $consultaDeleteUser = "DELETE FROM user WHERE id_user = $userId";
        mysqli_query($conexion, $consultaDeleteUser);

        //ASIGNAR / CAMBIAR ROL
    elseif ($_POST['action'] == 'asignar'):
        $userId = $_POST['userId'];
        $cambiarRol = ($_POST['rolActual'] == '1') ? '0' : '1'; //para alternar entre 1 (Admin) y 0 (Usuario)
        $consultaUpdate = "UPDATE user SET accessLevel = $cambiarRol WHERE id_user = $userId";
        mysqli_query($conexion, $consultaUpdate);
    endif;
endif;

//inicializamos los valores de los filtros en la supervariable SESION para que se guarden
$resultado = null;
if (!isset($_SESSION['filterId'])) {
    $_SESSION['filterId'] = false;
}
if (!isset($_SESSION['filterNom'])) {
    $_SESSION['filterNom'] = false;
}
if (!isset($_SESSION['filterCon'])) {
    $_SESSION['filterCon'] = false;
}
//creamos una variable llamada sql con una parte de la consulta a realizar dependiendo del filtrado
$sql = "SELECT 
        user.id_user, 
        user.username, 
        user.accessLevel, 
        COUNT(consult.id_consulta) AS consultas_count
        FROM user LEFT JOIN consult ON user.id_user = consult.id_user 
        GROUP BY user.id_user,user.username, user.accessLevel";

//condifionales para saber que tipo de filtrado se seleccionó con un $_GET en la misma sesión
//uso de una funcion para no repetir la conexion a la BD
if (isset($_GET["filter"])){
    switch ($_GET["filter"]){
        case "id" :
            if(!$_SESSION['filterId']){
                $sql.= " ORDER BY user.id_user DESC";
                $_SESSION['filterId'] = true;
            }else{
                $sql.= " ORDER BY user.id_user ASC";
                $_SESSION['filterId'] = false;
            }
            $resultado = ejecutarSQL($sql,$conexion);
            break;

        case "nombre" :
            if(!$_SESSION['filterNom']){
                $sql.= " ORDER BY user.username DESC";
                $_SESSION['filterNom'] = true;
            }else{
                $sql.= " ORDER BY user.username ASC";
                $_SESSION['filterNom'] = false;
            }
            $resultado = ejecutarSQL($sql,$conexion);
            break;

        case "consulta" :
            if(!$_SESSION['filterCon']){
                $sql.= " ORDER BY consultas_count DESC";
                $_SESSION['filterCon'] = true;
            }else{
                $sql.= " ORDER BY consultas_count ASC";
                $_SESSION['filterCon'] = false;
            }
            $resultado = ejecutarSQL($sql,$conexion);
            break;

        default:
            $resultado = ejecutarSQL($sql,$conexion);
            break;
    }
}else{
    $resultado = ejecutarSQL($sql,$conexion);
}
//funcion
function ejecutarSQL($sql,$conexion){
    return mysqli_query($conexion, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
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
                <th><div style="cursor: pointer" onclick="window.location.href='user-management.php?filter=id'">ID</div>
                <th><div style="cursor: pointer" onclick="window.location.href='user-management.php?filter=nombre'">Nombre de Usuario</div></th>
                <th><div style="cursor: pointer" onclick="window.location.href='user-management.php?filter=consulta'">Consultas</div></th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <!-- Mientras estemos conectados a la base de datos podemos ver los datos de los usuarios en la tabla -->
            <?php if ($resultado): ?>
                <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <!-- Datos de usuarios -->
                        <td><?= $fila['id_user'] ?></td>
                        <td><?= $fila['username'] ?></td>
                        <td><?= $fila['consultas_count'] ?></td>
                        <td><?= ($fila['accessLevel'] == 1 ? 'Administrador' : 'Usuario') ?></td>
                        <td>
                            <!-- Botón de Asignar Rol -->
                            <form action="" method="post" style="display: inline; margin-left: 5px;">
                                <input type="hidden" name="userId" value="<?= $fila['id_user'] ?>">
                                <input type="hidden" name="currentRole" value="<?= $fila['accessLevel'] ?>">
                                <input type="hidden" name="action" value="asignar">
                                <?php $cambiarRol = ($fila['accessLevel'] == 1) ? 'Usuario' : 'Administrador'; ?>
                                <button type="submit" class="btn btn-primary btn-sm">Asignar Rol</button>
                            </form>

                            <!-- Botón de Eliminar -->
                            <form action="" method="post" style="display: inline; margin-left: 5px;">
                                <input type="hidden" name="userId" value="<?= $fila['id_user'] ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>

                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
