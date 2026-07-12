<?php
include 'includes/header.php';

$sucesso = null;
$erro = null;
$whatsapp_url = 'https://api.whatsapp.com/send/?phone=47991987821&text&type=phone_number&app_absent=0';
$instagram_url = 'https://www.instagram.com/amorabi_itinga/?utm_source=ig_embed';
$facebook_url = 'https://www.facebook.com/AssociacaoItinga/?locale=pt_BR';
$grupo_noticias_url = 'https://chat.whatsapp.com/LQCoYJQc4uk07AH4qv7BfE?s=cl&p=i&mlu=0&amv=0';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = sanitize($_POST['nome'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $telefone = sanitize($_POST['telefone'] ?? '');
    $assunto = sanitize($_POST['assunto'] ?? '');
    $mensagem = sanitize($_POST['mensagem'] ?? '');

    if (empty($nome) || empty($email) || empty($mensagem)) {
        $erro = "Por favor, preencha os campos obrigatórios: nome, e-mail e mensagem.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Informe um e-mail válido para que possamos retornar.";
    } elseif (!$pdo) {
        $erro = "No momento não foi possível registrar sua mensagem pelo site. Use o WhatsApp para falar direto com a equipe.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO mensagens_contato (nome, email, telefone, assunto, mensagem) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nome, $email, $telefone, $assunto, $mensagem]);
            $sucesso = "Mensagem recebida com sucesso! Retornaremos o contato em breve.";
        } catch (Exception $e) {
            $erro = "Não foi possível enviar sua mensagem agora. Use o WhatsApp para falar direto com a equipe.";
        }
    }
}
?>

<section class="page-hero">
    <div class="container reveal">
        <span class="eyebrow">Contato</span>
        <h1>Fale Conosco</h1>
        <p>Para dúvidas rápidas, visitas, oficinas ou apoio comunitário, o WhatsApp é o caminho mais direto.</p>
        <div class="hero-actions">
            <a class="btn" href="<?php echo $whatsapp_url; ?>" target="_blank" rel="noopener">
                <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20.5 11.8a8.4 8.4 0 0 1-12.4 7.4L3 20.6l1.4-4.9a8.4 8.4 0 1 1 16.1-3.9Z"/>
                    <path d="M8.9 7.9c.2-.4.4-.5.7-.5h.5c.2 0 .4.1.5.4l.7 1.7c.1.3.1.5-.1.7l-.4.5c-.1.2-.2.3-.1.5.4.8 1.5 2.2 2.9 2.8.2.1.4.1.5-.1l.7-.8c.2-.2.4-.3.7-.2l1.6.8c.3.1.4.3.4.6 0 .6-.4 1.5-1.1 1.8-.7.3-2 .3-4.1-.8-2.6-1.3-4.2-3.8-4.5-4.5-.3-.7-.7-1.9 0-2.9Z"/>
                </svg>
                Chamar no WhatsApp
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container contact-layout">
        <aside class="contact-info reveal">
            <a class="info-box contact-direct" href="<?php echo $whatsapp_url; ?>" target="_blank" rel="noopener">
                <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20.5 11.8a8.4 8.4 0 0 1-12.4 7.4L3 20.6l1.4-4.9a8.4 8.4 0 1 1 16.1-3.9Z"/>
                    <path d="M8.9 7.9c.2-.4.4-.5.7-.5h.5c.2 0 .4.1.5.4l.7 1.7c.1.3.1.5-.1.7l-.4.5c-.1.2-.2.3-.1.5.4.8 1.5 2.2 2.9 2.8.2.1.4.1.5-.1l.7-.8c.2-.2.4-.3.7-.2l1.6.8c.3.1.4.3.4.6 0 .6-.4 1.5-1.1 1.8-.7.3-2 .3-4.1-.8-2.6-1.3-4.2-3.8-4.5-4.5-.3-.7-.7-1.9 0-2.9Z"/>
                </svg>
                <strong>WhatsApp</strong>
                <span>(47) 99198-7821</span>
                <em>Abrir conversa</em>
            </a>

                        <a class="info-box contact-news" href="<?php echo $grupo_noticias_url; ?>" target="_blank" rel="noopener">
                <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 18.5V6.8A2.8 2.8 0 0 1 6.8 4h10.4A2.8 2.8 0 0 1 20 6.8v11.4a1.8 1.8 0 0 1-2.6 1.6L14.8 18H6.8A2.8 2.8 0 0 1 4 15.2v3.3Z"/>
                    <path d="M8 8.5h8M8 12h6M8 15.5h4"/>
                </svg>
                <strong>Grupo de notícias</strong>
                <span>Entre no grupo oficial para receber avisos, agenda e novidades da AMORABI.</span>
                <em>Entrar no grupo</em>
            </a>
            <a class="info-box" href="https://www.google.com/maps/search/?api=1&query=Rua%20dos%20Esportistas%20510%20Itinga%20Joinville%20SC" target="_blank" rel="noopener">
                <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 21s7-5.3 7-11a7 7 0 1 0-14 0c0 5.7 7 11 7 11Z"/>
                    <circle cx="12" cy="10" r="2.4"/>
                </svg>
                <strong>Endereço</strong>
                <span>Rua dos Esportistas, 510 - Bairro Itinga, Joinville - SC, CEP 89233-700</span>
                <em>Ver no mapa</em>
            </a>
            <a class="info-box" href="<?php echo $instagram_url; ?>" target="_blank" rel="noopener">
                <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <rect x="4" y="4" width="16" height="16" rx="5"/>
                    <circle cx="12" cy="12" r="3.5"/>
                    <circle cx="16.8" cy="7.2" r="1"/>
                </svg>
                <strong>Instagram</strong>
                <span>@amorabi_itinga</span>
                <em>Abrir perfil</em>
            </a>
            <a class="info-box" href="<?php echo $facebook_url; ?>" target="_blank" rel="noopener">
                <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M14 8.2V6.9c0-.8.5-1.1 1.2-1.1h1.6V3.2C16.5 3.1 15.5 3 14.4 3c-2.3 0-3.9 1.4-3.9 4v1.2H8v3h2.5V21H14v-9.8h2.6l.4-3H14Z"/>
                </svg>
                <strong>Facebook</strong>
                <span>Associação Itinga</span>
                <em>Abrir página</em>
            </a>
        </aside>

        <div class="form-card reveal">
            <?php if ($sucesso): ?>
                <p class="alert success"><?php echo $sucesso; ?></p>
            <?php endif; ?>
            <?php if ($erro): ?>
                <p class="alert error"><?php echo $erro; ?></p>
            <?php endif; ?>

            <form method="POST" class="contact-form" data-contact-form novalidate>
                <label>
                    <span>Nome completo *</span>
                    <input type="text" name="nome" required value="<?php echo htmlspecialchars($_POST['nome'] ?? ''); ?>">
                </label>
                <label>
                    <span>E-mail *</span>
                    <input type="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </label>
                <label>
                    <span>Telefone / WhatsApp</span>
                    <input type="tel" name="telefone" value="<?php echo htmlspecialchars($_POST['telefone'] ?? ''); ?>">
                </label>
                <label>
                    <span>Assunto</span>
                    <input type="text" name="assunto" value="<?php echo htmlspecialchars($_POST['assunto'] ?? ''); ?>">
                </label>
                <label>
                    <span>Mensagem *</span>
                    <textarea name="mensagem" rows="6" required><?php echo htmlspecialchars($_POST['mensagem'] ?? ''); ?></textarea>
                </label>
                <p class="form-feedback" data-form-feedback></p>
                <button type="submit" class="btn">Enviar mensagem</button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
