<?php
include 'includes/header.php';

function about_icon($type) {
    $icons = [
        'megaphone' => '<path d="M4 13V9l9-4v12l-9-4Z"/><path d="M13 9h2a3 3 0 0 1 0 6h-2M7 14l1 5h3l-1.4-4.2"/>',
        'book' => '<path d="M4 6.5c2.8-.9 5.3-.5 8 1.3 2.7-1.8 5.2-2.2 8-1.3v11.8c-2.8-.9-5.3-.5-8 1.3-2.7-1.8-5.2-2.2-8-1.3V6.5Z"/><path d="M12 7.8v11.8"/>',
        'children' => '<path d="M8 10a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5ZM16 10a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/><path d="M3.5 19c.7-3.5 2.2-5.4 4.5-5.4s3.8 1.9 4.5 5.4M11.5 19c.7-3.5 2.2-5.4 4.5-5.4s3.8 1.9 4.5 5.4"/>',
        'home' => '<path d="M4 11.5 12 5l8 6.5"/><path d="M6.5 10.5V20h11v-9.5"/><path d="M10 20v-5h4v5"/>',
        'theatre' => '<path d="M7 4c2.6 1.5 7.4 1.5 10 0v5.2c0 4.3-2.1 7.1-5 8.8-2.9-1.7-5-4.5-5-8.8V4Z"/><path d="M9.2 10.2c.7.5 1.4.5 2.1 0M12.7 10.2c.7.5 1.4.5 2.1 0M10 14c1.4 1 2.6 1 4 0"/>',
        'users' => '<path d="M8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM16 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path d="M3.5 19c.7-3.2 2.4-5 4.5-5s3.8 1.8 4.5 5M11.5 19c.7-3.2 2.4-5 4.5-5s3.8 1.8 4.5 5"/>',
        'medal' => '<path d="m8 3 4 6 4-6"/><path d="M9.5 3h5"/><circle cx="12" cy="15" r="5"/><path d="m10.5 15 1 1 2.2-2.3"/>',
        'trophy' => '<path d="M8 4h8v4.5a4 4 0 0 1-8 0V4Z"/><path d="M8 6H5.5a2.5 2.5 0 0 0 2.7 3M16 6h2.5a2.5 2.5 0 0 1-2.7 3M12 12.5V17M9 21h6M10 17h4"/>',
        'clock' => '<circle cx="12" cy="12" r="8"/><path d="M12 7.5V12l3 2"/>',
    ];

    return '<svg class="about-icon" viewBox="0 0 24 24" aria-hidden="true">' . ($icons[$type] ?? $icons['users']) . '</svg>';
}
?>

<section class="page-hero about-hero">
    <div class="container page-hero-split reveal">
        <div class="page-hero-copy">
            <span class="eyebrow">Quem Somos</span>
            <h1>Uma história feita no Itinga, com o Itinga.</h1>
            <p>Desde 17 de maio de 1981, a AMORABI reúne moradores, voluntários e parceiros em torno de uma ideia simples: cuidar do bairro, abrir espaço para a cultura e defender direitos da comunidade.</p>
        </div>
        <figure class="page-hero-media">
            <img src="<?php echo htmlspecialchars(asset_url('img/imagens/474951850_638212055532616_874613838701138383_n.jpg')); ?>" loading="eager" decoding="async" alt="Grupo em frente ao Centro Comunitário da AMORABI no Itinga">
        </figure>
    </div>
</section>

<section class="section about-opening-section">
    <div class="container about-opening">
        <article class="about-opening-copy reveal">
            <span class="eyebrow">Fundada em 17 de maio de 1981</span>
            <h2>Uma associação feita por moradores do Itinga.</h2>
            <p>A AMORABI nasceu da organização de quem vivia o bairro todos os dias e sabia o que precisava melhorar. A partir dessa presença, a associação passou a reivindicar infraestrutura, educação, cultura, assistência social, esporte, lazer e cidadania.</p>
            <p>Com o tempo, o Centro Comunitário se tornou ponto de encontro: lugar de reunião, apresentações, oficinas, projetos e conversas sobre o futuro do Itinga.</p>
            <div class="about-opening-points" aria-label="Frentes de atuação da AMORABI">
                <span>Organização comunitária</span>
                <span>Cultura e educação</span>
                <span>Defesa de direitos</span>
            </div>
        </article>

        <figure class="about-opening-photo reveal">
            <img src="<?php echo htmlspecialchars(asset_url('img/imagens/amorabi.jpg')); ?>" loading="lazy" decoding="async" alt="Fachada do Centro Comunitário da AMORABI no Itinga">
            <figcaption>Centro Comunitário do Itinga, sede da AMORABI.</figcaption>
        </figure>
    </div>
</section>

<section class="section section-soft about-achievements-section">
    <div class="container about-achievements">
        <div class="section-heading reveal">
            <span class="eyebrow"><?php echo about_icon('home'); ?>Principais realizações</span>
            <h2>O que a comunidade construiu junto.</h2>
            <p>A história da AMORABI aparece em conquistas concretas: espaços abertos, serviços mantidos, projetos culturais e presença em decisões públicas.</p>
        </div>

        <div class="achievements-list reveal">
            <article>
                <span>01</span>
                <strong>Reivindicações para o bairro</strong>
                <p>Pedidos, cobranças e diálogo com órgãos públicos para melhorias necessárias no Itinga.</p>
            </article>
            <article>
                <span>02</span>
                <strong>Educação infantil por duas décadas</strong>
                <p>Manutenção do Centro Comunitário de Educação Infantil Vovó Juliana de Carvalho durante 20 anos.</p>
            </article>
            <article>
                <span>03</span>
                <strong>Espaço cedido para o CEI</strong>
                <p>Parte do prédio hoje atende gratuitamente cerca de 130 crianças pelo CEI Professora Juliana de Carvalho.</p>
            </article>
            <article>
                <span>04</span>
                <strong>Centro Comunitário do Itinga</strong>
                <p>Construção do espaço inaugurado em março de 1999, usado para encontros, cursos, reuniões e eventos.</p>
            </article>
            <article>
                <span>05</span>
                <strong>Cultura presente desde 1999</strong>
                <p>Apresentações, oficinas e cursos culturais ajudaram a manter o Centro Comunitário vivo e aberto.</p>
            </article>
            <article>
                <span>06</span>
                <strong>Participação em conselhos</strong>
                <p>Presença em espaços de decisão da cidade, levando demandas e defendendo direitos da comunidade.</p>
            </article>
        </div>
    </div>
</section>

<section class="section statutory-section">
    <div class="container statutory-card reveal">
        <span class="eyebrow"><?php echo about_icon('book'); ?>Finalidade estatutária</span>
        <h2>Educação, assistência social, cultura, lazer e esportes.</h2>
        <p>A AMORABI — Associação dos Moradores e Amigos do Bairro Itinga é uma entidade sem fins lucrativos, pessoa jurídica de direito privado, que tem como finalidade congregar os moradores, estimular o espírito de solidariedade e comunidade e prestar serviços de assistência social nas áreas de educação, assistência social, cultura, lazer e esportes.</p>
        <p>A associação busca despertar a população para o exercício da cidadania, melhorar a qualidade de vida e se rege pelo estatuto social e pela legislação aplicável vigente.</p>
    </div>
</section>

<section class="section recognition-section">
    <div class="container section-heading reveal">
        <span class="eyebrow"><?php echo about_icon('medal'); ?>Reconhecimentos</span>
        <h2>Marcos públicos da atuação cultural.</h2>
    </div>

    <div class="container recognition-list">
        <article class="recognition-item reveal">
            <strong>2009</strong>
            <p>Reconhecimento como Ponto de Cultura pelo Ministério da Cultura e pela Fundação Catarinense de Cultura.</p>
        </article>
        <article class="recognition-item reveal">
            <strong>2011</strong>
            <p>Medalha de Mérito Cultural Cruz e Souza, concedida pelo Conselho Estadual de Cultura.</p>
        </article>
        <article class="recognition-item reveal">
            <strong>2021</strong>
            <p>Prêmio Joinville Faz Bem, categoria Cultura, com 73% do voto popular, promovido pela NSC TV durante as comemorações dos 170 anos de Joinville.</p>
        </article>
    </div>
</section>

<section class="section timeline-section">
    <div class="container section-heading reveal">
        <span class="eyebrow"><?php echo about_icon('clock'); ?>Linha do tempo</span>
        <h2>Da fundação à atuação atual</h2>
    </div>

    <div class="container about-timeline">
        <article class="about-timeline-item reveal">
            <strong>1981</strong>
            <p>Fundação da AMORABI em 17 de maio.</p>
        </article>
        <article class="about-timeline-item reveal">
            <strong>Anos 1980</strong>
            <p>Mobilizações por infraestrutura, educação e saúde.</p>
        </article>
        <article class="about-timeline-item reveal">
            <strong>Anos 1990</strong>
            <p>Início das atividades do CCEI Vovó Juliana de Carvalho e construção do Centro Comunitário.</p>
        </article>
        <article class="about-timeline-item reveal">
            <strong>Anos 2000</strong>
            <p>A cultura se consolida como uma das principais áreas de atuação da entidade.</p>
        </article>
        <article class="about-timeline-item reveal">
            <strong>Hoje</strong>
            <p>Atuação em cultura, educação, esporte, lazer e mobilização comunitária.</p>
        </article>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
