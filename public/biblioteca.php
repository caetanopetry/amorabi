<?php
include 'includes/header.php';
$info = fetch_one_safe("SELECT * FROM biblioteca_info ORDER BY id DESC LIMIT 1");
?>

<section class="page-hero library-hero">
    <div class="container library-hero-grid">
        <div class="reveal">
            <span class="eyebrow">Leitura e convivência</span>
            <h1>Biblioteca Comunitária AMORABI</h1>
            <p>Um espaço vivo de estudos, encontro e incentivo à leitura para todas as idades.</p>
        </div>
        <figure class="library-hero-photo reveal">
            <img src="assets/img/imagens-biblioteca/473889431_17957964371856225_6472203934615054950_n.webp" alt="Criança escolhendo livros nas estantes da Biblioteca Comunitária AMORABI">
        </figure>
    </div>
</section>

<section class="section library-intro-section">
    <div class="container story-layout">
        <article class="content-card reveal">
            <?php if ($info): ?>
                <h2><?php echo htmlspecialchars($info['titulo']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($info['descricao'])); ?></p>
            <?php else: ?>
                <p>Mais do que um depósito de livros, a nossa Biblioteca Comunitária é um espaço vivo de convivência, estudos e incentivo à leitura para todas as idades. Atendemos estudantes das escolas da região, moradores que buscam literatura e participantes do nosso Cursinho Popular.</p>

                <p>Além do empréstimo gratuito de livros, realizamos saraus, contações de histórias e campanhas de arrecadação e redistribuição de acervos literários para fortalecer a educação no Itinga.</p>
            <?php endif; ?>
        </article>

        <aside class="library-mosaic reveal">
            <img src="assets/img/imagens-biblioteca/487409297_17965791533856225_6022575734621084998_n.webp" alt="Crianças na Biblioteca Comunitária diante do mural de educação popular">
            <img src="assets/img/imagens-biblioteca/502703064_17972417975856225_3876418955463655174_n.jpg" alt="Cartaz da Biblioteca Dito">
        </aside>
    </div>
</section>

<section class="section section-soft">
    <div class="container library-activity">
        <figure class="library-activity-photo reveal">
            <img src="assets/img/imagens-biblioteca/540776640_18337210918202339_8936651412990877340_n.jpg" alt="Atividade de leitura com crianças na Biblioteca Comunitária AMORABI">
        </figure>
        <div class="section-heading reveal">
            <span class="eyebrow">Educação popular</span>
            <h2>Leitura também é encontro, escuta e imaginação.</h2>
            <p>A biblioteca acolhe rodas de leitura, contações de histórias, visitas e atividades que aproximam crianças, famílias e comunidade do universo dos livros.</p>
        </div>
    </div>
</section>

<section class="section">
    <div class="container card-grid">
        <article class="feature-card reveal">
            <span class="card-icon">
                <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 6.5c2.8-.9 5.3-.5 8 1.3 2.7-1.8 5.2-2.2 8-1.3v11.8c-2.8-.9-5.3-.5-8 1.3-2.7-1.8-5.2-2.2-8-1.3V6.5Z"/>
                    <path d="M12 7.8v11.8"/>
                </svg>
            </span>
            <h3>Sistema interno</h3>
            <p>A biblioteca utiliza o Biblivre internamente para organização do acervo.</p>
        </article>
        <article class="feature-card reveal">
            <span class="card-icon">
                <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M5 12h14M12 5v14"/>
                    <circle cx="12" cy="12" r="8"/>
                </svg>
            </span>
            <h3>Atendimento presencial</h3>
            <p>Reservas, empréstimos e devoluções seguem sendo realizados diretamente na AMORABI.</p>
        </article>
        <article class="feature-card reveal">
            <span class="card-icon">
                <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 20.5 5.2 13.7a4.1 4.1 0 0 1 5.8-5.8l1 1 1-1a4.1 4.1 0 0 1 5.8 5.8L12 20.5Z"/>
                </svg>
            </span>
            <h3>Doações de livros</h3>
            <p>Aceitamos doações de livros de literatura em bom estado para fortalecer o acervo comunitário.</p>
        </article>
    </div>
</section>

<section class="section library-event-section">
    <div class="container library-event-card reveal">
        <img src="assets/img/imagens-biblioteca/550755790_18339038044202339_2560157884506401018_n.jpg" alt="Crianças participando de atividade com fantoches na biblioteca">
        <img src="assets/img/imagens-biblioteca/559518665_18341264374202339_6885267170326569923_n.jpg" alt="Apresentação de histórias com público na Biblioteca Comunitária">
        <div>
            <span class="eyebrow">Espaço vivo</span>
            <h2>Histórias que circulam, livros que aproximam.</h2>
            <p>A biblioteca permanece como ponto de encontro para leitura, convivência, atividades culturais e formação comunitária.</p>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
