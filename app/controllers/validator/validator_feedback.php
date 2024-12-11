<?php
use controllers\AppointmentController;
require_once __DIR__ . '/../AppointmentController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Error: Solo se permiten solicitudes POST');
}

$requiredFields = ['citaId', 'diagnostico', 'tratamiento', 'veterinario'];
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

$citaId = filter_input(INPUT_POST, 'citaId', FILTER_VALIDATE_INT);
$diagnostico = htmlspecialchars(trim($_POST['diagnostico']));
$tratamiento = htmlspecialchars(trim($_POST['tratamiento']));
$veterinario = htmlspecialchars(trim($_POST['veterinario']));

// Validate citaId
if ($citaId === false || $citaId === null) {
    die('Error: ID de cita inválido');
}


$appointmentController = new AppointmentController();

if ($appointmentController->reply($citaId, $diagnostico, $tratamiento, $veterinario)){
    return header('Location: /tp-clinica-vet/app/views/admin/appointment_date.php?success=1');
    exit();
}else{
    return header('Location: /tp-clinica-vet/app/views/admin/appointment_date.php?error=1');
    exit();
}