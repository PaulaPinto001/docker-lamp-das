<?php
// Variables para autenticación
$claveServer = 'AAAARENp08k:APA91bGE5sZYLOyJSwtuEDZ-FGhGBO_OnW2tXtA8NwPcQ2oSxYE549M8bdy481P5EcXHEZ4RYrIZEMr74poLxr3woOpPgIs2VdgzfEEShjAAk57vErd-PhAjWE5mllmq00KfJQkm8zGd';
$projectId = 'dasentrega2';
//Pegar token desde log
$deviceToken = 'fQuljixAQxihhuomlOu8fn:APA91bFgVGlb5-emYVHQbD70BVCZUSiUsavbbX7RP0ZhkbQ8ABp-Ff9rmVy6LlhxbblvvB-XSm6jiDh8bS8vA8kLYnMVb3cWCV-9KS6vT-M7-trPs1ECky5h2Cs9uyMk6Ky-uhmh_JEc';


function crearCabecera($claveServer) {
    return array(
        'Authorization: key=' . $claveServer,
        'Content-Type: application/json'
    );
}

$cabecera= crearCabecera($claveServer);

$msg = array (
    'to' => $deviceToken,
    'data' => array (
        "mensaje" => "Este es mi mensaje",
        "fecha" => "31/03/2020"
    ),
    'notification' => array (
        'body' => 'Notificación enviada desde servidor ',
        'title' => 'FCM notif'
    )
);
$msgJSON= json_encode ( $msg);

$ch = curl_init(); #inicializar el handler de curl
#indicar el destino de la petición, el servicio FCM de google
curl_setopt( $ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
#indicar que la conexión es de tipo POST
curl_setopt( $ch, CURLOPT_POST, true );
#agregar las cabeceras
curl_setopt( $ch, CURLOPT_HTTPHEADER, $cabecera);
#Indicar que se desea recibir la respuesta a la conexión en forma de string
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
#agregar los datos de la petición en formato JSON
curl_setopt( $ch, CURLOPT_POSTFIELDS, $msgJSON );
#ejecutar la llamada
$resultado= curl_exec( $ch );

if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
}
#cerrar el handler de curl
curl_close( $ch );

echo $resultado;
?>

