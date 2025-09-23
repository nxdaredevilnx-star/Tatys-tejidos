<?php
// callback.php

session_start();

$client_id = "TU_CLIENT_ID.apps.googleusercontent.com";
$client_secret = "TU_CLIENT_SECRET";
$redirect_uri = "http://localhost/tatys_tejidos/callback.php"; // Ajusta

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // 1. Intercambiar el code por un token
    $token_url = "https://oauth2.googleapis.com/token";

    $data = [
        "code" => $code,
        "client_id" => $client_id,
        "client_secret" => $client_secret,
        "redirect_uri" => $redirect_uri,
        "grant_type" => "authorization_code"
    ];

    $options = [
        "http" => [
            "header"  => "Content-Type: application/x-www-form-urlencoded\r\n",
            "method"  => "POST",
            "content" => http_build_query($data),
        ],
    ];

    $context  = stream_context_create($options);
    $response = file_get_contents($token_url, false, $context);
    $token = json_decode($response, true);

    if (isset($token["access_token"])) {
        // 2. Usar el token para obtener datos del usuario
        $userinfo_url = "https://www.googleapis.com/oauth2/v2/userinfo?access_token=" . $token["access_token"];
        $user_info = file_get_contents($userinfo_url);
        $user = json_decode($user_info, true);

        // Guardamos al usuario en la sesión
        $_SESSION['user'] = $user;

        // Redirigir a página de bienvenida
        header("Location: ../php/welcome.php");
        exit;
    } else {
        echo "Error al obtener el token.";
    }
} else {
    echo "No se recibió código de autorización.";
}
