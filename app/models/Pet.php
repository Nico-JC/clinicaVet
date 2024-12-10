<?php

namespace models;

use controllers\UserController;
use PDO;
use PDOException;

class Pet{
    private $conn;
    public $id;
    public $nombre;
    public $fechaYhora;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllCitas(){
        $query = "SELECT * FROM cita";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaginatedCitas($offset, $limit, $filter = null, $button = null) {
        $query = "SELECT * FROM cita WHERE 1=1 
                  " . ($filter ? " AND column_name = '$filter'" : "") . "
                  " . ($button ? " AND button_condition = '$button'" : "") . "
                  LIMIT $offset, $limit";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function petsFilter(){
        $_SESSION['filter'] = isset($_SESSION['filter']) ? $_SESSION['filter'] : [
            'id' => false,
            'nombre' => false,
            'fecha' => false
        ];
        if (!isset($_SESSION['filterId'])) {
            $_SESSION['filterId'] = false;
        }
        if (!isset($_SESSION['filterNombre'])) {
            $_SESSION['filterNombre'] = false;
        }
        if (!isset($_SESSION['filterFecha'])) {
            $_SESSION['filterFecha'] = false;
        }
        $sql = "SELECT
        cita.id_cita,
        cita.nombre_mascota,
        cita.tipo_mascota,
        cita.raza,
        cita.peso,
        cita.edad,
        cita.servicio,
        cita.fecha,
        cita.hora,
        COUNT(cita.id_cita) AS citas_count
        FROM cita LEFT JOIN user ON cita.id_user = user.id_user
        GROUP BY cita.id_cita, nombre_mascota, cita.tipo_mascota, cita.raza, cita.peso, cita.edad, cita.servicio, cita.fecha, cita.hora";

        if (isset($_GET['filter'])) {
            switch ($_GET['filter']) {
                case 'id':
                    if(!$_SESSION['filterId']){
                        $sql.= " ORDER BY cita.id_cita DESC";
                        $_SESSION['filterId'] = true;
                    }else{
                        $sql.= " ORDER BY cita.id_cita ASC";
                        $_SESSION['filterId'] = false;
                    }
                    break;
                case 'nombre':
                    if(!$_SESSION['filterNombre']){
                        $sql.= " ORDER BY cita.nombre_mascota DESC";
                        $_SESSION['filterNombre'] = true;
                    }else{
                        $sql.= " ORDER BY cita.nombre_mascota ASC";
                        $_SESSION['filterNombre'] = false;
                    }
                    break;
                case 'fecha':
                    if(!$_SESSION['filterFecha']){
                        $sql.= " ORDER BY fecha DESC";
                        $_SESSION['filterFecha'] = true;
                    }else{
                        $sql.= " ORDER BY fecha ASC";
                        $_SESSION['filterFecha'] = false;
                    }
                    break;
                default:
                    break;
            }
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}