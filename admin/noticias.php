<?php
require_once __DIR__ . '/../app/helpers/functions.php';
check_auth();

if (!$pdo) {
    die('Sem conexão com o banco de dados.');
}

$upload_dir = __DIR__ . '/../public/uploads/noticias';
$upload_url = 'noticias/';
$max_images = 3;
$allowed_types = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp',
];

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0775, true);
}

function unique_news_slug(PDO $pdo, $title, $ignore_id = null) {
    $base = make_slug($title);
    $slug = $base;
    $i = 2;

    while (true) {
        $sql = 'SELECT id FROM noticias WHERE slug = ?';
        $params = [$slug];

        if ($ignore_id) {
            $sql .= ' AND id <> ?';
            $params[] = $ignore_id;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        if (!$stmt->fetch()) {
            return $slug;
        }

        $slug = $base . '-' . $i;
        $i++;
    }
}

function news_images(PDO $pdo, $news_id) {
    $stmt = $pdo->prepare('SELECT * FROM noticia_imagens WHERE noticia_id = ? ORDER BY ordem ASC, id ASC');
    $stmt->execute([$news_id]);
    return $stmt->fetchAll();
}

function sync_cover(PDO $pdo, $news_id) {
    $stmt = $pdo->prepare('SELECT arquivo, texto_alt FROM noticia_imagens WHERE noticia_id = ? ORDER BY ordem ASC, id ASC LIMIT 1');
    $stmt->execute([$news_id]);
    $cover = $stmt->fetch();

    $upd = $pdo->prepare('UPDATE noticias SET imagem_capa = ?, texto_alt_imagem = ? WHERE id = ?');
    $upd->execute([$cover['arquivo'] ?? null, $cover['texto_alt'] ?? null, $news_id]);
}

function upload_news_images(PDO $pdo, $news_id, $files, $upload_dir, $upload_url, $allowed_types, $max_images, $alt_text) {
    $stmt_count = $pdo->prepare('SELECT COUNT(*) FROM noticia_imagens WHERE noticia_id = ?');
    $stmt_count->execute([$news_id]);
    $existing = (int) $stmt_count->fetchColumn();

    if (empty($files['name'][0])) {
        return;
    }

    $selected = 0;
    foreach ($files['name'] as $name) {
        if ($name !== '') {
            $selected++;
        }
    }

    if ($existing + $selected > $max_images) {
        throw new RuntimeException('Cada notícia pode ter no máximo 3 fotos.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $order_stmt = $pdo->prepare('SELECT COALESCE(MAX(ordem), 0) FROM noticia_imagens WHERE noticia_id = ?');
    $order_stmt->execute([$news_id]);
    $order = (int) $order_stmt->fetchColumn();

    foreach ($files['name'] as $index => $original_name) {
        if ($original_name === '' || $files['error'][$index] === UPLOAD_ERR_NO_FILE) {
            continue;
        }

        if ($files['error'][$index] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Não foi possível enviar uma das imagens.');
        }

        $tmp = $files['tmp_name'][$index];
        $mime = $finfo->file($tmp);

        if (!isset($allowed_types[$mime])) {
            throw new RuntimeException('Envie apenas imagens JPG, PNG ou WEBP.');
        }

        if ($files['size'][$index] > 5 * 1024 * 1024) {
            throw new RuntimeException('Cada imagem deve ter no máximo 5MB.');
        }

        $filename = date('YmdHis') . '-' . bin2hex(random_bytes(5)) . '.' . $allowed_types[$mime];
        $destination = $upload_dir . DIRECTORY_SEPARATOR . $filename;

        if (!move_uploaded_file($tmp, $destination)) {
            throw new RuntimeException('Falha ao salvar uma das imagens.');
        }

        $order++;
        $insert = $pdo->prepare('INSERT INTO noticia_imagens (noticia_id, arquivo, texto_alt, ordem) VALUES (?, ?, ?, ?)');
        $insert->execute([$news_id, $upload_url . $filename, $alt_text, $order]);
    }

    sync_cover($pdo, $news_id);
}

$feedback = null;
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? 'salvar';

    try {
        if (!verify_csrf_token($_POST['_csrf'] ?? null)) {
            throw new RuntimeException('Sessao expirada. Recarregue a pagina e tente novamente.');
        }

        if ($acao === 'excluir') {
            $id = (int) ($_POST['id'] ?? 0);
            $imagens = news_images($pdo, $id);

            $stmt = $pdo->prepare('DELETE FROM noticias WHERE id = ?');
            $stmt->execute([$id]);

            foreach ($imagens as $img) {
                $path = __DIR__ . '/../public/uploads/' . $img['arquivo'];
                if (is_file($path)) {
                    unlink($path);
                }
            }

            $feedback = 'Notícia excluída com sucesso.';
        } else {
            $id = (int) ($_POST['id'] ?? 0);
            $titulo = sanitize($_POST['titulo'] ?? '');
            $resumo = sanitize($_POST['resumo'] ?? '');
            $conteudo = trim($_POST['conteudo'] ?? '');
            $status = in_array($_POST['status'] ?? '', ['rascunho', 'publicado'], true) ? $_POST['status'] : 'rascunho';
            $categoria_id = !empty($_POST['categoria_id']) ? (int) $_POST['categoria_id'] : null;
            $destaque = !empty($_POST['destaque']) ? 1 : 0;
            $texto_alt = sanitize($_POST['texto_alt_imagem'] ?? $titulo);

            if ($titulo === '' || $conteudo === '') {
                throw new RuntimeException('Preencha título e conteúdo.');
            }

            if ($resumo === '') {
                $resumo = excerpt_text($conteudo, 180);
            }

            $publicado_em = $status === 'publicado' ? date('Y-m-d H:i:s') : null;

            if ($id > 0) {
                $slug = unique_news_slug($pdo, $titulo, $id);
                $current = fetch_one_safe('SELECT publicado_em FROM noticias WHERE id = ?', [$id]);
                if ($status === 'publicado' && !empty($current['publicado_em'])) {
                    $publicado_em = $current['publicado_em'];
                }

                $stmt = $pdo->prepare('UPDATE noticias SET categoria_id = ?, titulo = ?, slug = ?, resumo = ?, conteudo = ?, texto_alt_imagem = ?, status = ?, destaque = ?, publicado_em = ? WHERE id = ?');
                $stmt->execute([$categoria_id, $titulo, $slug, $resumo, $conteudo, $texto_alt, $status, $destaque, $publicado_em, $id]);
            } else {
                $slug = unique_news_slug($pdo, $titulo);
                $stmt = $pdo->prepare('INSERT INTO noticias (categoria_id, titulo, slug, resumo, conteudo, texto_alt_imagem, status, destaque, publicado_em) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute([$categoria_id, $titulo, $slug, $resumo, $conteudo, $texto_alt, $status, $destaque, $publicado_em]);
                $id = (int) $pdo->lastInsertId();
            }

            if (!empty($_POST['remover_imagens'])) {
                foreach ($_POST['remover_imagens'] as $image_id) {
                    $img = fetch_one_safe('SELECT * FROM noticia_imagens WHERE id = ? AND noticia_id = ?', [(int) $image_id, $id]);
                    if ($img) {
                        $path = __DIR__ . '/../public/uploads/' . $img['arquivo'];
                        if (is_file($path)) {
                            unlink($path);
                        }
                        $del = $pdo->prepare('DELETE FROM noticia_imagens WHERE id = ?');
                        $del->execute([$img['id']]);
                    }
                }
                sync_cover($pdo, $id);
            }

            upload_news_images($pdo, $id, $_FILES['imagens'] ?? [], $upload_dir, $upload_url, $allowed_types, $max_images, $texto_alt);
            sync_cover($pdo, $id);

            $feedback = 'Notícia salva com sucesso.';
            $_GET['editar'] = $id;
        }
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}

$categorias = fetch_all_safe('SELECT * FROM categorias ORDER BY nome ASC');
$edit_id = (int) ($_GET['editar'] ?? 0);
$edit = $edit_id ? fetch_one_safe('SELECT * FROM noticias WHERE id = ?', [$edit_id]) : null;
$edit_images = $edit ? news_images($pdo, $edit['id']) : [];
$noticias = fetch_all_safe("SELECT n.*, c.nome AS categoria_nome, COUNT(ni.id) AS total_imagens
                            FROM noticias n
                            LEFT JOIN categorias c ON c.id = n.categoria_id
                            LEFT JOIN noticia_imagens ni ON ni.noticia_id = n.id
                            GROUP BY n.id
                            ORDER BY n.criado_em DESC");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notícias - Admin AMORABI</title>
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
                <li><a href="index.php">Dashboard</a></li>
                <li><a class="active" href="noticias.php">Notícias</a></li>
                <li><a href="<?php echo htmlspecialchars(url()); ?>" target="_blank" rel="noopener">Ver site</a></li>
                <li>
                    <form class="nav-logout-form" method="POST" action="logout.php">
                        <?php echo csrf_field(); ?>
                        <button type="submit">Sair</button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</header>

<main class="section">
    <div class="container admin-shell">
        <div class="section-heading">
            <span class="eyebrow">Painel administrativo</span>
            <h1><?php echo $edit ? 'Editar notícia' : 'Criar notícia'; ?></h1>
            <p>Publique notícias da AMORABI com título, resumo, conteúdo e até 3 fotos.</p>
        </div>

        <?php if ($feedback): ?>
            <p class="alert success"><?php echo htmlspecialchars($feedback); ?></p>
        <?php endif; ?>
        <?php if ($erro): ?>
            <p class="alert error"><?php echo htmlspecialchars($erro); ?></p>
        <?php endif; ?>

        <div class="admin-layout">
            <form class="form-card admin-form" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="acao" value="salvar">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($edit['id'] ?? ''); ?>">

                <label>
                    <span>Título *</span>
                    <input type="text" name="titulo" required value="<?php echo htmlspecialchars($edit['titulo'] ?? ''); ?>">
                </label>

                <label>
                    <span>Categoria</span>
                    <select name="categoria_id">
                        <option value="">Sem categoria</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo (($edit['categoria_id'] ?? '') == $cat['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label>
                    <span>Resumo</span>
                    <textarea name="resumo" rows="3" placeholder="Resumo curto para aparecer nos cards."><?php echo htmlspecialchars($edit['resumo'] ?? ''); ?></textarea>
                </label>

                <label>
                    <span>Conteúdo *</span>
                    <textarea name="conteudo" rows="10" required placeholder="Escreva a notícia completa."><?php echo htmlspecialchars($edit['conteudo'] ?? ''); ?></textarea>
                </label>

                <label>
                    <span>Texto alternativo das imagens</span>
                    <input type="text" name="texto_alt_imagem" value="<?php echo htmlspecialchars($edit['texto_alt_imagem'] ?? ''); ?>" placeholder="Descrição curta das fotos">
                </label>

                <label>
                    <span>Adicionar imagens (máx. 3 no total)</span>
                    <input type="file" name="imagens[]" accept="image/jpeg,image/png,image/webp" multiple>
                </label>

                <?php if (!empty($edit_images)): ?>
                    <div class="admin-image-list">
                        <?php foreach ($edit_images as $img): ?>
                            <label>
                                <img src="../public/uploads/<?php echo htmlspecialchars($img['arquivo']); ?>" loading="lazy" decoding="async" alt="">
                                <span><input type="checkbox" name="remover_imagens[]" value="<?php echo $img['id']; ?>"> Remover</span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="admin-form-row">
                    <label>
                        <span>Status</span>
                        <select name="status">
                            <option value="rascunho" <?php echo (($edit['status'] ?? '') === 'rascunho') ? 'selected' : ''; ?>>Rascunho</option>
                            <option value="publicado" <?php echo (($edit['status'] ?? '') === 'publicado') ? 'selected' : ''; ?>>Publicado</option>
                        </select>
                    </label>
                    <label class="admin-check">
                        <input type="checkbox" name="destaque" value="1" <?php echo !empty($edit['destaque']) ? 'checked' : ''; ?>>
                        <span>Destacar</span>
                    </label>
                </div>

                <div class="admin-actions">
                    <button class="btn" type="submit">Salvar notícia</button>
                    <?php if ($edit): ?>
                        <a class="btn btn-outline" href="noticias.php">Nova notícia</a>
                    <?php endif; ?>
                </div>
            </form>

            <aside class="admin-list">
                <h2>Notícias cadastradas</h2>
                <?php if (empty($noticias)): ?>
                    <p class="empty-state">Nenhuma notícia cadastrada ainda.</p>
                <?php else: ?>
                    <?php foreach ($noticias as $noticia): ?>
                        <article class="admin-list-item">
                            <div>
                                <span class="tag"><?php echo htmlspecialchars($noticia['status']); ?></span>
                                <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                                <p><?php echo htmlspecialchars($noticia['categoria_nome'] ?? 'Sem categoria'); ?> · <?php echo (int) $noticia['total_imagens']; ?> foto(s)</p>
                            </div>
                            <div class="admin-item-actions">
                                <a class="btn btn-small btn-outline" href="noticias.php?editar=<?php echo $noticia['id']; ?>">Editar</a>
                                <?php if ($noticia['status'] === 'publicado'): ?>
                                    <a class="btn btn-small btn-outline" href="<?php echo htmlspecialchars(url('noticia') . '?slug=' . urlencode($noticia['slug'])); ?>" target="_blank" rel="noopener">Ver</a>
                                <?php endif; ?>
                                <form method="POST" onsubmit="return confirm('Excluir esta notícia?');">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="acao" value="excluir">
                                    <input type="hidden" name="id" value="<?php echo $noticia['id']; ?>">
                                    <button class="btn btn-small" type="submit">Excluir</button>
                                </form>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</main>
<script src="../public/assets/js/main.js"></script>
</body>
</html>
