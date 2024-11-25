<?php

//COMO CONECTARSE A UNA BASE DE DATOS MySqli

//ALMACENAR EN VARIABLES LOS PARAMETROS PARA CONECTARNOS A LA BASE DE DATOS
$servidor = "127.0.0.1"; //esa IP equivale a localhost
$usuario = "root"; //root equivale a la cuenta de un admin, tiene todos los provilegios
$password = "";//CONTRASEÑA DEL USUARIO
$db = "veterinaria";//BASE DE DATOS
$puerto = "3306";

//CONECTARONOS A LA BASE DE DATOS (PROCEDURAL)================================================================

$conexion = mysqli_connect($servidor, $usuario, $password, $db, $puerto);

//VERIFICAR SI LA CONECCOIN NO RESULTO EXITOSA

if (!$conexion) {
    echo "Coneccion fallida<br>" . mysqli_connect_error();
}




