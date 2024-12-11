<?php
namespace models;

class Appointment {
    private $conn;
    public $id;
    public $nombre_mascota;
    public $tipo_mascota;
    public $raza;
    public $peso;
    public $edad;
    public $servicio;
    public $fecha;
    public $hora;
    public $sintomas;
    public $id_user;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear() {
        $this->nombre_mascota = htmlspecialchars(strip_tags($this->nombre_mascota));
        $this->tipo_mascota = htmlspecialchars(strip_tags($this->tipo_mascota));
        $this->raza = htmlspecialchars(strip_tags($this->raza));
        $this->servicio = htmlspecialchars(strip_tags($this->servicio));
        $this->sintomas = htmlspecialchars(strip_tags($this->sintomas));

        $query = "INSERT INTO cita(nombre_mascota, tipo_mascota, raza, peso, edad, servicio, fecha, hora, sintomas, id_user) 
                  VALUES (:nombre_mascota, :tipo_mascota, :raza, :peso, :edad, :servicio, :fecha, :hora, :sintomas, :id_user)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre_mascota", $this->nombre_mascota);
        $stmt->bindParam(":tipo_mascota", $this->tipo_mascota);
        $stmt->bindParam(":raza", $this->raza);
        $stmt->bindParam(":peso", $this->peso);
        $stmt->bindParam(":edad", $this->edad);
        $stmt->bindParam(":servicio", $this->servicio);
        $stmt->bindParam(":fecha", $this->fecha);
        $stmt->bindParam(":hora", $this->hora);
        $stmt->bindParam(":sintomas", $this->sintomas);
        $stmt->bindParam(":id_user", $this->id_user);
        try {
            return $stmt->execute();
        } catch(PDOException $exception) {
            return false;
        }
    }

    public function reply($citaId, $diagnostico, $tratamiento, $veterinario){
        $citaId = htmlspecialchars(strip_tags($citaId));
        $diagnostico = htmlspecialchars(strip_tags($diagnostico));
        $tratamiento = htmlspecialchars(strip_tags($tratamiento));
        $veterinario = htmlspecialchars(strip_tags($veterinario));

        $query = "UPDATE cita 
              SET diagnostico = :diagnostico, 
                  tratamiento = :tratamiento, 
                  veterinario = :veterinario 
              WHERE id_cita = :citaId";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':diagnostico', $diagnostico);
        $stmt->bindParam(':tratamiento', $tratamiento);
        $stmt->bindParam(':veterinario', $veterinario);
        $stmt->bindParam(':citaId', $citaId);
        try {
            return $stmt->execute();
        } catch (PDOException $exception) {
            return false;
        }
    }
}