<?php
include 'includes/header.php';

$noticias = fetch_all_safe("SELECT * FROM noticias WHERE status = 'publicado' ORDER BY publicado_em DESC LIMIT 3");
?>

<section class="hero hero-home">
    <div class="container hero-grid">
        <div class="hero-copy reveal">
            <span class="eyebrow">Desde 1981 no coração do Itinga</span>
            <h1>Mais de 40 anos de cultura, educação e <span class="hero-title-mark">luta comunitária.</span></h1>
            <p class="hero-lead">Uma instituição feita por moradores, artistas, educadores e voluntários que mantêm o Itinga em movimento.</p>
            <div class="hero-points" aria-label="Frentes de atuação da AMORABI">
                <span>Cultura viva</span>
                <span>Educação popular</span>
                <span>Direitos sociais</span>
            </div>
            <div class="hero-actions">
                <a class="btn" href="<?php echo htmlspecialchars(url('projetos')); ?>">Conheça nossos projetos</a>
                <a class="btn btn-outline" href="https://api.whatsapp.com/send/?phone=47991987821&text&type=phone_number&app_absent=0" target="_blank" rel="noopener">Chamar no WhatsApp</a>
            </div>
        </div>
        <figure class="hero-photo reveal">
            <img src="assets/img/imagens/amorabi-800x445.jpg"
                 srcset="assets/img/imagens/amorabi-800x445.jpg 800w, assets/img/imagens/amorabi.jpg 1400w"
                 sizes="(max-width: 480px) 90vw, (max-width: 980px) 45vw, 800px"
                 loading="lazy" decoding="async"
                 alt="Atividade cultural em frente ao Centro Comunitário da AMORABI">
            <figcaption>Ponto de Cultura no Centro Comunitário do Itinga</figcaption>
        </figure>
    </div>
</section>

<section class="section section-soft home-about-section">
    <div class="container about-home">

        <div class="about-home-text reveal">
            <span class="eyebrow">Conheça a AMORABI</span>

            <h2>
                Mais de quatro décadas construindo cultura,
                educação e participação comunitária.
            </h2>

            <p>
                Desde 1981, a AMORABI reúne moradores, artistas,
                educadores e voluntários para fortalecer o bairro
                Itinga através da cultura, da educação popular e da
                organização comunitária.
            </p>

            <a class="btn" href="<?php echo htmlspecialchars(url('sobre')); ?>">
                Conheça nossa história
            </a>
        </div>

        <div class="about-home-image reveal">
            <img
                src="assets/img/imagens/amorabi.jpg"
                loading="lazy"
                decoding="async"
                alt="Comunidade reunida na AMORABI">
        </div>

    </div>
</section>

<section class="section photo-section home-gallery-section">
    <div class="container photo-story">
        <div class="section-heading reveal">
            <span class="eyebrow">AMORABI em imagens</span>
            <h2>Casa aberta, palco vivo, bairro em movimento.</h2>
            <p>Registros de apresentações, oficinas e momentos comunitários que contam a história da associação sem precisar de muita explicação.</p>
        </div>
        <div class="photo-mosaic reveal">
            <img class="photo-large" src="assets/img/imagens/721466374_18377040283202339_1097163294585383178_n.jpg" loading="lazy" decoding="async" alt="Apresentação musical na AMORABI">
            <img src="assets/img/imagens/720191862_18377040358202339_2100409563114917839_n.jpg" loading="lazy" decoding="async" alt="Público aplaudindo uma apresentação cultural">
            <img src="assets/img/imagens/720675502_18376733017202339_3039683854683229116_n.jpg" loading="lazy" decoding="async" alt="Turma de karatê em oficina comunitária">
        </div>
    </div>
</section>
<section class="instagram-section">

    <div class="container">

        <div class="section-heading centered reveal">
            <span class="eyebrow">Instagram</span>
            <h2>A vida da AMORABI acontece todos os dias.</h2>

            <p>
                Eventos, oficinas, apresentações, encontros e projetos
                publicados diretamente do nosso Instagram.
            </p>
        </div>

        <div class="instagram-widget reveal">

            <div class="elfsight-app-76379bfd-5bb9-4d7e-965c-cad3baaa8332" data-elfsight-app-lazy></div>

        </div>

    </div>

</section>
<?php if (!empty($noticias)): ?>
<section class="section news-section" id="noticias">
    <div class="container section-heading centered reveal">
        <span class="eyebrow">Notícias</span>
        <h2>Últimas notícias</h2>
        <p>Acompanhe a agenda, os registros das oficinas e os avisos importantes da AMORABI.</p>
    </div>
    <div class="container card-grid">
        <?php foreach ($noticias as $n): ?>
            <?php $link_noticia = !empty($n['slug']) ? url('noticia') . '?slug=' . urlencode($n['slug']) : url('noticias'); ?>
            <a class="news-card news-link reveal" href="<?php echo htmlspecialchars($link_noticia); ?>">
                <?php if (!empty($n['imagem_capa'])): ?>
                    <img src="<?php echo htmlspecialchars(upload_url($n['imagem_capa'])); ?>" alt="<?php echo htmlspecialchars($n['texto_alt_imagem'] ?? $n['titulo']); ?>">
                <?php elseif (!empty($n['imagem_local'])): ?>
                    <img src="<?php echo htmlspecialchars($n['imagem_local']); ?>" alt="<?php echo htmlspecialchars($n['titulo']); ?>">
                <?php else: ?>
                    <div class="news-placeholder" aria-hidden="true">
                        <svg class="svg-icon" viewBox="0 0 24 24">
                            <path d="M4 6.8A2.8 2.8 0 0 1 6.8 4h10.4A2.8 2.8 0 0 1 20 6.8v10.4a2.8 2.8 0 0 1-2.8 2.8H6.8A2.8 2.8 0 0 1 4 17.2V6.8Z"/>
                            <path d="M8 9h8M8 12.5h6M8 16h4"/>
                        </svg>
                    </div>
                <?php endif; ?>
                <div>
                    <span class="tag">AMORABI</span>
                    <h3><?php echo htmlspecialchars($n['titulo']); ?></h3>
                    <p><?php echo htmlspecialchars($n['resumo']); ?></p>
                    <em>Ler notícia</em>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<section class="section section-soft">
    <div class="container section-heading centered reveal">
        <span class="eyebrow">Conecte-se</span>
        <h2>Participe pelos canais oficiais</h2>
        <p>Fale direto com a equipe, acompanhe a agenda e veja de perto o que acontece na AMORABI.</p>
    </div>
    <div class="container action-grid">
        <a class="action-card reveal" href="https://api.whatsapp.com/send/?phone=47991987821&text&type=phone_number&app_absent=0" target="_blank" rel="noopener">
            <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M20.5 11.8a8.4 8.4 0 0 1-12.4 7.4L3 20.6l1.4-4.9a8.4 8.4 0 1 1 16.1-3.9Z"/>
                <path d="M8.9 7.9c.2-.4.4-.5.7-.5h.5c.2 0 .4.1.5.4l.7 1.7c.1.3.1.5-.1.7l-.4.5c-.1.2-.2.3-.1.5.4.8 1.5 2.2 2.9 2.8.2.1.4.1.5-.1l.7-.8c.2-.2.4-.3.7-.2l1.6.8c.3.1.4.3.4.6 0 .6-.4 1.5-1.1 1.8-.7.3-2 .3-4.1-.8-2.6-1.3-4.2-3.8-4.5-4.5-.3-.7-.7-1.9 0-2.9Z"/>
            </svg>
            <strong>WhatsApp</strong>
            <span>Contato rápido para visitas, oficinas e dúvidas.</span>
        </a>
        <a class="action-card reveal" href="https://www.instagram.com/amorabi_itinga/?utm_source=ig_embed" target="_blank" rel="noopener">
            <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                <rect x="4" y="4" width="16" height="16" rx="5"/>
                <circle cx="12" cy="12" r="3.5"/>
                <circle cx="16.8" cy="7.2" r="1"/>
            </svg>
            <strong>Instagram</strong>
            <span>Agenda, registros culturais e avisos da comunidade.</span>
        </a>
        <a class="action-card reveal" href="<?php echo htmlspecialchars(url('projetos')); ?>">
            <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 17.5V6.8A2.8 2.8 0 0 1 6.8 4h10.4A2.8 2.8 0 0 1 20 6.8v10.4a2.8 2.8 0 0 1-2.8 2.8H6.8A2.8 2.8 0 0 1 4 17.5Z"/>
                <path d="M8 12h8M8 8.5h5M8 15.5h6"/>
            </svg>
            <strong>Projetos</strong>
            <span>Conheça as frentes de cultura e educação popular.</span>
        </a>
    </div>
</section>


<?php include 'includes/footer.php'; ?>
