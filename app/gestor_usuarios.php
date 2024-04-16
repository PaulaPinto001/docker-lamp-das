<?php
// gestor_usuarios.php

$op = $_POST["op"];
switch ($op) {
    case "login":
        $user = $_POST["username"];
        $psw = $_POST["password"];
        realizarLogin($user, $psw);
        break;
    case "register":
        $user = $_POST["username"];
        $psw = $_POST["password"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        registrarNuevoUsuario($user, $psw, $name, $email);
        break;
    case "getData":
        $user = $_POST["username"];
        obtenerDatosUsuario($user);
        break;
    default:
        echo "Operación no valida";
}

function obtenerDatosUsuario($username) {
    // Conectar a la base de datos
    $DB_SERVER = "34.70.105.230";
    $DB_USER = "usuario";
    $DB_PASS = "password";
    $DB_DATABASE = "nombreBD";

    // Conexión a la base de datos
    $con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_DATABASE);
    if (mysqli_connect_errno()) {
        return array("error" => "Error de conexión: " . mysqli_connect_error());
    }

    // Obtener datos del usuario
    $query = "SELECT * FROM usuarios WHERE username = '$username'";
    $result = mysqli_query($con, $query);
    if ($result) {
        $userData = mysqli_fetch_assoc($result);
        return $userData;
    } else {
        return array("error" => "Error al obtener datos de usuario: " . mysqli_error($con));
    }
}

function realizarLogin($username, $psw) {
    // Conectar a la base de datos
    $DB_SERVER = "34.70.105.230";
    $DB_USER = "usuario";
    $DB_PASS = "password";
    $DB_DATABASE = "nombreBD";

    // Conexión a la base de datos
    $con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_DATABASE);
    if (mysqli_connect_errno()) {
        return array("error" => "Error de conexión: " . mysqli_connect_error());
    }

    // Verificar si las credenciales son válidas
    $query = "SELECT * FROM usuarios WHERE username = '$username' AND psw = '$psw'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function registrarNuevoUsuario($username, $psw, $name, $email) {
    // Conectar a la base de datos
    $DB_SERVER = "34.70.105.230";
    $DB_USER = "usuario";
    $DB_PASS = "password";
    $DB_DATABASE = "nombreBD";

    // Conexión a la base de datos
    $con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_DATABASE);
    if (mysqli_connect_errno()) {
        return array("error" => "Error de conexión: " . mysqli_connect_error());
    }

    // Verificar si el usuario ya existe
    $query = "SELECT * FROM usuarios WHERE username = '$username'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        return "Ya existe un usuario con este username";
    } else {
        // Insertar nuevo usuario
        $query = "INSERT INTO usuarios (username, psw, name, email) VALUES ('$username', '$psw', '$name', '$email')";
        if (mysqli_query($con, $query)) {
            return true;
        } else {
            return array("error" => "Error al registrar usuario: " . mysqli_error($con));
        }
    }
}
?>

