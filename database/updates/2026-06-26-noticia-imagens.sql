USE amorabi_site;

CREATE TABLE IF NOT EXISTS noticia_imagens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    noticia_id INT NOT NULL,
    arquivo VARCHAR(255) NOT NULL,
    texto_alt VARCHAR(180),
    ordem TINYINT UNSIGNED DEFAULT 1,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_noticia_imagens_noticia (noticia_id),

    CONSTRAINT fk_noticia_imagens_noticia
        FOREIGN KEY (noticia_id) REFERENCES noticias(id)
        ON DELETE CASCADE
);
