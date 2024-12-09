<?php

namespace controllers;

use http\Exception\BadConversionException;
use models\User;

require_once __DIR__ . '/../models/User.php';
require_once  __DIR__ . '/../../config/Data/DBConfig.php';
class UserController
{
    private $user;
    private $conexion;

    public function __construct(){
        $this->conexion = (new \Database)->getConnection();
        $this->user = new User($this->conexion);
    }

    public function register($email, $password, $confirm_password) {
        if ($this->user->mailExists($email)) {
            header("Location: /tp-clinica-vet/app/views/user/register.php?error=1");
            exit();
        } elseif ($password !== $confirm_password) {
            header("Location: /tp-clinica-vet/app/views/user/register.php?error=2");
            exit();
        } else {
            $this->user->register($email, $password);
            header("Location: /tp-clinica-vet/app/views/user/logIn.php");
            exit();
        }
    }

    public function logIn($email, $password){
        if ($this->user->login($email ,$password)){
            header("Location: /tp-clinica-vet/index.php");
            exit();
        }
        header("Location: /tp-clinica-vet/app/views/user/logIn.php?error=1");
        exit();
    }

    public function getAllUsers($filter = null, $button = null){
        if ($button !== null) {
            switch ($button) {
                case 'delete':
                    if (isset($_POST['userId'])) {
                        return $this->user->butonAction('delete', $_POST['userId']);
                    }
                    break;
                case 'asignar':
                    if (isset($_POST['emailID']) && isset($_POST['currentRole'])) {
                        return $this->user->butonAction('asignar', $_POST['emailID'], $_POST['currentRole']);
                    }
                    break;
            }
        }
        if ($filter !== null) {
            return $this->user->filter();
        }
        return $this->user->getAllUsers();
    }

    public function getAllCitas($filter = null, $button = null){
        if ($button !== null) {
            switch ($button) {
                case 'delete':
                    if (isset($_POST['userId'])) {
                        return $this->user->petsFilter('delete', $_POST['userId']);
                    }
                    break;
                case 'asignar':
                    if (isset($_POST['emailID']) && isset($_POST['currentRole'])) {
                        return $this->user->butonAction('asignar', $_POST['emailID'], $_POST['currentRole']);
                    }
                    break;
            }
        }
        if ($filter !== null) {
            return $this->user->filter();
        }
        return $this->user->getAllCitas();
    }
}