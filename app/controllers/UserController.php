<?php

namespace controllers;

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

}