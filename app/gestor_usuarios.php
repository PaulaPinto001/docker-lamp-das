<?php
// gestor_usuarios.php

function obtenerDatosUsuario($username) {
    // Conectar a la base de datos
    $DB_SERVER = "34.70.105.230";
    $DB_USER = "usuario";
    $DB_PASS = "password";
    $DB_DATABASE = "nombreBD";

    // Conexión a la base de datos
    $con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_DATABASE);
    if (mysqli_connect_errno()) {
        echo 'Error de conexión: ' . mysqli_connect_error();
        exit();
    }

    // Obtener datos del usuario
    $query = "SELECT * FROM usuarios WHERE username = '$username'";
    $result = mysqli_query($con, $query);
    if(mysqli_query($con, $query)) {
        // Devolver los datos
        echo json_encode($result);
    } else {
        echo 'Error al obtener datos de usuario: ' . mysqli_error($con);
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
        echo 'Error de conexión: ' . mysqli_connect_error();
        exit();
    }

    // Verificar si las credenciales son válidas
    $query = "SELECT * FROM usuarios WHERE username = '$username' AND psw = '$psw'";
    $result = mysqli_query($con, $query);
    if(mysqli_num_rows($result) > 0) {
        $ok = true;
    } else {
        $ok = false;
    }

    // Devolver confirmación
    echo json_encode($ok);
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
        echo 'Error de conexión: ' . mysqli_connect_error();
        exit();
    }

    // Verificar si el usuario ya existe
    $query = "SELECT * FROM usuarios WHERE username = '$username'";
    $result = mysqli_query($con, $query);
    if(mysqli_num_rows($result) > 0) {
        $ok = 'Ya existe un usuario con este username';
    } else {
        // Insertar nuevo usuario
        $query = "INSERT INTO usuarios (username, psw, name, email) VALUES ('$username', '$psw', '$name', '$email')";
        if(mysqli_query($con, $query)) {
            $ok = true;
        } else {
            echo 'Error al registrar usuario: ' . mysqli_error($con);
            $ok = false;
        }
    }

    // Devolver confirmación
    echo json_encode($ok);
}
