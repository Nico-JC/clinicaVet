<?php

namespace models;

use controllers\UserController;
use PDO;
use PDOException;

class User
{
    private $conn;
    public $id;
    public $email;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($email, $password) {
        $email = htmlspecialchars(strip_tags($email));
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO user(password, email, id_permisos) VALUES (:password, :email, :id_permisos)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':id_permisos', 3, PDO::PARAM_INT);
        try {
            return $stmt->execute();
        } catch(PDOException $exception) {
            error_log("Error en registro: " . $exception->getMessage());
            return false;
        }
    }

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION["email"] = $user["email"];
            $_SESSION["userId"] = $user["id_user"];
            $_SESSION["id_permisos"] = $user["id_permisos"];
            return true;
        }
        return false;
    }

    public function mailExists($email){
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers(){
        $query = "SELECT * FROM user";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaginatedUsers($offset, $limit, $filter = null, $order = "ASC") {
        $filterMap = [
            'id' => 'id_user',
            'email' => 'email',
            'rol' => 'id_permisos'
        ];

        if (isset($filterMap[$filter])) {
            $filter = $filterMap[$filter];
        } else {
            $filter = null;
        }

        $query = "SELECT * FROM user" .
            ($filter ? " ORDER BY $filter $order" : "") .
            " LIMIT :offset, :limit";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function showConsult(){
        $query = "SELECT * FROM consult";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function butonAction($action, $userId, $currentRole = null){
        //DELETE
        if ($action == 'delete'){
            $deleteUser = "DELETE FROM user WHERE id_user = :userId";
            $stmt = $this->conn->prepare($deleteUser);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();

            return $this->getAllUsers();
        }

        // CHANGE ROL
        elseif ($action == 'asignar'){
            // Alternar entre 1 (Admin) y 0 (Usuario)
            $cambiarRol = ($currentRole == '2') ? '3' : '2';

            $consultaUpdate = "UPDATE user SET id_permisos = :cambiarRol WHERE id_user = :userId";
            $stmt = $this->conn->prepare($consultaUpdate);
            $stmt->bindParam(':cambiarRol', $cambiarRol, PDO::PARAM_INT);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();

            return $this->getAllUsers();
        }
        return $this->getAllUsers();
    }

    public function registerConsult($nombre, $apellido, $email, $telefono, $consulta) {
        $nombre = htmlspecialchars(strip_tags($nombre));
        $apellido = htmlspecialchars(strip_tags($apellido));
        $email = htmlspecialchars(strip_tags($email));
        $telefono = htmlspecialchars(strip_tags($telefono));
        $consulta = htmlspecialchars(strip_tags($consulta));

        $query = "INSERT INTO consult (name, last_name, email, phone_number, text) VALUES (:name, :last_name, :email, :phone_number, :text)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':name', $nombre, PDO::PARAM_STR);
        $stmt->bindValue(':last_name', $apellido, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':phone_number', $telefono, PDO::PARAM_STR);
        $stmt->bindValue(':text', $consulta, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function getPetsByUserId($userId) {
        $query = "SELECT DISTINCT nombre_mascota, tipo_mascota, raza, edad 
                  FROM cita 
                  WHERE id_user = :userId 
                  GROUP BY nombre_mascota";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMedicalHistoryByPetName($userId, $nombreMascota){
        $query = "SELECT fecha, hora, diagnostico, tratamiento, veterinario
                  FROM cita 
                  WHERE id_user = :userId AND nombre_mascota = :nombreMascota 
                  ORDER BY fecha DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':nombreMascota', $nombreMascota, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaginatedConsult($offset, $limit) {

        $query = "SELECT * FROM consult LIMIT :offset, :limit";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteConsult($action, $consultaId){
        if ($action == 'delete'){
            $deleteConsult = "DELETE FROM consult WHERE id_consulta = :id_consulta";
            $stmt = $this->conn->prepare($deleteConsult);
            $stmt->bindParam(':id_consulta', $consultaId, PDO::PARAM_INT);
            $stmt->execute();

            return $this->showConsult();
        }
        return false;
    }

}