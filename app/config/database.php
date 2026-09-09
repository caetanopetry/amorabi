<?php

require_once __DIR__ . '/env.php';

$app_env = env('APP_ENV', 'local');
$db_name = env('DB_NAME', '');
$db_user = env('DB_USER', $app_env === 'production' ? '' : 'root');
$db_pass = env('DB_PASS', $app_env === 'production' ? null : '');

if ($app_env === 'production' && ($db_name === '' || $db_user === '' || $db_pass === null)) {
    error_log('Configuracao de banco incompleta em producao.');
    die("
        <h2>Configuracao indisponivel.</h2>
        <p>Entre em contato com o administrador do sistema.</p>
    ");
}

define('DB_HOST', env('DB_HOST', 'localhost'));
define('DB_PORT', env('DB_PORT', '3306'));
define('DB_NAME', $db_name);
define('DB_USER', $db_user);
define('DB_PASS', (string) $db_pass);

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    error_log("Erro de conexao com o banco: " . $e->getMessage());

    die("
        <h2>Erro ao conectar ao banco de dados.</h2>
        <p>Entre em contato com o administrador do sistema.</p>
    ");
}
