<?php
require_once __DIR__ . '/../../app/helpers/functions.php';
$nome_site = get_site_config('nome_site', 'AMORABI');
$current_page = basename($_SERVER['PHP_SELF']);

function nav_active($page, $current_page) {
    if ($page === 'noticias.php' && $current_page === 'noticia.php') {
        return ' class="active"';
    }

    return $page === $current_page ? ' class="active"' : '';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AMORABI - Associação de Moradores e Amigos do Bairro Itinga, em Joinville-SC. Cultura, educação popular, biblioteca comunitária e mobilização social.">
    <title><?php echo htmlspecialchars($nome_site); ?> - Associação de Moradores e Amigos do Bairro Itinga</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="main-header" data-header>
    <div class="header-container container">
        <a href="index.php" class="brand" aria-label="Página inicial da AMORABI">
            <img src="assets/img/amorabi-logo-transparent.png" alt="AMORABI - Associação de Moradores e Amigos do Bairro Itinga">
        </a>

        <button class="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false" data-menu-toggle>
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="nav-menu" data-nav>
            <ul>
                <li><a href="index.php"<?php echo nav_active('index.php', $current_page); ?>>Início</a></li>
                <li><a href="noticias.php"<?php echo nav_active('noticias.php', $current_page); ?>>Notícias</a></li>
                <li><a href="sobre.php"<?php echo nav_active('sobre.php', $current_page); ?>>Quem Somos</a></li>
                <li><a href="projetos.php"<?php echo nav_active('projetos.php', $current_page); ?>>Projetos</a></li>
                <li><a href="biblioteca.php"<?php echo nav_active('biblioteca.php', $current_page); ?>>Biblioteca</a></li>
                <li><a href="transparencia.php"<?php echo nav_active('transparencia.php', $current_page); ?>>Transparência</a></li>
                <li><a href="contato.php"<?php echo nav_active('contato.php', $current_page); ?>>Contato</a></li>
            </ul>
            <a class="btn btn-small nav-cta" href="contato.php#como-ajudar">Como ajudar</a>
        </nav>
    </div>
</header>
<main>
