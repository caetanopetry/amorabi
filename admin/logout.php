<?php
require_once __DIR__ . '/../app/helpers/functions.php';
start_app_session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf_token($_POST['_csrf'] ?? null)) {
    header("Location: index.php");
    exit;
}

session_destroy();
header("Location: login.php");
exit;
?>
