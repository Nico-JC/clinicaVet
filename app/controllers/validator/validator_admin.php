<?php
require_once("../../../config/Data/DBConfig.php");


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
