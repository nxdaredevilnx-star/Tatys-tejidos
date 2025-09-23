<?php
// login.php

$client_id = "TU_CLIENT_ID.apps.googleusercontent.com";
$redirect_uri = "http://localhost/mi_tienda/callback.php"; // Ajusta con tu URL

$google_url = "https://accounts.google.com/o/oauth2/v2/auth?"
    . "scope=email%20profile"
    . "&redirect_uri=" . urlencode($redirect_uri)
    . "&response_type=code"
    . "&client_id=" . $client_id
    . "&access_type=online";

?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Login con Google</title>
</head>
<body>
  <a href="<?= $google_url ?>">
    <button>Usar Google</button>
  </a>
</body>
</html>
