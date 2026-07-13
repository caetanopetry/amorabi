<?php

require_once __DIR__ . '/app/helpers/functions.php';

$url = trim(parse_url($_GET['url'] ?? '', PHP_URL_PATH) ?? '', '/');

if (str_ends_with($url, '.php')) {
    $url = substr($url, 0, -4);
}

$routes = [
    '' => 'public/index.php',
    'index' => 'public/index.php',
    'sobre' => 'public/sobre.php',
    'projetos' => 'public/projetos.php',
    'biblioteca' => 'public/biblioteca.php',
    'noticias' => 'public/noticias.php',
    'noticia' => 'public/noticia.php',
    'pix-doacao' => 'app/controllers/pix_donation.php',
    'transparencia' => 'public/transparencia.php',
    'contato' => 'public/contato.php',
];

if (str_starts_with($url, 'noticia/')) {
    $_GET['slug'] = trim(substr($url, strlen('noticia/')), '/');
    $url = 'noticia';
}

if (isset($routes[$url])) {
    require __DIR__ . '/' . $routes[$url];
    exit;
}

http_response_code(404);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina nao encontrada - AMORABI</title>
</head>
<body>
    <h1>404</h1>
    <p>Pagina nao encontrada.</p>
    <p><a href="<?php echo htmlspecialchars(url()); ?>">Voltar para a pagina inicial</a></p>
</body>
</html>
