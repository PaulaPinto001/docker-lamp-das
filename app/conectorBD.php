<?php
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

// Obtener los datos JSON enviados por la solicitud
$json_data = json_decode(file_get_contents('php://input'), true);

// Verificar si se envió un parámetro "operacion" en el JSON
if (isset($json_data['operacion'])) {
    $operacion = $json_data['operacion'];
    switch ($operacion) {
        case 'login':
            // Operación de inicio de sesión
            if (isset($json_data['nombre_usuario']) && isset($json_data['contrasena'])) {
                $nombre_usuario = $json_data['nombre_usuario'];
                $contrasena = $json_data['contrasena'];

                // Verificar si las credenciales son válidas
                $query = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario' AND contrasena = '$contrasena'";
                $result = mysqli_query($con, $query);
                if(mysqli_num_rows($result) > 0) {
                    echo 'Inicio de sesión exitoso.';
                } else {
                    echo 'Credenciales incorrectas.';
                }
            } else {
                echo 'Faltan parámetros para la operación de inicio de sesión.';
            }
            break;
        case 'registro':
            // Operación de registro de usuario
            if (isset($json_data['nombre_usuario']) && isset($json_data['contrasena']) && isset($json_data['correo'])) {
                $nombre_usuario = $json_data['nombre_usuario'];
                $contrasena = $json_data['contrasena'];
                $correo = $json_data['correo'];

                // Verificar si el usuario ya existe
                $query = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario'";
                $result = mysqli_query($con, $query);
                if(mysqli_num_rows($result) > 0) {
                    echo 'El usuario ya existe.';
                } else {
                    // Insertar nuevo usuario
                    $query = "INSERT INTO usuarios (nombre_usuario, contrasena, correo) VALUES ('$nombre_usuario', '$contrasena', '$correo')";
                    if(mysqli_query($con, $query)) {
                        echo 'Registro exitoso.';
                    } else {
                        echo 'Error al registrar usuario: ' . mysqli_error($con);
                    }
                }
            } else {
                echo 'Faltan parámetros para la operación de registro de usuario.';
            }
            break;
        default:
            echo 'Operación no válida.';
            break;
    }
} else {
    echo 'Falta el parámetro "operacion" en la solicitud JSON.';
}

// Cierra la conexión a la base de datos
mysqli_close($con);
?>

