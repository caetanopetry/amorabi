<?php
include 'includes/header.php';

$slug = $_GET['slug'] ?? '';
$noticia = fetch_one_safe("SELECT n.*, c.nome AS categoria_nome
                           FROM noticias n
                           LEFT JOIN categorias c ON c.id = n.categoria_id
                           WHERE n.slug = ? AND n.status = 'publicado'
                           LIMIT 1", [$slug]);

if (!$noticia) {
    http_response_code(404);
}

$imagens = $noticia ? fetch_all_safe('SELECT * FROM noticia_imagens WHERE noticia_id = ? ORDER BY ordem ASC, id ASC', [$noticia['id']]) : [];
?>

<?php if (!$noticia): ?>
    <section class="page-hero">
        <div class="container reveal">
            <span class="eyebrow">Notícias</span>
            <h1>Notícia não encontrada</h1>
            <p>O conteúdo pode ter sido removido ou ainda não está publicado.</p>
            <div class="hero-actions">
                <a class="btn" href="<?php echo htmlspecialchars(url('noticias')); ?>">Ver notícias</a>
            </div>
        </div>
    </section>
<?php else: ?>
    <section class="page-hero news-detail-hero">
        <div class="container reveal">
            <span class="eyebrow"><?php echo htmlspecialchars($noticia['categoria_nome'] ?? 'AMORABI'); ?></span>
            <h1><?php echo htmlspecialchars($noticia['titulo']); ?></h1>
            <?php if (!empty($noticia['resumo'])): ?>
                <p><?php echo htmlspecialchars($noticia['resumo']); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <section class="section">
        <div class="container news-detail-layout">
            <article class="content-card news-detail-content reveal">
                <?php if (!empty($noticia['imagem_capa'])): ?>
                    <img class="news-detail-cover" src="<?php echo htmlspecialchars(upload_url($noticia['imagem_capa'])); ?>" alt="<?php echo htmlspecialchars($noticia['texto_alt_imagem'] ?? $noticia['titulo']); ?>">
                <?php endif; ?>

                <div class="news-meta">
                    <span><?php echo !empty($noticia['publicado_em']) ? date('d/m/Y', strtotime($noticia['publicado_em'])) : date('d/m/Y', strtotime($noticia['criado_em'])); ?></span>
                    <span><?php echo htmlspecialchars($noticia['categoria_nome'] ?? 'AMORABI'); ?></span>
                </div>

                <div class="rich-text">
                    <?php echo nl2br(htmlspecialchars($noticia['conteudo'])); ?>
                </div>
            </article>

            <?php if (!empty($imagens)): ?>
                <aside class="news-gallery reveal">
                    <h2>Fotos da notícia</h2>
                    <div>
                        <?php foreach ($imagens as $img): ?>
                            <a href="<?php echo htmlspecialchars(upload_url($img['arquivo'])); ?>" target="_blank" rel="noopener">
                                <img src="<?php echo htmlspecialchars(upload_url($img['arquivo'])); ?>" alt="<?php echo htmlspecialchars($img['texto_alt'] ?? $noticia['titulo']); ?>">
                            </a>
                        <?php endforeach; ?>
                    </div>
                </aside>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
