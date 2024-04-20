<?php
// gestor_imagenes.php

$op = $_POST["op"];
switch ($op) {
    case "getImg":
        $user = $_POST["username"];
        $id = $_POST["id"];
        echo json_encode(obtenerFoto($user, $id));
        break;
    case "guardarRuta":
        $user = $_POST["username"];
        $path = $_POST["path"];
        $id = $_POST["id"];
        echo json_encode(guardarFoto($user, $path, $id));
        break;
    default:
        echo json_encode(array("error" => "Operacion no valida"));
}

function guardarFoto($user, $path, $idPeli) {
    // Conectar a la base de datos
    $DB_SERVER = "34.70.105.230";
    $DB_USER = "usuario";
    $DB_PASS = "password";
    $DB_DATABASE = "nombreBD";

    // Conexión a la base de datos
    $con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_DATABASE);
    if (mysqli_connect_errno()) {
        return array("error" => "Error de conexion: " . mysqli_connect_error());
    }

    // Insertar datos de la foto en la tabla fotosPeliculas
    $query = "INSERT INTO fotosPeliculas (idPelicula, user, path) VALUES ('$idPeli', '$user', '$path')";
    $result = mysqli_query($con, $query);
    if ($result) {
        return array("success" => "Foto guardada correctamente");
    } else {
        return array("error" => "Error al guardar foto: " . mysqli_error($con));
    }
}

function obtenerFoto($user, $idPeli) {
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

    // Obtener datos de la foto de la tabla fotosPeliculas
    $query = "SELECT * FROM fotosPeliculas WHERE idPelicula = '$idPeli' AND user = '$user'";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $photoData = mysqli_fetch_assoc($result);
        return array("success" => $photoData);
    } else {
        return array("error" => "No se encontro la foto para el usuario y la pelicula especificados");
    }
}
?>
