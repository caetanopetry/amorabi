<?php
include 'includes/header.php';

$emenda_docs = [
    [
        'titulo' => 'Extrato da Proposta',
        'descricao' => 'Documento de consulta da proposta vinculada à emenda parlamentar.',
        'arquivo' => 'assets/docs/transparencia/extrato-proposta.pdf',
        'tipo' => 'PDF',
    ],
    [
        'titulo' => 'Dados do Termo de Fomento',
        'descricao' => 'Informações do termo para acompanhamento público da parceria.',
        'arquivo' => 'assets/docs/transparencia/dados-termo-fomento-mulheres-em-acao.pdf',
        'tipo' => 'PDF',
    ],
    [
        'titulo' => 'Termo de Fomento assinado',
        'descricao' => 'Documento assinado do termo de fomento para consulta pública.',
        'arquivo' => 'assets/docs/transparencia/Amorabi-TermoFomento.pdf',
        'tipo' => 'PDF',
    ],
    [
        'titulo' => 'Publicacao no Diário Oficial',
        'descricao' => 'Publicação no D.O para consulta pública.',
        'arquivo' => 'assets/docs/transparencia/Publicacao.pdf',
        'tipo' => 'PDF',
    ],
];

$amorabi_docs = [
    [
        'titulo' => 'Relatório de Atividades 2025',
        'descricao' => 'Registro das ações, atividades e resultados realizados pela AMORABI.',
        'arquivo' => 'assets/docs/transparencia/relatorio-atividades-2025.pdf',
        'tipo' => 'PDF',
    ],
    [
        'titulo' => 'Estatuto',
        'descricao' => 'Primeira alteração do estatuto social da associação.',
        'arquivo' => 'assets/docs/transparencia/estatuto-primeira-alteracao.pdf',
        'tipo' => 'PDF',
    ],
    [
        'titulo' => 'Ata de Posse',
        'descricao' => 'Ata de posse da diretoria da AMORABI para o período vigente.',
        'arquivo' => 'assets/docs/transparencia/ata-posse-amorabi-2026.pdf',
        'tipo' => 'PDF',
    ],
];

function render_document_card($documento) {
    ?>
    <a class="download-card reveal" href="<?php echo htmlspecialchars($documento['arquivo']); ?>" target="_blank" rel="noopener">
        <span class="download-icon" aria-hidden="true">
            <svg class="svg-icon" viewBox="0 0 24 24">
                <path d="M14 3v4a2 2 0 0 0 2 2h4"/>
                <path d="M5 4.8A1.8 1.8 0 0 1 6.8 3H14l6 6v10.2a1.8 1.8 0 0 1-1.8 1.8H6.8A1.8 1.8 0 0 1 5 19.2V4.8Z"/>
                <path d="M9 15h6M12 12v6M10 16l2 2 2-2"/>
            </svg>
        </span>
        <span class="tag"><?php echo htmlspecialchars($documento['tipo']); ?></span>
        <strong><?php echo htmlspecialchars($documento['titulo']); ?></strong>
        <span><?php echo htmlspecialchars($documento['descricao']); ?></span>
        <em>Abrir documento</em>
    </a>
    <?php
}
?>

<section class="page-hero transparency-hero">
    <div class="container reveal">
        <span class="eyebrow">Transparência</span>
        <h1>Transparência e compromisso com cada recurso recebido.</h1>
        <p>Na AMORABI, tratamos cada apoio com seriedade e respeito, garantindo que os recursos cheguem diretamente às ações que fortalecem a comunidade do Bairro Itinga.</p>
    </div>
</section>

<section class="section section-soft transparency-doc-section">
    <div class="container section-heading centered reveal">
        <span class="eyebrow">Emenda Parlamentar</span>
        <h2>Ministério das Mulheres</h2>
        <p>Emenda parlamentar para projeto de qualificação, saúde e geração de renda para mulheres em situação de vulnerabilidade.</p>
    </div>
    <div class="container download-grid emenda-grid">
        <?php foreach ($emenda_docs as $documento): ?>
            <?php render_document_card($documento); ?>
        <?php endforeach; ?>
    </div>
</section>

<section class="section transparency-doc-section">
    <div class="container section-heading centered reveal">
        <span class="eyebrow">Documentos da AMORABI</span>
        <h2>Relatórios, estatuto e ata de posse</h2>
        <p>Arquivos institucionais para consulta pública sobre organização, gestão e atividades da associação.</p>
    </div>
    <div class="container download-grid">
        <?php foreach ($amorabi_docs as $documento): ?>
            <?php render_document_card($documento); ?>
        <?php endforeach; ?>
    </div>
</section>

<section class="section final-cta transparency-cta">
    <div class="container reveal">
        <span class="eyebrow">Dúvidas sobre documentos?</span>
        <h2>Fale com a AMORABI pelos canais oficiais.</h2>
        <p>A equipe pode orientar sobre documentos, atividades, parcerias e formas de acompanhar a associação.</p>
        <a class="btn" href="contato.php" rel="noopener">Ver Página de Contato</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
