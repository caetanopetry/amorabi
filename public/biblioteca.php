<?php
include 'includes/header.php';

$instagram_biblioteca = 'https://www.instagram.com/biblioteca_dito/';

$biblioteca_atividades = [
    'Empréstimo gratuito de livros',
    'Espaço de convivência e estudo',
    'Saraus, contações de histórias e exibições de filmes',
    'Oficinas e atividades aos sábados com voluntários',
];

$acervo_marcos = [
    ['2021', 'A AMORABI recebeu materiais que estavam na casa de Benedito Clóvis da Silva, incluindo diversas caixas de documentos e outros itens.'],
    ['Registro documental', 'O documento informa aproximadamente 7,59 metros quadrados de materiais recebidos.'],
    ['2023', 'Foi firmada parceria com o curso de História, o Centro Memorial e o Laboratório de História Oral da Univille.'],
    ['Objetivo', 'Organizar e preservar o acervo comunitário, mantendo viva a memória ligada ao Itinga e à atuação comunitária.'],
];
?>

<section class="page-hero library-hero">
    <div class="container library-hero-grid">
        <div class="reveal">
            <span class="eyebrow">Leitura, memória e comunidade</span>
            <h1>Biblioteca Comunitária Lutador Dito</h1>
            <p>Um espaço da AMORABI dedicado ao encontro com os livros, ao estudo e às atividades de incentivo à leitura no Itinga.</p>
            <div class="hero-actions">
                <a class="btn btn-outline" href="<?php echo htmlspecialchars($instagram_biblioteca); ?>" target="_blank" rel="noopener">
                    <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="4" y="4" width="16" height="16" rx="5"/>
                        <circle cx="12" cy="12" r="3.5"/>
                        <circle cx="16.8" cy="7.2" r="1"/>
                    </svg>
                    Instagram da Biblioteca Dito
                </a>
            </div>
        </div>
        <figure class="library-hero-photo reveal">
            <img src="<?php echo htmlspecialchars(asset_url('img/imagens-biblioteca/473889431_17957964371856225_6472203934615054950_n.webp')); ?>" loading="eager" decoding="async" alt="Criança escolhendo livros nas estantes da Biblioteca Comunitária Lutador Dito">
        </figure>
    </div>
</section>

<section class="section library-book-section" aria-labelledby="biblioteca-lutador-dito">
    <div class="container library-split">
        <article class="library-copy reveal">
            <span class="section-kicker">Biblioteca Comunitária</span>
            <h2 id="biblioteca-lutador-dito">Biblioteca Comunitária Lutador Dito</h2>
            <p>A Biblioteca Comunitária nasceu em 2018 e atualmente recebe o nome de Biblioteca Comunitária Lutador Dito, em homenagem a Benedito Clóvis da Silva, morador do bairro falecido em 2019. Mais do que um local para guardar livros, a biblioteca é um espaço de convivência, estudo e incentivo à leitura para todas as idades.</p>
            <p>O espaço atende estudantes das escolas da região, moradores, participantes do Cursinho Popular e outras pessoas da comunidade. Além do empréstimo gratuito de livros, a biblioteca recebe saraus, contações de histórias, exibições de filmes e oficinas. Aos sábados, uma equipe de voluntários realiza diferentes atividades.</p>
        </article>

        <aside class="library-note-list reveal" aria-label="Atividades da biblioteca">
            <?php foreach ($biblioteca_atividades as $atividade): ?>
                <p><?php echo htmlspecialchars($atividade); ?></p>
            <?php endforeach; ?>
        </aside>
    </div>

    <div class="container library-photo-row reveal">
        <img src="<?php echo htmlspecialchars(asset_url('img/imagens-biblioteca/487409297_17965791533856225_6022575734621084998_n.webp')); ?>" loading="lazy" decoding="async" alt="Crianças na Biblioteca Comunitária Lutador Dito diante de um mural de educação popular">
        <img src="<?php echo htmlspecialchars(asset_url('img/imagens-biblioteca/540776640_18337210918202339_8936651412990877340_n.jpg')); ?>" loading="lazy" decoding="async" alt="Atividade de leitura com crianças na Biblioteca Comunitária Lutador Dito">
        <img src="<?php echo htmlspecialchars(asset_url('img/imagens-biblioteca/550755790_18339038044202339_2560157884506401018_n.jpg')); ?>" loading="lazy" decoding="async" alt="Crianças participando de atividade com fantoches na biblioteca">
    </div>
</section>

<section class="section section-soft library-preservation-section" aria-labelledby="acervo-benedito-clovis">
    <div class="container preservation-layout">
        <div class="preservation-intro reveal">
            <span class="section-kicker">Acervo Comunitário</span>
            <h2 id="acervo-benedito-clovis">Acervo Comunitário Benedito Clóvis</h2>
            <p>O Acervo Comunitário Benedito Clóvis reúne materiais recebidos pela AMORABI para organização e preservação documental. Ele se relaciona com a memória da Biblioteca Lutador Dito, mas tem outra finalidade: cuidar de documentos, registros e materiais ligados à história comunitária.</p>
        </div>

        <div class="preservation-person reveal">
            <figure class="dito-portrait">
                <img src="<?php echo htmlspecialchars(asset_url('img/imagens-biblioteca/dito.jpg')); ?>" loading="lazy" decoding="async" alt="Retrato de Benedito Clóvis da Silva, conhecido como Dito">
            </figure>
            <h3>Quem foi Benedito Clóvis da Silva</h3>
            <p>Benedito Clóvis da Silva, conhecido como Dito, nasceu em 1968 e faleceu em 2019. Morador do Itinga, era pintor e artesão. Participou da Pastoral Operária e do Centro de Estudos Bíblicos, atuando em movimentos sociais ligados à justiça, à solidariedade e à construção de uma sociedade mais humana e inclusiva.</p>
        </div>
    </div>

    <div class="container archive-timeline" aria-label="Linha do tempo do acervo comunitário">
        <?php foreach ($acervo_marcos as $marco): ?>
            <article class="archive-step reveal">
                <span><?php echo htmlspecialchars($marco[0]); ?></span>
                <p><?php echo htmlspecialchars($marco[1]); ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section library-community-section">
    <div class="container library-community-card reveal">
        <div>
            <span class="section-kicker">Presença comunitária</span>
            <h2>Leitura para circular, memória para permanecer.</h2>
            <p>A biblioteca segue como espaço de convivência, enquanto o acervo comunitário fortalece o cuidado com documentos e materiais que ajudam a contar a história do bairro e das mobilizações da AMORABI.</p>
        </div>
        <figure>
            <img src="<?php echo htmlspecialchars(asset_url('img/imagens-biblioteca/559518665_18341264374202339_6885267170326569923_n.jpg')); ?>" loading="lazy" decoding="async" alt="Apresentação de histórias com público na Biblioteca Comunitária Lutador Dito">
        </figure>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
