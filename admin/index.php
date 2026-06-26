<?php
require_once __DIR__ . '/../app/helpers/functions.php';
check_auth();

if (!$pdo) {
    die('Sem conexão com o banco de dados.');
}

$mensagens = (int) $pdo->query("SELECT COUNT(*) FROM mensagens_contato WHERE lida = 0")->fetchColumn();
$noticias = (int) $pdo->query("SELECT COUNT(*) FROM noticias")->fetchColumn();
$publicadas = (int) $pdo->query("SELECT COUNT(*) FROM noticias WHERE status = 'publicado'")->fetchColumn();
$projs = (int) $pdo->query("SELECT COUNT(*) FROM projetos WHERE status = 'ativo'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - AMORABI</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body class="admin-page">
<header class="main-header" data-header>
    <div class="container header-container">
        <a class="brand admin-brand" href="index.php">AMORABI Admin</a>
        <button class="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false" data-menu-toggle>
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav class="nav-menu" data-nav>
            <ul>
                <li><a class="active" href="index.php">Dashboard</a></li>
                <li><a href="noticias.php">Notícias</a></li>
                <li><a href="../public/index.php" target="_blank" rel="noopener">Ver site</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container section admin-shell">
    <div class="section-heading">
        <span class="eyebrow">Painel administrativo</span>
        <h1>Painel de Controle</h1>
        <p>Bem-vindo(a), <strong><?php echo htmlspecialchars($_SESSION['admin_nome']); ?></strong>. Você está logado como <em><?php echo htmlspecialchars($_SESSION['admin_nivel']); ?></em>.</p>
    </div>

    <div class="admin-dashboard-grid">
        <article class="admin-stat-card">
            <h3>Mensagens de Contato</h3>
            <strong><?php echo $mensagens; ?></strong>
            <span>Novas aguardando leitura.</span>
        </article>

        <article class="admin-stat-card">
            <h3>Notícias</h3>
            <strong><?php echo $noticias; ?></strong>
            <span><?php echo $publicadas; ?> publicadas no site.</span>
            <a class="btn btn-small" href="noticias.php">Gerenciar notícias</a>
        </article>

        <article class="admin-stat-card">
            <h3>Projetos Sociais</h3>
            <strong><?php echo $projs; ?></strong>
            <span>Projetos ativos cadastrados.</span>
        </article>
    </div>
</main>
<script src="../public/assets/js/main.js"></script>
</body>
</html>
