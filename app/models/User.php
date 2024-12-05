<?php

namespace models;

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

        $query = "INSERT INTO user(password, email) VALUES (:password, :email)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
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
            $_SESSION["accessLevel"] = $user["accessLevel"];
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

}