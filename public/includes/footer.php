</main>
<footer class="main-footer">
    <div class="container footer-grid">
        <div class="footer-about">
            <img src="<?php echo htmlspecialchars(asset_url('img/amorabi-logo-transparent.png')); ?>" alt="AMORABI" class="footer-logo">
            <p>Associacao de Moradores e Amigos do Bairro Itinga. Cultura, educacao popular e mobilizacao comunitaria em Joinville-SC.</p>
        </div>

        <div>
            <h2>Endereco</h2>
            <p>Rua dos Esportistas, 510<br>Bairro Itinga, Joinville - SC<br>CEP 89233-700</p>
        </div>

        <div>
            <h2>Links rapidos</h2>
            <ul class="footer-links">
                <li><a href="<?php echo htmlspecialchars(url('sobre')); ?>">Quem Somos</a></li>
                <li><a href="<?php echo htmlspecialchars(url('noticias')); ?>">Noticias</a></li>
                <li><a href="<?php echo htmlspecialchars(url('projetos')); ?>">Projetos</a></li>
                <li><a href="<?php echo htmlspecialchars(url('biblioteca')); ?>">Biblioteca</a></li>
                <li><a href="<?php echo htmlspecialchars(url('transparencia')); ?>">Transparencia</a></li>
                <li><a href="<?php echo htmlspecialchars(url('contato')); ?>">Contato</a></li>
            </ul>
        </div>

        <div>
            <h2>Canais</h2>
            <div class="social-links">
                <a href="https://api.whatsapp.com/send/?phone=47991987821&text&type=phone_number&app_absent=0" target="_blank" rel="noopener">
                    <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M20.5 11.8a8.4 8.4 0 0 1-12.4 7.4L3 20.6l1.4-4.9a8.4 8.4 0 1 1 16.1-3.9Z"/>
                        <path d="M8.9 7.9c.2-.4.4-.5.7-.5h.5c.2 0 .4.1.5.4l.7 1.7c.1.3.1.5-.1.7l-.4.5c-.1.2-.2.3-.1.5.4.8 1.5 2.2 2.9 2.8.2.1.4.1.5-.1l.7-.8c.2-.2.4-.3.7-.2l1.6.8c.3.1.4.3.4.6 0 .6-.4 1.5-1.1 1.8-.7.3-2 .3-4.1-.8-2.6-1.3-4.2-3.8-4.5-4.5-.3-.7-.7-1.9 0-2.9Z"/>
                    </svg>
                    WhatsApp
                </a>
                <a href="https://www.instagram.com/amorabi_itinga/?utm_source=ig_embed" target="_blank" rel="noopener">
                    <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="4" y="4" width="16" height="16" rx="5"/>
                        <circle cx="12" cy="12" r="3.5"/>
                        <circle cx="16.8" cy="7.2" r="1"/>
                    </svg>
                    Instagram
                </a>
                <a href="https://www.facebook.com/AssociacaoItinga/?locale=pt_BR" target="_blank" rel="noopener">
                    <svg class="svg-icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M14 8.2V6.9c0-.8.5-1.1 1.2-1.1h1.6V3.2C16.5 3.1 15.5 3 14.4 3c-2.3 0-3.9 1.4-3.9 4v1.2H8v3h2.5V21H14v-9.8h2.6l.4-3H14Z"/>
                    </svg>
                    Facebook
                </a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars(get_site_config('nome_site', 'AMORABI')); ?>. Todos os direitos reservados.</p>
    </div>
</footer>
<script src="<?php echo htmlspecialchars(asset_url('js/main.js')); ?>"></script>
<script src="https://elfsightcdn.com/platform.js" async></script>
</body>
</html>
