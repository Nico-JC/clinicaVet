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

    public function getPaginatedCitas($offset, $limit, $filter = null, $order = "ASC") {
        // preparo un listado con el nombre que puedo recibir y su tabla de referencia
        $filterMap = [
            'id' => 'id_cita',
            'nombre' => 'nombre_mascota',
            'fecha' => 'fecha'
            // para agregar otro filtro coloca primero una coma despues de 'fecha' asi => 'fecha',
            // despues pone:
            // 'parametro que recibo' => 'tabla de mi DB'
            /*
             y en el html andate al header tr de la columba y agrega:

            onclick="window.location.href='appointment_date.php?filter=XXXXX&order=<?= ($filter == 'nombre' && $order == 'ASC') ? 'DESC' : 'ASC' ?>'">

            en XXXXX coloca el nombre que se va a enviar a este codigo como te dije arriba
              */
        ];

        // busco el nombre que recibo y tomo su tabla correspondiente o anulo el filtro
        if (isset($filterMap[$filter])) {
            $filter = $filterMap[$filter];
        } else {
            $filter = null;
        }

        $query = "SELECT * FROM cita" .
            ($filter ? " ORDER BY $filter $order" : "") .
            " LIMIT :offset, :limit";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

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

    public function butonAction($action, $citaId, $currentRole = null){
        //DELETE
        if ($action == 'delete'){
            $deleteCita = "DELETE FROM cita WHERE id_cita = :id_cita";
            $stmt = $this->conn->prepare($deleteCita);
            $stmt->bindParam(':id_cita', $citaId, PDO::PARAM_INT);
            $stmt->execute();

            return $this->getAllCitas();
        }

        // CHANGE ROL
        elseif ($action == 'actualizar'){
            // Alternar entre 1 (Admin) y 0 (Usuario)
            $cambiarRol = ($currentRole == '1') ? '0' : '1';

            $consultaUpdate = "UPDATE user SET accessLevel = :cambiarRol WHERE id_user = :userId";
            $stmt = $this->conn->prepare($consultaUpdate);
            $stmt->bindParam(':cambiarRol', $cambiarRol, PDO::PARAM_INT);
            $stmt->bindParam(':userId', $citaId, PDO::PARAM_INT);
            $stmt->execute();

            return $this->getAllCitas();
        }
        return $this->getAllCitas();
    }

}