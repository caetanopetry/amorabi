<?php
function start_app_session() {
    if (session_status() !== PHP_SESSION_NONE) {
        return;
    }

    $session_path = __DIR__ . '/../../storage/sessions';
    if (!is_dir($session_path)) {
        mkdir($session_path, 0775, true);
    }
    if (is_writable($session_path)) {
        session_save_path($session_path);
    }
    session_start();
}

require_once __DIR__ . '/../config/database.php';

function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function check_auth() {
    start_app_session();

    if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
        header("Location: login.php");
        exit;
    }
}

function get_site_config($chave, $default = '') {
    global $pdo;

    if (!$pdo) {
        return $default;
    }

    try {
        $stmt = $pdo->prepare("SELECT valor FROM site_config WHERE chave = ?");
        $stmt->execute([$chave]);
        $res = $stmt->fetch();
        return $res ? $res['valor'] : $default;
    } catch (Exception $e) {
        return $default;
    }
}

function fetch_all_safe($sql, $params = []) {
    global $pdo;

    if (!$pdo) {
        return [];
    }

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

function fetch_one_safe($sql, $params = []) {
    global $pdo;

    if (!$pdo) {
        return null;
    }

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result ?: null;
    } catch (Exception $e) {
        return null;
    }
}

function make_slug($text) {
    $text = trim((string) $text);
    $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
    $text = strtolower($text ?: '');
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    $text = trim($text, '-');
    return $text !== '' ? $text : 'item';
}

function excerpt_text($text, $limit = 160) {
    $text = trim(strip_tags((string) $text));
    if (mb_strlen($text, 'UTF-8') <= $limit) {
        return $text;
    }

    return rtrim(mb_substr($text, 0, $limit - 3, 'UTF-8')) . '...';
}
?>
