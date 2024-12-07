<?php
//llamamos todos los datos de la tabla user para mostrar
$consulta = "SELECT * FROM user";
$resultado = mysqli_query($conexion, $consulta);

//Botones
if (isset($_POST['action'])):

        // ELIMINAR
    if ($_POST['action'] == 'delete'):
        $userId = $_POST['userId'];
    //primero borramos las consultas que hizo que ulsuario de la tabla consulta
        $deleteConsulta = "DELETE FROM consult WHERE id_user = $userId";
        mysqli_query($conexion, $deleteConsulta);
        //despues borramos al usuario de la tabla user
        $consultaDeleteUser = "DELETE FROM user WHERE id_user = $userId";
        mysqli_query($conexion, $consultaDeleteUser);

        //ASIGNAR / CAMBIAR ROL
    elseif ($_POST['action'] == 'asignar'):
        $userId = $_POST['userId'];
        $cambiarRol = ($_POST['rolActual'] == '1') ? '0' : '1'; //para alternar entre 1 (Admin) y 0 (Usuario)
        $consultaUpdate = "UPDATE user SET accessLevel = $cambiarRol WHERE id_user = $userId";
        mysqli_query($conexion, $consultaUpdate);
    endif;
endif;

//inicializamos los valores de los filtros en la supervariable SESSION para que se guarden
$resultado = null;
if (!isset($_SESSION['filterId'])) {
    $_SESSION['filterId'] = false;
}
if (!isset($_SESSION['filterNom'])) {
    $_SESSION['filterNom'] = false;
}
if (!isset($_SESSION['filterCon'])) {
    $_SESSION['filterCon'] = false;
}
//creamos una variable llamada sql con una parte de la consulta a realizar dependiendo del filtrado
$sql = "SELECT
        user.id_user,
        user.username,
        user.accessLevel,
        COUNT(consult.id_consulta) AS consultas_count
        FROM user LEFT JOIN consult ON user.id_user = consult.id_user
        GROUP BY user.id_user,user.username, user.accessLevel";

//condifionales para saber que tipo de filtrado se seleccionó con un $_GET en la misma sesión
//uso de una funcion para no repetir la conexion a la BD
if (isset($_GET["filter"])){
    switch ($_GET["filter"]){
        case "id" :
            if(!$_SESSION['filterId']){
                $sql.= " ORDER BY user.id_user DESC";
                $_SESSION['filterId'] = true;
            }else{
                $sql.= " ORDER BY user.id_user ASC";
                $_SESSION['filterId'] = false;
            }
            $resultado = ejecutarSQL($sql,$conexion);
            break;

        case "nombre" :
            if(!$_SESSION['filterNom']){
                $sql.= " ORDER BY user.username DESC";
                $_SESSION['filterNom'] = true;
            }else{
                $sql.= " ORDER BY user.username ASC";
                $_SESSION['filterNom'] = false;
            }
            $resultado = ejecutarSQL($sql,$conexion);
            break;

        case "consulta" :
            if(!$_SESSION['filterCon']){
                $sql.= " ORDER BY consultas_count DESC";
                $_SESSION['filterCon'] = true;
            }else{
                $sql.= " ORDER BY consultas_count ASC";
                $_SESSION['filterCon'] = false;
            }
            $resultado = ejecutarSQL($sql,$conexion);
            break;

        default:
            $resultado = ejecutarSQL($sql,$conexion);
            break;
    }
}else{
    $resultado = ejecutarSQL($sql,$conexion);
}