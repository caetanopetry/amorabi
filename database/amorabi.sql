CREATE DATABASE amorabi_site
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE amorabi_site;


CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(180) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    nivel ENUM('admin', 'editor') DEFAULT 'editor',
    ativo TINYINT(1) DEFAULT 1,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    slug VARCHAR(160) NOT NULL UNIQUE,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE noticias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NULL,
    titulo VARCHAR(200) NOT NULL,
    slug VARCHAR(240) NOT NULL UNIQUE,
    resumo TEXT,
    conteudo LONGTEXT NOT NULL,
    imagem_capa VARCHAR(255),
    texto_alt_imagem VARCHAR(180),
    status ENUM('rascunho', 'publicado') DEFAULT 'rascunho',
    destaque TINYINT(1) DEFAULT 0,
    publicado_em DATETIME NULL,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
        ON DELETE SET NULL
);

CREATE TABLE noticia_imagens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    noticia_id INT NOT NULL,
    arquivo VARCHAR(255) NOT NULL,
    texto_alt VARCHAR(180),
    ordem TINYINT UNSIGNED DEFAULT 1,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (noticia_id) REFERENCES noticias(id)
        ON DELETE CASCADE
);


CREATE TABLE projetos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(180) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    resumo TEXT,
    descricao LONGTEXT,
    imagem_capa VARCHAR(255),
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    destaque TINYINT(1) DEFAULT 0,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(180) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    descricao TEXT,
    local_evento VARCHAR(180),
    data_inicio DATETIME NOT NULL,
    data_fim DATETIME NULL,
    imagem VARCHAR(255),
    status ENUM('rascunho', 'publicado', 'cancelado') DEFAULT 'publicado',
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE biblioteca_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(180) NOT NULL,
    descricao LONGTEXT NOT NULL,
    horario_funcionamento VARCHAR(255),
    endereco VARCHAR(255),
    observacao TEXT,
    imagem_capa VARCHAR(255),
    atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE tipos_documentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    slug VARCHAR(160) NOT NULL UNIQUE
);

CREATE TABLE documentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_id INT NULL,
    titulo VARCHAR(180) NOT NULL,
    descricao TEXT,
    arquivo VARCHAR(255) NOT NULL,
    ano YEAR NULL,
    status ENUM('publicado', 'rascunho') DEFAULT 'publicado',
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (tipo_id) REFERENCES tipos_documentos(id)
        ON DELETE SET NULL
);


CREATE TABLE site_config (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chave VARCHAR(100) NOT NULL UNIQUE,
    valor TEXT
);


CREATE TABLE mensagens_contato (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(180) NOT NULL,
    telefone VARCHAR(30),
    assunto VARCHAR(180),
    mensagem TEXT NOT NULL,
    lida TINYINT(1) DEFAULT 0,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE galeria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(160),
    descricao TEXT,
    imagem VARCHAR(255) NOT NULL,
    texto_alt VARCHAR(180),
    status ENUM('publicado', 'rascunho') DEFAULT 'publicado',
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO categorias (nome, slug) VALUES
('Cultura', 'cultura'),
('Educação', 'educacao'),
('Comunidade', 'comunidade'),
('Eventos', 'eventos');

INSERT INTO tipos_documentos (nome, slug) VALUES
('Estatuto', 'estatuto'),
('Prestação de Contas', 'prestacao-de-contas'),
('Relatórios de Atividades', 'relatorios-de-atividades'),
('Documentos Legais', 'documentos-legais'),
('Parcerias', 'parcerias');

INSERT INTO site_config (chave, valor) VALUES
('nome_site', 'AMORABI'),
('instagram', 'https://www.instagram.com/amorabi_itinga/'),
('email_contato', 'contato@amorabi.org.br'),
('telefone', ''),
('endereco', 'Bairro Itinga, Joinville - SC');
