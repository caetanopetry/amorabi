<?php
include 'includes/header.php';

$projetos = fetch_all_safe("SELECT * FROM projetos WHERE status = 'ativo' ORDER BY destaque DESC, id DESC");
$projetos_base = [
    [
        'titulo' => 'Teatro Comunitário e Mostras Culturais',
        'resumo' => 'Curso de teatro, jogos cênicos, expressão corporal, montagens e apresentações que fortalecem a presença cultural da AMORABI no Itinga.',
        'tag' => 'Cultura',
        'imagem_local' => asset_url('img/imagens/722910613_18377040331202339_5437870242268030223_n.jpg'),
    ],
    [
        'titulo' => 'Oficinas de Música, Canto e Ritmo',
        'resumo' => 'Violão e canto, canto coral, conectam corpo, voz, ritmo e convivência comunitária.',
        'tag' => 'Arte e música',
        'imagem_local' => asset_url('img/imagens/721466374_18377040283202339_1097163294585383178_n.jpg'),
    ],
    [
        'titulo' => 'Educação Popular e Inclusão Digital',
        'resumo' => 'Cursinho Popular gratuito para ENEM e vestibulares, café comunitário, apoio com transporte e oficinas de educação financeira digital.',
        'tag' => 'Educação',
        'imagem_local' => asset_url('img/imagens-cursinho/653876447_18000690554906873_2216402177710935293_n.jpg'),
    ],
    [
        'titulo' => 'Projeto Mulheres em Ação',
        'resumo' => 'Projeto social que promove autonomia, saúde e geração de renda, principalmente para mulheres em situação de vulnerabilidade. A iniciativa prevê capacitação por meio de cursos de corte e costura, artesanato, condicionamento físico, yoga, manicure e pedicure, além de palestras sobre autocuidado, nutrição, alimentação e rodas de conversa sobre direitos das mulheres. Em breve estarão abertas as inscrições para os cursos.',
        'tag' => 'Inclusão social',
        'imagem_local' => asset_url('img/imagens-mulheres/image1.jpg'),
    ],
];
$lista_projetos = !empty($projetos) ? $projetos : $projetos_base;

$cursos_cultura = [
    ['Curso de Teatro', 'Expressão corporal, desinibição, jogos teatrais e montagens cênicas apresentadas em festivais locais.', 'theatre'],
    ['Violão e Canto', 'Introdução musical, acordes no violão e técnicas de canto conjugadas.', 'music'],
    ['Canto Coral', 'Canto coletivo, percepção musical, afinação e apresentações comunitárias em grupo.', 'choral'],
];

$cursos_corpo = [
    ['Capoeira', 'Cultura afro-brasileira, esporte, musicalidade e movimentos da capoeira regional e angola.', 'capoeira'],
    ['Yoga', 'Exercícios respiratórios, posturas físicas, flexibilidade, força, equilíbrio, consciência corporal, relaxamento e meditação.', 'yoga'],
    ['Karatê', 'Prática esportiva em parceria com a Escola Suzuki Kyokai, com aulas conduzidas pelo Sensei Alexandre Libardi.', 'karate'],
];

$parcerias_esportivas = [
    [
        'titulo' => 'Karatê',
        'parceiro' => 'Escola Suzuki Kyokai',
        'responsavel' => 'Sensei Alexandre Libardi',
        'dias' => 'Terças-feiras',
        'horario' => '19h30',
        'condicao' => 'Mensalidade social',
        'descricao' => 'Aulas realizadas em parceria com a Escola Suzuki Kyokai, utilizando a estrutura da AMORABI para a prática esportiva comunitária.',
    ],
    [
        'titulo' => 'Yoga',
        'parceiro' => 'Parceria esportiva e de lazer',
        'responsavel' => 'Professora Ana Luísa Silveira',
        'dias' => 'Segundas e quartas-feiras',
        'horario' => '19h às 20h',
        'condicao' => 'Mensalidade social',
        'descricao' => 'As aulas incluem exercícios respiratórios, posturas físicas, práticas de flexibilidade, força, equilíbrio, consciência corporal, relaxamento e meditação.',
    ],
];

$cursos_educacao = [
    ['Cursinho Popular Pré-ENEM', 'Aulas gratuitas aos sábados, das 14h às 18h, com professores voluntários.', 'book'],
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
    <div class="container page-hero-split reveal">
        <div class="page-hero-copy">
            <span class="eyebrow">Projetos</span>
            <h1>Transformação na Prática</h1>
            <p>Conheça as frentes de ação que movimentam a AMORABI diariamente.</p>
        </div>
        <figure class="page-hero-media">
            <img src="<?php echo htmlspecialchars(asset_url('img/imagens/criancasbrincando.jpg')); ?>" loading="eager" decoding="async" alt="Crianças participando de atividade cultural na AMORABI">
        </figure>
    </div>
</section>

<section class="section">
    <div class="container project-grid">
        <?php foreach ($lista_projetos as $index => $p): ?>
            <article class="project-card reveal">
                <?php if (!empty($p['imagem_capa'])): ?>
                    <img src="<?php echo htmlspecialchars(upload_url($p['imagem_capa'])); ?>" loading="lazy" decoding="async" alt="<?php echo htmlspecialchars($p['titulo']); ?>">
                <?php elseif (!empty($p['imagem_local'])): ?>
                    <img src="<?php echo htmlspecialchars($p['imagem_local']); ?>" loading="lazy" decoding="async" alt="<?php echo htmlspecialchars($p['titulo']); ?>">
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
            <img src="<?php echo htmlspecialchars(asset_url('img/imagens/722910613_18377040331202339_5437870242268030223_n.jpg')); ?>" loading="lazy" decoding="async" alt="Apresentação teatral no palco da AMORABI">
        </figure>
        <div class="theatre-copy reveal">
            <span class="eyebrow">Teatro na AMORABI</span>
            <h2>Palco comunitário, memória e formação de plateias.</h2>
            <p>O teatro é uma das marcas do espaço. A AMORABI abriga apresentações, processos formativos, jogos cênicos e montagens que movimentam a zona sul de Joinville.</p>
            <a class="btn btn-outline" href="<?php echo htmlspecialchars(url('contato')); ?>">Consultar oficinas</a>
        </div>
    </div>
    <div class="container theatre-gallery-large reveal">
        <img src="<?php echo htmlspecialchars(asset_url('img/imagens-teatro/unnamed.jpg')); ?>" loading="lazy" decoding="async" alt="Apresentação de dança no palco da AMORABI">
        <img src="<?php echo htmlspecialchars(asset_url('img/imagens-teatro/unnamed%20(1).jpg')); ?>" loading="lazy" decoding="async" alt="Apresentação musical no palco da AMORABI">
        <img src="<?php echo htmlspecialchars(asset_url('img/imagens-teatro/unnamed%20(3).jpg')); ?>" loading="lazy" decoding="async" alt="Grupo teatral em apresentação na AMORABI">
        <img src="<?php echo htmlspecialchars(asset_url('img/imagens-teatro/unnamed%20(4).jpg')); ?>" loading="lazy" decoding="async" alt="Cena teatral apresentada na AMORABI">
    </div>
</section>

<section class="section women-feature-section">
    <div class="container theatre-feature women-feature">
        <figure class="theatre-main-photo reveal">
            <img src="<?php echo htmlspecialchars(asset_url('img/imagens-mulheres/image1.jpg')); ?>" loading="lazy" decoding="async" alt="Participantes do Projeto Mulheres em Ação na AMORABI">
        </figure>
        <div class="theatre-copy reveal">
            <span class="eyebrow">Mulheres em Ação</span>
            <h2>Autonomia, cuidado e geração de renda para mulheres.</h2>
            <p>O Projeto Mulheres em Ação fortalece mulheres em situação de vulnerabilidade por meio de formação, autocuidado, práticas corporais, qualificação profissional e rodas de conversa sobre direitos.</p>
            <a class="btn btn-outline" href="<?php echo htmlspecialchars(url('contato')); ?>">Consultar inscrições</a>
        </div>
    </div>
    <div class="container theatre-gallery-large women-gallery-large reveal">
        <img src="<?php echo htmlspecialchars(asset_url('img/imagens-mulheres/image4.jpg')); ?>" loading="lazy" decoding="async" alt="Atividade do Projeto Mulheres em Ação na AMORABI">
        <img src="<?php echo htmlspecialchars(asset_url('img/imagens-mulheres/image5.jpg')); ?>" loading="lazy" decoding="async" alt="Oficina do Projeto Mulheres em Ação">
        <img src="<?php echo htmlspecialchars(asset_url('img/imagens-mulheres/image6.jpg')); ?>" loading="lazy" decoding="async" alt="Encontro de mulheres na AMORABI">
        <img src="<?php echo htmlspecialchars(asset_url('img/imagens-mulheres/image1.jpg')); ?>" loading="lazy" decoding="async" alt="Registro do Projeto Mulheres em Ação">
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
            <span>Movimento cultural e esportes</span>
            <h3>Corpo, cultura popular e práticas esportivas</h3>
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

    <div class="container sports-partnerships reveal">
        <div class="sports-partnerships-intro">
            <span class="eyebrow">Parcerias esportivas</span>
            <h3>Uso comunitário da estrutura da AMORABI</h3>
            <p>A modalidade de parceria ocorre quando a AMORABI disponibiliza sua estrutura física para atividades esportivas, culturais ou de lazer. As parcerias são avaliadas e aprovadas pela direção eleita da entidade. Quando aplicável, os valores arrecadados ajudam na manutenção do espaço, incluindo limpeza, energia e divulgação.</p>
        </div>

        <div class="sports-partnerships-list">
            <?php foreach ($parcerias_esportivas as $parceria): ?>
                <article class="sports-partnership-card">
                    <div>
                        <span class="tag"><?php echo htmlspecialchars($parceria['condicao']); ?></span>
                        <h4><?php echo htmlspecialchars($parceria['titulo']); ?></h4>
                        <p><?php echo htmlspecialchars($parceria['descricao']); ?></p>
                    </div>
                    <dl>
                        <div>
                            <dt>Parceria</dt>
                            <dd><?php echo htmlspecialchars($parceria['parceiro']); ?></dd>
                        </div>
                        <div>
                            <dt>Responsável</dt>
                            <dd><?php echo htmlspecialchars($parceria['responsavel']); ?></dd>
                        </div>
                        <div>
                            <dt>Dias</dt>
                            <dd><?php echo htmlspecialchars($parceria['dias']); ?></dd>
                        </div>
                        <div>
                            <dt>Horário</dt>
                            <dd><?php echo htmlspecialchars($parceria['horario']); ?></dd>
                        </div>
                    </dl>
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
                <span>Café comunitário</span>
            </div>
            <div class="hero-actions">
                <a class="btn btn-outline" href="https://www.instagram.com/cursinhoamorabi/" target="_blank" rel="noopener">
                    <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="4" y="4" width="16" height="16" rx="5"/>
                        <circle cx="12" cy="12" r="3.5"/>
                        <circle cx="16.8" cy="7.2" r="1"/>
                    </svg>
                    Instagram do Cursinho
                </a>
            </div>
        </div>
        <div class="cursinho-gallery reveal">
            <img class="cursinho-main" src="<?php echo htmlspecialchars(asset_url('img/imagens-cursinho/641226097_18566496004061957_896989782536006659_n.webp')); ?>" alt="Turma do Cursinho Popular na Biblioteca Comunitária">
            <img src="<?php echo htmlspecialchars(asset_url('img/imagens-cursinho/655326194_18069142292288373_846146777405786535_n.webp')); ?>" alt="Turma e voluntários do Cursinho Popular da AMORABI">
            <img src="<?php echo htmlspecialchars(asset_url('img/imagens-cursinho/686484062_18050028932767182_2184298000463721734_n.webp')); ?>" alt="Aula do Cursinho Popular com estudantes na AMORABI">
        </div>
    </div>
</section>

<section class="section final-cta">
    <div class="container reveal">
        <span class="eyebrow">Apoio</span>
        <h2>Projetos comunitários ficam mais fortes com participação.</h2>
        <p>Voluntários, parceiros e moradores ajudam a manter a instituição viva e aberta para novas possibilidades.</p>
        <a class="btn" href="<?php echo htmlspecialchars(url('contato')); ?>#como-ajudar">Quero apoiar</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
