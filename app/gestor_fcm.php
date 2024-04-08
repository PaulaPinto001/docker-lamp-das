<?php
// gestor_fcm.php

// Incluir la biblioteca de Firebase JWT
require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;

function enviarMensaje() {
    // Variables para autenticación
    $firebaseApiKey = 'AIzaSyBIwi7D2j2f0OgGjrN7fWAfAIKJhEfBnAQ';
    $projectId = 'dasentrega2';

    // Crear el token de autenticación
    $token = [
        'iss' => 'firebase-adminsdk-' . $projectId . '@' . $projectId . '.iam.gserviceaccount.com',
        'sub' => 'firebase-adminsdk-' . $projectId . '@appspot.gserviceaccount.com',
        'aud' => 'https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit',
        'iat' => time(),
        'exp' => time() + 3600,
        'uid' => null
    ];

    $jwt = JWT::encode($token, $firebaseApiKey);

    // Datos del mensaje FCM
    $mensage = [
        'message' => [
            'notification' => [
                'title' => 'Este es un mensaje de FCM',
                'body' => 'Hola'
            ]
        ]
    ];

    // URL de la API de FCM
    $url = 'https://fcm.googleapis.com/v1/projects/' . $projectId . '/messages:send';

    // Configurar la solicitud HTTP
    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\n" .
                        "Authorization: Bearer $jwt\r\n",
            'method' => 'POST',
            'content' => json_encode($mensage)
        ]
    ];

    // Realizar la solicitud HTTP
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    // Manejar la respuesta
    if ($result === false) {
        return "Error al enviar el mensaje: " . error_get_last()['message'];
    } else {
        return "Mensaje enviado correctamente";
    }
}
?>
