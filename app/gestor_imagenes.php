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
    $DB_SERVER = "db";
    $DB_USER = "admin";
    $DB_PASS = "test";
    $DB_DATABASE = "database";

    // Conexión a la base de datos
    $con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_DATABASE);
    if (mysqli_connect_errno()) {
        return array("error" => "Error de conexion: " . mysqli_connect_error());
    }

    // Verificar si ya existe una entrada para el usuario y la película
    $query = "SELECT * FROM fotosPeliculas WHERE idPelicula='$idPeli' AND user='$user'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // Ya existe una entrada para este usuario y película, actualiza la ruta de la foto
        $updateQuery = "UPDATE fotosPeliculas SET path='$path' WHERE idPelicula='$idPeli' AND user='$user'";
        $updateResult = mysqli_query($con, $updateQuery);

        if ($updateResult) {
            return array("success" => "Foto actualizada correctamente");
        } else {
            return array("error" => "Error al actualizar foto: " . mysqli_error($con));
        }
    } else {
        // No existe una entrada, inserta una nueva fila
        $insertQuery = "INSERT INTO fotosPeliculas (idPelicula, user, path) VALUES ('$idPeli', '$user', '$path')";
        $insertResult = mysqli_query($con, $insertQuery);

        if ($insertResult) {
            return array("success" => "Foto guardada correctamente");
        } else {
            return array("error" => "Error al guardar foto: " . mysqli_error($con));
        }
    }
}


function obtenerFoto($user, $idPeli) {
    // Conectar a la base de datos
    $DB_SERVER = "db";
    $DB_USER = "admin";
    $DB_PASS = "test";
    $DB_DATABASE = "database";

    // Conexión a la base de datos
    $con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_DATABASE);
    if (mysqli_connect_errno()) {
        return array("error" => "Error de conexión: " . mysqli_connect_error());
    }

    // Obtener datos de la foto de la tabla fotosPeliculas
    $query = "SELECT path FROM fotosPeliculas WHERE idPelicula = '$idPeli' AND user = '$user'";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $photoData = mysqli_fetch_assoc($result);
        return array("success" => $photoData);
    } else {
        return array("error" => "No se encontro la foto para el usuario y la pelicula especificados");
    }
}
?>
