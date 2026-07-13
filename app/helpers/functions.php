<?php
function start_app_session() {
    if (session_status() !== PHP_SESSION_NONE) {
        return;
    }

    $secure_cookie = (env('APP_ENV', 'local') === 'production')
        || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    $cookie_path = app_base_path();

    session_name('AMORABI_SESS');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => $cookie_path !== '' ? $cookie_path . '/' : '/',
        'secure' => $secure_cookie,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

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

function csrf_token(): string
{
    start_app_session();

    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['_csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

function verify_csrf_token(?string $token): bool
{
    start_app_session();

    return is_string($token)
        && isset($_SESSION['_csrf_token'])
        && hash_equals($_SESSION['_csrf_token'], $token);
}

function excerpt_text($text, $limit = 160) {
    $text = trim(strip_tags((string) $text));
    if (mb_strlen($text, 'UTF-8') <= $limit) {
        return $text;
    }

    return rtrim(mb_substr($text, 0, $limit - 3, 'UTF-8')) . '...';
}



function app_base_path(): string
{
    $app_url = env('APP_URL', '');
    $path = $app_url ? (parse_url($app_url, PHP_URL_PATH) ?: '') : '';

    if ($path === '') {
        $script_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        $script_dir = rtrim($script_dir, '/');

        if (preg_match('#/(admin|public)$#', $script_dir)) {
            $script_dir = dirname($script_dir);
        }

        $path = ($script_dir === '/' || $script_dir === '.') ? '' : $script_dir;
    }

    return rtrim($path, '/');
}

function url(string $path = ''): string
{
    $base = app_base_path();
    $path = trim($path, '/');

    if ($path === '') {
        return $base !== '' ? $base . '/' : '/';
    }

    return $base . '/' . $path;
}

function asset_url(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function upload_url(string $path): string
{
    return url('uploads/' . ltrim($path, '/'));
}

function current_route(): string
{
    $request_path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $base = app_base_path();

    if ($base !== '' && str_starts_with($request_path, $base)) {
        $request_path = substr($request_path, strlen($base));
    }

    $route = trim($request_path, '/');

    if (str_starts_with($route, 'public/')) {
        $route = substr($route, 7);
    }

    if (str_ends_with($route, '.php')) {
        $route = substr($route, 0, -4);
    }

    return $route;
}
?>
