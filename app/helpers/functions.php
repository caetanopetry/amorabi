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

function send_security_headers(): void
{
    if (headers_sent()) {
        return;
    }

    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');

    if (
        env('APP_ENV', 'local') === 'production'
        && (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    ) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
}

function send_no_store_headers(): void
{
    if (headers_sent()) {
        return;
    }

    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: 0');
}

function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function check_auth() {
    start_app_session();

    if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
        header("Location: login.php");
        exit;
    }

    $inactive_limit = 3600;
    $last_activity = (int) ($_SESSION['last_activity'] ?? time());

    if (time() - $last_activity > $inactive_limit) {
        $_SESSION = [];
        session_destroy();
        header("Location: login.php");
        exit;
    }

    $_SESSION['last_activity'] = time();
}

function has_role(string|array $roles): bool
{
    start_app_session();

    $roles = (array) $roles;
    return isset($_SESSION['admin_nivel']) && in_array($_SESSION['admin_nivel'], $roles, true);
}

function require_role(string|array $roles): void
{
    if (!has_role($roles)) {
        http_response_code(403);
        die('Acesso negado.');
    }
}

function client_ip(): string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    return preg_replace('/[^a-fA-F0-9:\.]/', '', $ip) ?: 'unknown';
}

function storage_path(string $path = ''): string
{
    $base = realpath(__DIR__ . '/../../storage') ?: (__DIR__ . '/../../storage');
    return rtrim($base, DIRECTORY_SEPARATOR) . ($path !== '' ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : '');
}

function login_rate_key(string $email): string
{
    return hash('sha256', strtolower(trim($email)) . '|' . client_ip());
}

function login_rate_file(string $email): ?string
{
    $dir = storage_path('cache/login_attempts');
    if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
        return null;
    }

    if (!is_writable($dir)) {
        return null;
    }

    return $dir . DIRECTORY_SEPARATOR . login_rate_key($email) . '.json';
}

function login_rate_state(string $email): array
{
    $file = login_rate_file($email);
    if (!$file) {
        return ['attempts' => 0, 'locked_until' => 0];
    }

    if (!is_file($file)) {
        return ['attempts' => 0, 'locked_until' => 0];
    }

    $state = json_decode((string) file_get_contents($file), true);
    return is_array($state) ? $state + ['attempts' => 0, 'locked_until' => 0] : ['attempts' => 0, 'locked_until' => 0];
}

function login_is_locked(string $email): bool
{
    $state = login_rate_state($email);
    return (int) $state['locked_until'] > time();
}

function register_failed_login(string $email): void
{
    $file = login_rate_file($email);
    if (!$file) {
        return;
    }

    $state = login_rate_state($email);
    $attempts = (int) $state['attempts'] + 1;
    $locked_until = $attempts >= 5 ? time() + 600 : 0;

    file_put_contents($file, json_encode([
        'attempts' => $attempts,
        'locked_until' => $locked_until,
        'updated_at' => time(),
    ]), LOCK_EX);
}

function clear_login_rate(string $email): void
{
    $file = login_rate_file($email);
    if ($file && is_file($file)) {
        unlink($file);
    }
}

function safe_child_path(string $base_dir, string $relative_path): ?string
{
    $base = realpath($base_dir);
    if ($base === false) {
        return null;
    }

    $relative_path = str_replace('\\', '/', ltrim($relative_path, '/\\'));
    if ($relative_path === '' || str_contains($relative_path, '../') || str_contains($relative_path, '..\\')) {
        return null;
    }

    $path = $base . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative_path);
    $parent = realpath(dirname($path));

    if ($parent === false || !str_starts_with($parent . DIRECTORY_SEPARATOR, $base . DIRECTORY_SEPARATOR)) {
        return null;
    }

    return $path;
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
