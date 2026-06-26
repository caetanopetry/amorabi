<?php
require_once __DIR__ . '/../app/helpers/functions.php';
start_app_session();
session_destroy();
header("Location: login.php");
exit;
?>
