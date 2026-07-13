<?php
include 'includes/header.php';

$whatsapp_url = 'https://api.whatsapp.com/send/?phone=47991987821&text&type=phone_number&app_absent=0';
$instagram_url = 'https://www.instagram.com/amorabi_itinga/?utm_source=ig_embed';
$facebook_url = 'https://www.facebook.com/AssociacaoItinga/?locale=pt_BR';
$grupo_noticias_url = 'https://chat.whatsapp.com/LQCoYJQc4uk07AH4qv7BfE?s=cl&p=i&mlu=0&amv=0';
$maps_url = 'https://www.google.com/maps/search/?api=1&query=Rua%20dos%20Esportistas%20510%20Itinga%20Joinville%20SC';
?>

<section class="page-hero">
    <div class="container reveal">
        <span class="eyebrow">Contato</span>

        <h1>Fale Conosco</h1>

        <p>
            Para dúvidas, visitas, oficinas ou apoio comunitário,
            o WhatsApp é o caminho mais direto.
        </p>

        <div class="hero-actions">
            <a
                class="btn"
                href="<?php echo htmlspecialchars($whatsapp_url); ?>"
                target="_blank"
                rel="noopener noreferrer"
            >
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

            <a
                class="info-box contact-direct"
                href="<?php echo htmlspecialchars($whatsapp_url); ?>"
                target="_blank"
                rel="noopener noreferrer"
            >
                <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20.5 11.8a8.4 8.4 0 0 1-12.4 7.4L3 20.6l1.4-4.9a8.4 8.4 0 1 1 16.1-3.9Z"/>
                    <path d="M8.9 7.9c.2-.4.4-.5.7-.5h.5c.2 0 .4.1.5.4l.7 1.7c.1.3.1.5-.1.7l-.4.5c-.1.2-.2.3-.1.5.4.8 1.5 2.2 2.9 2.8.2.1.4.1.5-.1l.7-.8c.2-.2.4-.3.7-.2l1.6.8c.3.1.4.3.4.6 0 .6-.4 1.5-1.1 1.8-.7.3-2 .3-4.1-.8-2.6-1.3-4.2-3.8-4.5-4.5-.3-.7-.7-1.9 0-2.9Z"/>
                </svg>

                <strong>WhatsApp</strong>
                <span>(47) 99198-7821</span>
                <em>Abrir conversa</em>
            </a>

            <a
                class="info-box"
                href="<?php echo htmlspecialchars($instagram_url); ?>"
                target="_blank"
                rel="noopener noreferrer"
            >
                <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <rect x="4" y="4" width="16" height="16" rx="5"/>
                    <circle cx="12" cy="12" r="3.5"/>
                    <circle cx="16.8" cy="7.2" r="1"/>
                </svg>

                <strong>Instagram</strong>
                <span>@amorabi_itinga</span>
                <em>Abrir perfil</em>
            </a>

            <a
                class="info-box contact-facebook"
                href="<?php echo htmlspecialchars($facebook_url); ?>"
                target="_blank"
                rel="noopener noreferrer"
            >
                <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M14 8.2V6.9c0-.8.5-1.1 1.2-1.1h1.6V3.2C16.5 3.1 15.5 3 14.4 3c-2.3 0-3.9 1.4-3.9 4v1.2H8v3h2.5V21H14v-9.8h2.6l.4-3H14Z"/>
                </svg>

                <strong>Facebook</strong>
                <span>Associação Itinga</span>
                <em>Abrir página</em>
            </a>

        </aside>

        <div
            class="form-card donation-slot reveal"
            id="como-ajudar"
            aria-label="Doação via Pix"
        >
            <div
                class="donation-widget"
                data-pix-donation
                data-endpoint="<?php echo htmlspecialchars(url('pix-doacao')); ?>"
            >
                <span class="eyebrow">Doação via Pix</span>

                <h2>Ajude a fortalecer a AMORABI</h2>

                <p>
                    Escolha um valor, gere o QR Code Pix e envie
                    o comprovante pelo WhatsApp da associação.
                </p>

                <div class="donation-values" aria-label="Valores sugeridos">
                    <button
                        type="button"
                        class="donation-value active"
                        data-amount="10"
                    >
                        R$ 10
                    </button>

                    <button
                        type="button"
                        class="donation-value"
                        data-amount="25"
                    >
                        R$ 25
                    </button>

                    <button
                        type="button"
                        class="donation-value"
                        data-amount="50"
                    >
                        R$ 50
                    </button>

                    <button
                        type="button"
                        class="donation-value"
                        data-amount="100"
                    >
                        R$ 100
                    </button>
                </div>

                <label class="donation-custom">
                    <span>Outro valor</span>

                    <input
                        type="number"
                        min="5"
                        step="0.01"
                        inputmode="decimal"
                        placeholder="Ex.: 35,00"
                        data-pix-amount
                    >
                </label>

                <button
                    type="button"
                    class="btn donation-submit"
                    data-pix-generate
                >
                    Gerar QR Code Pix
                </button>

                <p
                    class="pix-feedback"
                    data-pix-feedback
                    role="status"
                    aria-live="polite"
                ></p>

                <div class="pix-result" data-pix-result hidden>

                    <div class="pix-qr-card">
                        <img
                            src=""
                            alt="QR Code Pix para doação"
                            data-pix-qr
                        >
                    </div>

                    <div class="pix-copy-area">
                        <strong data-pix-amount-label>
                            Pix copia e cola
                        </strong>

                        <textarea
                            readonly
                            rows="5"
                            data-pix-payload
                            aria-label="Código Pix copia e cola"
                        ></textarea>

                        <div class="pix-actions">
                            <button
                                type="button"
                                class="btn btn-outline"
                                data-pix-copy
                            >
                                Copiar código
                            </button>

                            <a
                                class="btn"
                                href="<?php echo htmlspecialchars($whatsapp_url); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                data-pix-whatsapp
                            >
                                Enviar comprovante
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

<section class="section section-soft">
    <div class="container">

        <div class="section-heading reveal">
            <span class="eyebrow">Nossa localização</span>

            <h2>Visite a AMORABI</h2>

            <p>
                Rua dos Esportistas, 510 — Bairro Itinga,
                Joinville — SC.
            </p>

            <div class="hero-actions">
                <a
                    class="btn btn-outline"
                    href="<?php echo htmlspecialchars($maps_url); ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 21s7-5.3 7-11a7 7 0 1 0-14 0c0 5.7 7 11 7 11Z"/>
                        <circle cx="12" cy="10" r="2.4"/>
                    </svg>

                    Ver no mapa
                </a>
            </div>
        </div>

        <div
            class="form-card reveal"
            style="padding: 0; overflow: hidden;"
        >
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d893.5926318164454!2d-48.83230813037305!3d-26.379214397100835!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94deb6e5eab5752b%3A0x478a427c177e35dc!2sAssocia%C3%A7%C3%A3o%20dos%20Moradores%20do%20Bairro%20Itinga!5e0!3m2!1spt-BR!2sbr!4v1783982342020!5m2!1spt-BR!2sbr"
                title="Localização da AMORABI no Google Maps"
                width="100%"
                height="450"
                style="display: block; width: 100%; border: 0;"
                allowfullscreen
                loading="lazy"
                referrerpolicy="strict-origin-when-cross-origin"
            ></iframe>
        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>
