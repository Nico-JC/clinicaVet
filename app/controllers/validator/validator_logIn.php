<?php

use controllers\UserController;
require_once '../UserController.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['userPassword']);

    $userController = new UserController();
    $userController->logIn($email, $password);
}