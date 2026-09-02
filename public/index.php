<?php
include 'includes/header.php';

$noticias = fetch_all_safe("SELECT * FROM noticias WHERE status = 'publicado' ORDER BY publicado_em DESC LIMIT 3");
?>

<section class="hero hero-home">
    <div class="hero-grid">
        <div class="hero-copy-panel">
        <div class="hero-copy reveal">
            <span class="eyebrow">Desde 1981 no coração do Itinga</span>
            <h1>Há mais de 40 anos, o Itinga se reúne aqui para <span class="hero-title-mark">aprender, criar e transformar.</span></h1>
            <p class="hero-lead">Cultura, educação e mobilização comunitária feitas por quem vive o bairro.</p>
            <div class="hero-actions">
                <a class="btn" href="<?php echo htmlspecialchars(url('projetos')); ?>">Conheça nossos projetos</a>
                <a class="btn btn-outline" href="<?php echo htmlspecialchars(url('contato')); ?>">Entre em contato</a>
            </div>
        </div>
        </div>
        <figure class="hero-photo reveal">
            <img src="<?php echo htmlspecialchars(asset_url('img/imagens/amorabi-800x445.jpg')); ?>"
                 srcset="<?php echo htmlspecialchars(asset_url('img/imagens/amorabi-800x445.jpg')); ?> 800w, <?php echo htmlspecialchars(asset_url('img/imagens/amorabi.jpg')); ?> 1400w"
                 sizes="(max-width: 480px) 90vw, (max-width: 980px) 45vw, 800px"
                 width="800" height="445" fetchpriority="high" decoding="async"
                 alt="Atividade cultural em frente ao Centro Comunitário do Itinga">
        </figure>
    </div>
</section>

<section class="section section-soft home-about-section">
    <div class="container home-about-teaser reveal">
        <div class="home-about-year" aria-label="AMORABI fundada em 1981">
            <strong>1981</strong>
            <span>no Itinga</span>
        </div>
        <div class="home-about-copy">
            <span class="eyebrow">Conheça a AMORABI</span>
            <p>Desde 1981, moradores do Itinga transformam participação comunitária em cultura, educação e oportunidades.</p>
        </div>
        <a class="btn home-about-link" href="<?php echo htmlspecialchars(url('sobre')); ?>">Descubra nossa história <span aria-hidden="true">→</span></a>
    </div>
</section>

<section class="section photo-section home-gallery-section">
    <div class="container photo-story">
        <div class="section-heading reveal">
            <span class="eyebrow">AMORABI em imagens</span>
            <h2>Teatro, música, esporte e educação — tudo na mesma casa.</h2>
            <p>Fotos reais das oficinas, aulas e apresentações realizadas pela AMORABI com a comunidade.</p>
        </div>

        <div class="photo-carousel reveal" data-carousel role="region" aria-roledescription="carrossel" aria-label="Galeria de fotos da AMORABI" tabindex="0">
            <div class="carousel-viewport">
                <ul class="carousel-track" data-carousel-track>
                    <li class="carousel-slide">
                        <img src="<?php echo htmlspecialchars(asset_url('img/imagens/721466374_18377040283202339_1097163294585383178_n.jpg')); ?>" loading="lazy" decoding="async" alt="Apresentação musical na AMORABI">
                        <span class="carousel-caption">Apresentação musical no palco da AMORABI</span>
                    </li>
                    <li class="carousel-slide">
                        <img src="<?php echo htmlspecialchars(asset_url('img/imagens/720191862_18377040358202339_2100409563114917839_n.jpg')); ?>" loading="lazy" decoding="async" alt="Público aplaudindo uma apresentação cultural">
                        <span class="carousel-caption">Plateia lotada em noite de apresentação cultural</span>
                    </li>
                    <li class="carousel-slide">
                        <img src="<?php echo htmlspecialchars(asset_url('img/imagens/720675502_18376733017202339_3039683854683229116_n.jpg')); ?>" loading="lazy" decoding="async" alt="Turma de karatê em oficina comunitária">
                        <span class="carousel-caption">Turma do Karatê Comunitário em treino</span>
                    </li>
                    <li class="carousel-slide">
                        <img src="<?php echo htmlspecialchars(asset_url('img/imagens-teatro/oficina-teatro-criancas.jpg')); ?>" loading="lazy" decoding="async" alt="Crianças em oficina de teatro na AMORABI">
                        <span class="carousel-caption">Oficina de teatro com crianças na AMORABI</span>
                    </li>
                    <li class="carousel-slide">
                        <img src="<?php echo htmlspecialchars(asset_url('img/imagens-cursinho/641226097_18566496004061957_896989782536006659_n.webp')); ?>" loading="lazy" decoding="async" alt="Aula do Cursinho Popular Pré-ENEM">
                        <span class="carousel-caption">Aula do Cursinho Popular Pré-ENEM</span>
                    </li>
                    <li class="carousel-slide">
                        <img src="<?php echo htmlspecialchars(asset_url('img/imagens-biblioteca/540776640_18337210918202339_8936651412990877340_n.jpg')); ?>" loading="lazy" decoding="async" alt="Momento na Biblioteca Comunitária">
                        <span class="carousel-caption">Tarde de leitura na Biblioteca Comunitária</span>
                    </li>
                    <li class="carousel-slide">
                        <img src="<?php echo htmlspecialchars(asset_url('img/imagens-teatro/teatro-quadra2.jpg')); ?>" loading="lazy" decoding="async" alt="Momento na Biblioteca Comunitária">
                            <span class="carousel-caption">Tarde de teatro na quadra esportiva</span>
                    </li>
                    <li class="carousel-slide">
                        <img src="<?php echo htmlspecialchars(asset_url('img/imagens-teatro/teatro-mascara-cenica.jpg')); ?>" loading="lazy" decoding="async" alt="Momento na Biblioteca Comunitária">
                            <span class="carousel-caption"> Apresentação de teatro infantil</span>
                    </li>

                    <li class="carousel-slide">
                        <img src="<?php echo htmlspecialchars(asset_url('img/imagens-teatro/teatro-bonecos.jpg')); ?>" loading="lazy" decoding="async" alt="Momento na Biblioteca Comunitária">
                            <span class="carousel-caption"> Teatro de bonecos e animação</span>
                    </li>
                </ul>
            </div>
            <button class="carousel-arrow carousel-prev" type="button" data-carousel-prev aria-label="Foto anterior">&#8249;</button>
            <button class="carousel-arrow carousel-next" type="button" data-carousel-next aria-label="Próxima foto">&#8250;</button>
            <div class="carousel-dots" data-carousel-dots aria-label="Selecionar foto"></div>
        </div>
    </div>
</section>

<section class="instagram-section">
    <div class="container">
        <div class="section-heading centered reveal">
            <span class="eyebrow">Instagram</span>
            <h2>Acompanhe a agenda no Instagram</h2>
            <p>@amorabi_itinga publica avisos de oficinas, fotos de apresentações e datas importantes quase todos os dias.</p>
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
            <?php $link_noticia = !empty($n['slug']) ? url('noticia/' . rawurlencode($n['slug'])) : url('noticias'); ?>
            <a class="news-card news-link reveal" href="<?php echo htmlspecialchars($link_noticia); ?>">
                <?php if (!empty($n['imagem_capa'])): ?>
                    <img src="<?php echo htmlspecialchars(upload_url($n['imagem_capa'])); ?>" loading="lazy" decoding="async" alt="<?php echo htmlspecialchars($n['texto_alt_imagem'] ?? $n['titulo']); ?>">
                <?php elseif (!empty($n['imagem_local'])): ?>
                    <img src="<?php echo htmlspecialchars($n['imagem_local']); ?>" loading="lazy" decoding="async" alt="<?php echo htmlspecialchars($n['titulo']); ?>">
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
    <div class="container home-news-more reveal">
        <a class="btn btn-outline" href="<?php echo htmlspecialchars(url('noticias')); ?>">Ver todas as notícias</a>
    </div>
</section>
<?php endif; ?>

<section class="section section-soft home-courses-section">
    <div class="container section-heading centered reveal">
        <span class="eyebrow">Projetos</span>
        <h2>Tem oficina pra todo mundo, e é gratuito</h2>
        <p>Cultura, esporte e educação popular, sempre abertos aos moradores do Itinga.</p>
    </div>
    <div class="container home-courses-tags reveal">
        <span>Teatro</span>
        <span>Violão e canto</span>
        <span>Canto coral</span>
        <span>Karatê comunitário</span>
        <span>Capoeira</span>
        <span>Yoga</span>
        <span>Cursinho Pré-ENEM</span>
        <span>Educação financeira digital</span>
    </div>
    <div class="container home-courses-cta reveal">
        <a class="btn" href="<?php echo htmlspecialchars(url('projetos')); ?>">Ver todos os projetos</a>
    </div>
</section>

<section class="section section-soft home-contact-section">
    <div class="container home-contact-cta reveal">
        <div class="home-contact-copy">
            <span class="eyebrow">Fale com a AMORABI</span>
            <h2>Quer participar, visitar ou tirar uma dúvida?</h2>
            <p>Converse diretamente com a equipe ou consulte todos os canais e o endereço da associação.</p>
        </div>
        <div class="home-contact-actions">
            <a class="btn home-contact-main-btn" href="<?php echo htmlspecialchars(url('contato')); ?>">Ver página de contato <span aria-hidden="true">→</span></a>
            <a class="btn btn-outline home-whatsapp-btn" href="https://api.whatsapp.com/send/?phone=47991987821&text&type=phone_number&app_absent=0" target="_blank" rel="noopener">
                <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20.5 11.8a8.4 8.4 0 0 1-12.4 7.4L3 20.6l1.4-4.9a8.4 8.4 0 1 1 16.1-3.9Z"/>
                    <path d="M8.9 7.9c.2-.4.4-.5.7-.5h.5c.2 0 .4.1.5.4l.7 1.7c.1.3.1.5-.1.7l-.4.5c-.1.2-.2.3-.1.5.4.8 1.5 2.2 2.9 2.8.2.1.4.1.5-.1l.7-.8c.2-.2.4-.3.7-.2l1.6.8c.3.1.4.3.4.6 0 .6-.4 1.5-1.1 1.8-.7.3-2 .3-4.1-.8-2.6-1.3-4.2-3.8-4.5-4.5-.3-.7-.7-1.9 0-2.9Z"/>
                </svg>
                Chamar no WhatsApp
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
