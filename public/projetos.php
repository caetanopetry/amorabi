<?php
include 'includes/header.php';

$projetos = fetch_all_safe("SELECT * FROM projetos WHERE status = 'ativo' ORDER BY destaque DESC, id DESC");
$projetos_base = [
    [
        'titulo' => 'Teatro Comunitário e Mostras Culturais',
        'resumo' => 'Curso de teatro, jogos cênicos, expressão corporal, montagens e apresentações que fortalecem a presença cultural da AMORABI no Itinga.',
        'tag' => 'Cultura',
        'imagem_local' => 'assets/img/imagens/722910613_18377040331202339_5437870242268030223_n.jpg',
    ],
    [
        'titulo' => 'Oficinas de Música, Canto e Ritmo',
        'resumo' => 'Violão e canto, canto coral, danças urbanas e Maracatu Baque Mulher conectam corpo, voz, ritmo e convivência comunitária.',
        'tag' => 'Arte e música',
        'imagem_local' => 'assets/img/imagens/721466374_18377040283202339_1097163294585383178_n.jpg',
    ],
    [
        'titulo' => 'Educação Popular e Inclusão Digital',
        'resumo' => 'Cursinho Popular gratuito para ENEM e vestibulares, ciranda para filhos dos estudantes, café comunitário, apoio com transporte e oficinas de educação financeira digital.',
        'tag' => 'Educação',
        'imagem_local' => 'assets/img/imagens-cursinho/653876447_18000690554906873_2216402177710935293_n.jpg',
    ],
];
$lista_projetos = !empty($projetos) ? $projetos : $projetos_base;

$cursos_cultura = [
    ['Curso de Teatro', 'Expressão corporal, desinibição, jogos teatrais e montagens cênicas apresentadas em festivais locais.', 'theatre'],
    ['Violão e Canto', 'Introdução musical, acordes no violão e técnicas de canto conjugadas.', 'music'],
    ['Canto Coral', 'Canto coletivo, percepção musical, afinação e apresentações comunitárias em grupo.', 'choral'],
    ['Danças Urbanas', 'Ritmo, presença e expressão corporal através de vertentes das danças de rua.', 'dance'],
    ['Maracatu Baque Mulher', 'Corpo, ritmo e resistência coletiva através dos tambores do maracatu, com foco no público feminino.', 'drum'],
];

$cursos_corpo = [
    ['Karatê Comunitário', 'Disciplina, condicionamento físico e técnicas de defesa pessoal.', 'karate'],
    ['Capoeira', 'Cultura afro-brasileira, esporte, musicalidade e movimentos da capoeira regional e angola.', 'capoeira'],
    ['Yoga', 'Meditação, respiração e alongamento para bem-estar e saúde mental dos moradores.', 'yoga'],
];

$cursos_educacao = [
    ['Cursinho Popular Pré-ENEM', 'Aulas gratuitas aos sábados, das 14h às 18h, com professores voluntários.', 'book'],
    ['Ciranda e apoio aos estudantes', 'Acolhimento para filhos pequenos, café comunitário e apoio com passe de ônibus quando necessário.', 'care'],
    ['Educação Financeira Digital', 'Oficinas sobre tecnologias e aplicativos para controle financeiro pessoal e familiar.', 'digital'],
];

function course_icon($type) {
    $icons = [
        'theatre' => '<path d="M7 4c2.6 1.5 7.4 1.5 10 0v5.2c0 4.3-2.1 7.1-5 8.8-2.9-1.7-5-4.5-5-8.8V4Z"/><path d="M9.2 10.2c.7.5 1.4.5 2.1 0M12.7 10.2c.7.5 1.4.5 2.1 0M10 14c1.4 1 2.6 1 4 0"/>',
        'music' => '<path d="M9 18V6l10-2v12"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="16" r="2"/>',
        'choral' => '<path d="M8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM16 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path d="M3.5 19c.7-3.2 2.4-5 4.5-5s3.8 1.8 4.5 5M11.5 19c.7-3.2 2.4-5 4.5-5s3.8 1.8 4.5 5"/>',
        'dance' => '<path d="M12 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/><path d="m5 13 4-3 3 2 3-2 4 3M10 12l-2 8M14 12l2 8"/>',
        'drum' => '<ellipse cx="12" cy="6" rx="6" ry="3"/><path d="M6 6v8c0 1.7 2.7 3 6 3s6-1.3 6-3V6M8 20l8-8M16 20l-8-8"/>',
        'karate' => '<path d="M12 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/><path d="m6 10 4 2 2 8M18 10l-4 2-1 4M9 15H4M15 15h5"/>',
        'capoeira' => '<path d="M12 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/><path d="M7 20c1.8-5.5 5.4-7.5 10-8M6 12c3 2 5 2.2 8 0M15 15l4 5"/>',
        'yoga' => '<path d="M12 5a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/><path d="M5 19c2.7-2.5 4.6-3.7 7-3.7s4.3 1.2 7 3.7M8 13l4-2 4 2M8 19l4-4 4 4"/>',
        'book' => '<path d="M4 6.5c2.8-.9 5.3-.5 8 1.3 2.7-1.8 5.2-2.2 8-1.3v11.8c-2.8-.9-5.3-.5-8 1.3-2.7-1.8-5.2-2.2-8-1.3V6.5Z"/><path d="M12 7.8v11.8"/>',
        'care' => '<path d="M12 20.5 5.2 13.7a4.1 4.1 0 0 1 5.8-5.8l1 1 1-1a4.1 4.1 0 0 1 5.8 5.8L12 20.5Z"/>',
        'digital' => '<rect x="4" y="5" width="16" height="11" rx="2"/><path d="M9 20h6M12 16v4M8 9h3M8 12h8"/>',
    ];

    return '<svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">' . ($icons[$type] ?? $icons['book']) . '</svg>';
}
?>

<section class="page-hero">
    <div class="container reveal">
        <span class="eyebrow">Projetos</span>
        <h1>Transformação na Prática</h1>
        <p>Conheça as frentes de ação que movimentam a AMORABI diariamente.</p>
    </div>
</section>

<section class="section">
    <div class="container project-grid">
        <?php foreach ($lista_projetos as $index => $p): ?>
            <article class="project-card reveal">
                <?php if (!empty($p['imagem_capa'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($p['imagem_capa']); ?>" alt="<?php echo htmlspecialchars($p['titulo']); ?>">
                <?php elseif (!empty($p['imagem_local'])): ?>
                    <img src="<?php echo htmlspecialchars($p['imagem_local']); ?>" alt="<?php echo htmlspecialchars($p['titulo']); ?>">
                <?php else: ?>
                    <div class="project-visual"><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></div>
                <?php endif; ?>
                <div>
                    <span class="tag"><?php echo htmlspecialchars($p['tag'] ?? 'Projeto ativo'); ?></span>
                    <h2><?php echo htmlspecialchars($p['titulo']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($p['resumo'])); ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section theatre-feature-section">
    <div class="container theatre-feature">
        <figure class="theatre-main-photo reveal">
            <img src="assets/img/imagens/722910613_18377040331202339_5437870242268030223_n.jpg" alt="Apresentação teatral no palco da AMORABI">
        </figure>
        <div class="theatre-copy reveal">
            <span class="eyebrow">Teatro na AMORABI</span>
            <h2>Palco comunitário, memória e formação de plateias.</h2>
            <p>O teatro é uma das marcas da casa. A AMORABI abriga apresentações, processos formativos, jogos cênicos e montagens que movimentam a zona sul de Joinville.</p>
            <a class="btn btn-outline" href="contato.php">Consultar oficinas</a>
        </div>
    </div>
    <div class="container theatre-gallery-large reveal">
        <img src="assets/img/imagens-teatro/unnamed.jpg" alt="Apresentação de dança no palco da AMORABI">
        <img src="assets/img/imagens-teatro/unnamed%20(1).jpg" alt="Apresentação musical no palco da AMORABI">
        <img src="assets/img/imagens-teatro/unnamed%20(3).jpg" alt="Grupo teatral em apresentação na AMORABI">
        <img src="assets/img/imagens-teatro/unnamed%20(4).jpg" alt="Cena teatral apresentada na AMORABI">
    </div>
</section>

<section class="section section-soft courses-section">
    <div class="container section-heading centered reveal">
        <span class="eyebrow">Cursos e oficinas</span>
        <h2>Uma agenda comunitária para aprender, criar e se cuidar.</h2>
        <p>As atividades da AMORABI reúnem arte, cultura popular, práticas corporais, educação e inclusão digital.</p>
    </div>

    <div class="container course-group">
        <div class="course-heading reveal">
            <span>Cultura e Arte</span>
            <h3>Expressão, música, palco e ritmo</h3>
        </div>
        <div class="course-grid">
            <?php foreach ($cursos_cultura as $curso): ?>
                <article class="course-card reveal" tabindex="0">
                    <span class="course-icon"><?php echo course_icon($curso[2]); ?></span>
                    <strong><?php echo $curso[0]; ?></strong>
                    <p><?php echo $curso[1]; ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="container course-group">
        <div class="course-heading reveal">
            <span>Esporte, saúde e corpo</span>
            <h3>Disciplina, movimento e bem-estar</h3>
        </div>
        <div class="course-grid compact">
            <?php foreach ($cursos_corpo as $curso): ?>
                <article class="course-card reveal" tabindex="0">
                    <span class="course-icon"><?php echo course_icon($curso[2]); ?></span>
                    <strong><?php echo $curso[0]; ?></strong>
                    <p><?php echo $curso[1]; ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="container course-group">
        <div class="course-heading reveal">
            <span>Educação Popular</span>
            <h3>Formação, permanência e inclusão digital</h3>
        </div>
        <div class="course-grid compact">
            <?php foreach ($cursos_educacao as $curso): ?>
                <article class="course-card reveal" tabindex="0">
                    <span class="course-icon"><?php echo course_icon($curso[2]); ?></span>
                    <strong><?php echo $curso[0]; ?></strong>
                    <p><?php echo $curso[1]; ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section project-photo-band">
    <div class="container cursinho-feature">
        <div class="cursinho-copy reveal">
            <span class="eyebrow">Cursinho Popular</span>
            <h2>Preparação gratuita para o ENEM, com permanência e cuidado.</h2>
            <p>As aulas acontecem aos sábados, das 14h às 18h, com professores voluntários. Além do conteúdo, o projeto oferece café comunitário, ciranda para acolher filhos pequenos dos estudantes e apoio com transporte quando necessário.</p>
            <div class="cursinho-points">
                <span>Aulas aos sábados</span>
                <span>Professores voluntários</span>
                <span>Ciranda de cuidado</span>
                <span>Café comunitário</span>
            </div>
        </div>
        <div class="cursinho-gallery reveal">
            <img class="cursinho-main" src="assets/img/imagens-cursinho/641226097_18566496004061957_896989782536006659_n.webp" alt="Turma do Cursinho Popular na Biblioteca Comunitária">
            <img src="assets/img/imagens-cursinho/655326194_18069142292288373_846146777405786535_n.webp" alt="Turma e voluntários do Cursinho Popular da AMORABI">
            <img src="assets/img/imagens-cursinho/686484062_18050028932767182_2184298000463721734_n.webp" alt="Aula do Cursinho Popular com estudantes na AMORABI">
        </div>
    </div>
</section>

<section class="section project-photo-band">
    <div class="container photo-band-grid">
        <img src="assets/img/imagens/720675502_18376733017202339_3039683854683229116_n.jpg" alt="Turma de karatê comunitário na AMORABI">
        <div class="section-heading reveal">
            <span class="eyebrow">Cultura viva</span>
            <h2>Quando a comunidade ocupa a casa, o projeto vira encontro.</h2>
            <p>As ações da AMORABI aproximam artistas, estudantes, famílias e moradores em torno de formação, convivência e participação.</p>
        </div>
    </div>
</section>

<section class="section final-cta">
    <div class="container reveal">
        <span class="eyebrow">Apoio</span>
        <h2>Projetos comunitários ficam mais fortes com participação.</h2>
        <p>Voluntários, parceiros e moradores ajudam a manter a casa viva e aberta para novas possibilidades.</p>
        <a class="btn" href="contato.php#como-ajudar">Quero apoiar</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
