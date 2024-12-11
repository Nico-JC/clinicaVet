<?php
use controllers\UserController;
require_once '../UserController.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Error: Solo se permiten solicitudes POST');
}

$requiredFields = ['nombre', 'apellido', 'email', 'telefono', 'consulta'];
$missingFields = [];

foreach ($requiredFields as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        $missingFields[] = $field;
    }
}
if (!empty($missingFields)) {
    echo "Campos faltantes: " . implode(', ', $missingFields);
    exit;
}


$nombre = htmlspecialchars(trim($_POST['nombre']));
$apellido = htmlspecialchars(trim($_POST['apellido']));
$email = htmlspecialchars(trim($_POST['email']));
$telefono = htmlspecialchars(trim($_POST['telefono']));
$consulta = htmlspecialchars(trim($_POST['consulta']));


$userController = new UserController();
if ($userController->registerConsult($nombre, $apellido, $email, $telefono, $consulta)){
    return header('Location: /tp-clinica-vet/app/views/user/contact.php?success=1');
    exit();
}else{
    return header('Location: /tp-clinica-vet/app/views/user/contact.php?error=1');
    exit();
}

