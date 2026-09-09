<?php
require_once __DIR__ . '/../app/helpers/functions.php';
start_app_session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf_token($_POST['_csrf'] ?? null)) {
    header("Location: index.php");
    exit;
}

$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, [
        'expires' => time() - 42000,
        'path' => $params['path'],
        'domain' => $params['domain'],
        'secure' => $params['secure'],
        'httponly' => $params['httponly'],
        'samesite' => $params['samesite'] ?? 'Lax',
    ]);
}

session_destroy();
header("Location: login.php");
exit;
?>
