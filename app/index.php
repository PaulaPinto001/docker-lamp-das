<?php
// phpinfo();
$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

$conn = mysqli_connect($hostname, $username, $password, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$query = mysqli_query($conn, "SELECT * FROM usuarios") or die(mysqli_error($conn));

while ($row = mysqli_fetch_array($query)) {
    echo
        "<tr>
    <td>{$row['username']}</td>
    <td>{$row['password']}</td>
    <td>{$row['name']}</td>
    <td>{$row['email']}</td>
   </tr>";
}

// Obtener solicitud y parametros
$method = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['REQUEST_URI'];
$params = explode('/', trim($request, '/'));

// Enrutamiento
switch ($params[0]) {
    case 'usuarios':
        require_once 'gestor_usuarios.php';
        // Manejar solicitudes POST para usuarios
        // Más adelante podrían implementarse GET, PUT y DELETE

        if ($method === 'POST') { // opciones: /login (body: user, psw), register (body: user, psw, name, email) o /getData (body: user)
            $operacion = $params[1];

            // Obtener el cuerpo de la solicitud POST
            $cuerpo_solicitud = file_get_contents('php://input');

            // Decodificar el cuerpo de la solicitud JSON en un array asociativo
            $array_datos = json_decode($cuerpo_solicitud, true);

            if ($operacion === 'login') {
                $username = $array_datos['username'];
                $psw = $array_datos['psw'];
                $ok = realizarLogin($username, $psw);
                echo $ok;
            } elseif ($operacion === 'getData') {
                $username = $array_datos['username'];
                $datos = obtenerDatosUsuario($username);
                echo $datos;
            } elseif ($operacion === 'register') {
                $username = $array_datos['username'];
                $psw = $array_datos['psw'];
                $name = $array_datos['name'];
                $email = $array_datos['email'];
                $ok = obtenerDatosUsuario($username, $psw, $name, $email);
                echo $ok;
            }
        }
        break;

    default:
        // Si la ruta no coincide con ninguna de las rutas definidas, devolver un error
        http_response_code(404);
        echo json_encode(array("mensaje" => "Ruta no encontrada"));
}
?>

