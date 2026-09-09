<?php
require_once __DIR__ . '/../../app/helpers/functions.php';
send_security_headers();

$nome_site = get_site_config('nome_site', 'AMORABI');
$current_route = current_route();
$body_page = $current_route === '' ? 'index' : preg_replace('/[^a-z0-9-]+/', '-', strtolower($current_route));

function nav_active($route, $current_route) {
    if ($route === 'noticias' && str_starts_with($current_route, 'noticia')) {
        return ' class="active"';
    }

    return $route === $current_route || ($route === '' && in_array($current_route, ['', 'index'], true)) ? ' class="active"' : '';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AMORABI - Associação de Moradores e Amigos do Bairro Itinga, em Joinville-SC. Cultura, educação popular, biblioteca comunitária e mobilização social.">
    <title><?php echo htmlspecialchars($nome_site); ?> - Associação de Moradores e Amigos do Bairro Itinga</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,500&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(asset_url('css/style.css')); ?>">

    <?php
    $css_page = $current_route === '' ? 'index' : basename($current_route);

    if (str_starts_with($current_route, 'noticia')) {
        $css_page = 'noticia';
    }

    $css_file = __DIR__ . "/../assets/css/{$css_page}.css";

    if (file_exists($css_file)) {
        echo '<link rel="stylesheet" href="' . htmlspecialchars(asset_url('css/' . $css_page . '.css')) . '">';
    }
    ?>
</head>
<body class="page-<?php echo htmlspecialchars($body_page); ?>">
<header class="main-header" data-header>
    <div class="header-container container">
        <a href="<?php echo htmlspecialchars(url()); ?>" class="brand" aria-label="Página inicial da AMORABI">
            <img src="<?php echo htmlspecialchars(asset_url('img/amorabi-logo-transparent.png')); ?>" alt="AMORABI - Associação de Moradores e Amigos do Bairro Itinga">
        </a>

        <button class="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false" data-menu-toggle>
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="nav-menu" data-nav>
            <ul>
                <li><a href="<?php echo htmlspecialchars(url()); ?>"<?php echo nav_active('', $current_route); ?>>Início</a></li>
                <li><a href="<?php echo htmlspecialchars(url('noticias')); ?>"<?php echo nav_active('noticias', $current_route); ?>>Notícias</a></li>
                <li><a href="<?php echo htmlspecialchars(url('sobre')); ?>"<?php echo nav_active('sobre', $current_route); ?>>Quem Somos</a></li>
                <li><a href="<?php echo htmlspecialchars(url('projetos')); ?>"<?php echo nav_active('projetos', $current_route); ?>>Projetos</a></li>
                <li><a href="<?php echo htmlspecialchars(url('biblioteca')); ?>"<?php echo nav_active('biblioteca', $current_route); ?>>Biblioteca</a></li>
                <li><a href="<?php echo htmlspecialchars(url('transparencia')); ?>"<?php echo nav_active('transparencia', $current_route); ?>>Transparência</a></li>
                <li><a href="<?php echo htmlspecialchars(url('contato')); ?>"<?php echo nav_active('contato', $current_route); ?>>Contato</a></li>
            </ul>
            <a class="btn btn-small nav-cta" href="<?php echo htmlspecialchars(url('contato')); ?>#como-ajudar">Como ajudar</a>
            <button class="theme-toggle" type="button" aria-label="Ativar modo escuro" aria-pressed="false" data-theme-toggle>
                <span class="theme-toggle-track" aria-hidden="true">
                    <span class="theme-toggle-thumb">
                        <svg class="theme-icon theme-icon-sun" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="4"/>
                            <path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>
                        </svg>
                        <svg class="theme-icon theme-icon-moon" viewBox="0 0 24 24">
                            <path d="M20 14.5A7.8 7.8 0 0 1 9.5 4 8.8 8.8 0 1 0 20 14.5Z"/>
                        </svg>
                    </span>
                </span>
            </button>
        </nav>
    </div>
</header>
<main>
