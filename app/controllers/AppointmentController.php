<?php

namespace controllers;


use models\Appointment;

require_once  __DIR__ .  '/../models/Appointment.php';
require_once  __DIR__ .  '/../../config/Data/DBConfig.php';
class AppointmentController
{
    private $conexion;
    private $cita;

    public function __construct() {
        $this->conexion = (new \Database)->getConnection();
        $this->cita = new Appointment($this->conexion);
    }

    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->cita->nombre_mascota = isset($_POST['nombre_mascota']) ? $_POST['nombre_mascota'] : '';
            $this->cita->tipo_mascota = isset($_POST['tipo_mascota']) ? $_POST['tipo_mascota'] : '';
            $this->cita->raza = isset($_POST['raza']) ? $_POST['raza'] : '';
            $this->cita->peso = !empty($_POST['peso']) ? floatval($_POST['peso']) : null;
            $this->cita->edad = !empty($_POST['edad']) ? intval($_POST['edad']) : null;
            $this->cita->servicio = isset($_POST['servicio']) ? $_POST['servicio'] : '';
            $this->cita->fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
            $this->cita->hora = isset($_POST['hora']) ? $_POST['hora'] : '';
            $this->cita->sintomas = isset($_POST['sintomas']) ? $_POST['sintomas'] : '';
            $this->cita->id_user = isset($_POST['id_user']) ? $_POST['id_user'] : '';

            if ($this->cita->crear()) {
                header("Location: /tp-clinica-vet/index.php?");
                exit();
            } else {
                echo "Hubo un error al guardar la cita";
            }
        }
    }
}