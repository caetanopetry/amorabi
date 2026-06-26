<?php
include 'includes/header.php';

$noticias = fetch_all_safe("SELECT n.*, c.nome AS categoria_nome
                            FROM noticias n
                            LEFT JOIN categorias c ON c.id = n.categoria_id
                            WHERE n.status = 'publicado'
                            ORDER BY COALESCE(n.publicado_em, n.criado_em) DESC");
?>

<section class="page-hero">
    <div class="container reveal">
        <span class="eyebrow">Notícias</span>
        <h1>Notícias da AMORABI</h1>
        <p>Acompanhe avisos, registros de atividades, oficinas, projetos e mobilizações da comunidade.</p>
    </div>
</section>

<section class="section news-section">
    <div class="container card-grid">
        <?php if (empty($noticias)): ?>
            <div class="empty-state reveal">
                <h2>Nenhuma notícia publicada ainda</h2>
                <p>Enquanto a área de notícias é atualizada, acompanhe avisos, agenda e registros pelos canais oficiais da AMORABI.</p>
                <a class="btn btn-small" href="contato.php">Ver canais oficiais</a>
            </div>
        <?php else: ?>
            <?php foreach ($noticias as $n): ?>
                <a class="news-card news-link reveal" href="noticia.php?slug=<?php echo urlencode($n['slug']); ?>">
                    <?php if (!empty($n['imagem_capa'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($n['imagem_capa']); ?>" alt="<?php echo htmlspecialchars($n['texto_alt_imagem'] ?? $n['titulo']); ?>">
                    <?php else: ?>
                        <div class="news-placeholder" aria-hidden="true">
                            <svg class="svg-icon" viewBox="0 0 24 24">
                                <path d="M4 6.8A2.8 2.8 0 0 1 6.8 4h10.4A2.8 2.8 0 0 1 20 6.8v10.4a2.8 2.8 0 0 1-2.8 2.8H6.8A2.8 2.8 0 0 1 4 17.2V6.8Z"/>
                                <path d="M8 9h8M8 12.5h6M8 16h4"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                    <div>
                        <span class="tag"><?php echo htmlspecialchars($n['categoria_nome'] ?? 'AMORABI'); ?></span>
                        <h2><?php echo htmlspecialchars($n['titulo']); ?></h2>
                        <p><?php echo htmlspecialchars($n['resumo']); ?></p>
                        <em>Ler notícia</em>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
