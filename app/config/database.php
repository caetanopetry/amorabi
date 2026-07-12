<?php



define('DB_HOST', 'localhost');          
define('DB_NAME', 'u158282979_db_TnNP4Cu2');
define('DB_USER', 'u158282979_usr_TnNP4Cu2');
define('DB_PASS', 'An17ma81');

try {

    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );

} catch (PDOException $e) {


    error_log("Erro de conexão com o banco: " . $e->getMessage());


    die("
        <h2>Erro ao conectar ao banco de dados.</h2>
        <p>Entre em contato com o administrador do sistema.</p>
    ");
}