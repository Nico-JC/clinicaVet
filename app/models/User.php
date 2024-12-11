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

    public function filter(){
        $_SESSION['filter'] = isset($_SESSION['filter']) ? $_SESSION['filter'] : [
            'id' => false,
            'email' => false,
            'rol' => false
        ];
        if (!isset($_SESSION['filterId'])) {
            $_SESSION['filterId'] = false;
        }
        if (!isset($_SESSION['filterEmail'])) {
            $_SESSION['filterNom'] = false;
        }
        if (!isset($_SESSION['filterRol'])) {
            $_SESSION['filterRol'] = false;
        }
        $sql = "SELECT
        user.id_user,
        user.email,
        user.id_permisos
        FROM user 
        GROUP BY user.id_user, user.email, user.id_permisos";

        if (isset($_GET['filter'])) {
            switch ($_GET['filter']) {
                case 'id':
                    if(!$_SESSION['filterId']){
                        $sql.= " ORDER BY user.id_user DESC";
                        $_SESSION['filterId'] = true;
                    }else{
                        $sql.= " ORDER BY user.id_user ASC";
                        $_SESSION['filterId'] = false;
                    }
                    break;
                case 'email':
                    if(!$_SESSION['filterEmail']){
                        $sql.= " ORDER BY user.email DESC";
                        $_SESSION['filterEmail'] = true;
                    }else{
                        $sql.= " ORDER BY user.email ASC";
                        $_SESSION['filterEmail'] = false;
                    }
                    break;
                case 'rol':
                    if(!$_SESSION['filterRol']){
                        $sql.= " ORDER BY id_permisos DESC";
                        $_SESSION['filterRol'] = true;
                    }else{
                        $sql.= " ORDER BY id_permisos ASC";
                        $_SESSION['filterRol'] = false;
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

    public function butonAction($action, $userId, $currentRole = null){
        //DELETE
        if ($action == 'delete'){
            // Primero borramos las consultas que hizo el usuario de la tabla consulta
            $deleteConsulta = "DELETE FROM consult WHERE id_user = :userId";
            $stmt = $this->conn->prepare($deleteConsulta);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            // Despues borramos al usuario de la tabla user
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

}