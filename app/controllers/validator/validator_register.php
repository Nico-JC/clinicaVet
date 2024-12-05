<?php

use controllers\UserController;
require_once '../UserController.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['userPassword']);
    $confirm_password = trim($_POST['confirm_password']);

    $userController = new UserController();
    $userController->register($email, $password, $confirm_password);
}