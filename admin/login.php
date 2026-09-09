<?php
require_once __DIR__ . '/../app/helpers/functions.php';
start_app_session();
send_security_headers();
send_no_store_headers();

$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (!verify_csrf_token($_POST['_csrf'] ?? null)) {
        $erro = 'Sessao expirada. Recarregue a pagina e tente novamente.';
    } elseif (login_is_locked($email)) {
        $erro = 'Muitas tentativas de login. Aguarde alguns minutos e tente novamente.';
    } elseif (!$pdo) {
        $erro = 'Não foi possível conectar ao banco de dados agora.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE email = ? AND ativo = 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($senha, $user['senha_hash'])) {
            session_regenerate_id(true);
            unset($_SESSION['login_attempts'], $_SESSION['login_locked_until']);
            clear_login_rate($email);
            $_SESSION['admin_logged'] = true;
            $_SESSION['admin_uid'] = $user['id'];
            $_SESSION['admin_nome'] = $user['nome'];
            $_SESSION['admin_nivel'] = $user['nivel'];
            $_SESSION['last_activity'] = time();
            header("Location: index.php");
            exit;
        }

        register_failed_login($email);

        $erro = "E-mail ou senha incorretos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - AMORABI</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body class="login-page">
<div class="login-card">
    <img src="../public/assets/img/amorabi-logo-transparent.png" alt="AMORABI">
    <span class="eyebrow">Painel administrativo</span>
    <h1>Entrar no sistema</h1>
    <p>Use seu acesso administrativo para publicar notícias e acompanhar o painel.</p>

    <?php if ($erro): ?>
        <p class="alert error"><?php echo htmlspecialchars($erro); ?></p>
    <?php endif; ?>

    <form method="POST" class="login-form">
        <?php echo csrf_field(); ?>
        <label>
            <span>E-mail</span>
            <input type="email" name="email" placeholder="admin@amorabi.org.br" autocomplete="username" required>
        </label>
        <label>
            <span>Senha</span>
            <input type="password" name="senha" placeholder="Digite sua senha" autocomplete="current-password" required>
        </label>
        <button type="submit" class="btn">Entrar no Painel</button>
    </form>

    <a class="login-back" href="<?php echo htmlspecialchars(url()); ?>">Voltar para o site</a>
</div>
</body>
</html>
