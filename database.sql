-- TODO: meios de contato/redes, reacoes, avatar, listas, posts, denuncias, solicitações seguidores

DROP DATABASE IF EXISTS watched;
CREATE DATABASE watched;
use watched;

CREATE TABLE tbUsuarios(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    username VARCHAR(20) NOT NULL,
    sobre VARCHAR(240),
    email VARCHAR(75) NOT NULL,   
    senha CHAR(32) NOT NULL,
    privado BOOLEAN DEFAULT FALSE,
    assinante BOOLEAN DEFAULT FALSE,
    ultimoAcesso DATETIME,
    dataCadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tbAdministradores(
    usuario INT,
    status BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (usuario) REFERENCES tbUsuarios(id)
);

CREATE TABLE tbUsuarioRedes(
    usuario INT,
    rede INT,
    idUsuarioRede INT
);

CREATE TABLE tbGeneros(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL
);


CREATE TABLE tbPlataformas(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    icone TEXT NOT NULL,
    url TEXT NOT NULL
);    

CREATE TABLE tbReacoes(
    id INT PRIMARY KEY AUTO_INCREMENT,
    icone VARCHAR(50),
    descricao VARCHAR(50)
);

CREATE TABLE tbResenhas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    filme INT NOT NULL,
    usuario INT NOT NULL,
    titulo VARCHAR(100) DEFAULT "",
    descricao TEXT NOT NULL,
    nota DECIMAL(2, 1) DEFAULT 0.0,
    dataHora DATETIME DEFAULT CURRENT_TIMESTAMP,
    reacao INT,
    FOREIGN KEY (usuario) REFERENCES tbUsuarios (id),
    FOREIGN KEY (reacao) REFERENCES tbReacoes (id)
);

/*Chat: */
CREATE TABLE tbChats(
    id INT PRIMARY KEY AUTO_INCREMENT,
    tipo CHAR(1) NOT NULL, -- I: individual | G: grupo,
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    descricao VARCHAR(1000)
);

CREATE TABLE tbParticipantesChat(
    chat INT NOT NULL,
    participante INT NOT NULL,
    adm BOOLEAN DEFAULT FALSE,
    entrada DATETIME DEFAULT CURRENT_TIMESTAMP,
    saida DATETIME,
    expulso BOOLEAN
);

CREATE TABLE tbMensagens(
    chat INT NOT NULL,
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    texto VARCHAR(600) NOT NULL
);



/* TABELAS AUXILIARES (N-N) */

CREATE TABLE tbFilmesUsuario(
    filme INT NOT NULL,
    usuario INT NOT NULL,
    assistido BOOLEAN DEFAULT FALSE,
    curtido BOOLEAN DEFAULT FALSE,
    salvo BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (usuario) REFERENCES tbUsuarios (id)
);

CREATE TABLE tbUsuariosSeguidores (
    usuario INT NOT NULL,
    seguidor INT NOT NULL,
    FOREIGN KEY(usuario) REFERENCES tbUsuarios(id),
    FOREIGN KEY(seguidor) REFERENCES tbUsuarios(id)
);

INSERT INTO tbPlataformas (nome, icone, url)
VALUES 
    ("Amazon Prime", "/assets/img/icons/amazon-icon.svg", "https://www.primevideo.com/"),
    ("Apple TV+", "/assets/img/icons/apple-icon.svg", "https://www.apple.com/br/apple-tv-plus/"),
    ("Disney +", "/assets/img/icons/disney-icon.svg", "https://www.disneyplus.com/"),
    ("HBO Go", "/assets/img/icons/hbo-icon.svg", "https://www.hbomax.com/"),
    ("Netflix", "/assets/img/icons/netflix-icon.svg", "https://www.netflix.com"),
    ("Youtube", "/assets/img/icons/yt-icon.svg", "https://www.youtube.com/feed/storefront"),
    ("Star +", "/assets/img/icons/star-plus-icon.svg", "https://www.starplus.com");


-- Registro dos gêneros
INSERT INTO tbGeneros(nome) 
VALUES 
    ("Ação"), ("Comédia"), ("Drama"), ("Documentário"), ("Infantil"), ("Fantasia"), ("Terror"), ("Romance"), ("Ficção científica"), ("Suspense"), ("Animação"), ("Musical"), ("Aventura");


-- Relação entre generos e filmes
INSERT INTO tbGenerosFilmes(filme, genero)
VALUES
    -- Sociedade dos poetas mortos
    (1, 3),

    -- Antes de Amanhecer
    (2, 3), (2, 8),

    -- Viva
    (3, 5), (3, 11), (3, 12), (3, 13),
    
    -- Uma noite de crime
    (4, 3), (4, 7), (4, 10),

    -- Whiplash
    (5, 3), (5, 12),

    -- O sexto sentido
    (6, 7), (6, 10), (6, 3),

    -- A outra face
    (7, 1), (7, 9), (7, 13), (7, 10),

    -- O show de truman
    (8, 2), (8, 3), (8, 9), 

    -- Jogos mortais
    (9, 7), (9, 10),

    -- Truque de mestre
    (10, 1), (10, 10),

    -- Truque de mestre 2
    (11, 1), (11, 10), (11, 13),

    -- Velozes e Furiosos 5: Operação Rio
    (12, 1), (12, 10),

    -- Pantera Negra
    (13, 1), (13, 9), (13, 13),

    -- A Grande Muralha
    (14, 1), (14, 13), (14, 10),
    
    -- Piratas do Caribe: A Maldição do Pérola Negra
    (15, 1), (15, 13), (15, 2),

    -- Soul
    (16, 3), (16, 5), (16, 11), (16, 12),

    -- A nova onda do imperador
    (17, 2), (17, 5), (17, 13), (17, 11), (17, 12),

    -- As vantagens de ser invisível
    (18, 3), (18, 8),

    -- O castelo animado
    (19, 11), (19, 3), (19, 6), (19, 8), (19, 13),

    -- O homem de palha
    (20, 7), (20, 6), (20, 10),

    -- Oppenheimer
    (21, 3), (21, 10),

    -- Barbie
    (22, 2), (22, 6),

    -- Matrix
    (23, 1), (23, 9),

    -- Era uma Vez no Oeste
    (24, 1), (24, 3), (24, 13),

    -- O Senhor dos Anéis: A Sociedade do Anel
    (25, 1), (25, 6), (25, 13), 

    -- Os Infiltrados
    (26, 3), (26, 10),

    -- Gladiador
    (27, 1), (27, 3),

    -- O Poderoso Chefão 
    (28, 3),

    -- Forrest Gump
    (29, 2), (29, 3),

    -- Vingadores: Ultimato
    (30, 1), (30, 6), (30, 13), 

    -- Pulp Fiction: Tempo de Violência
    (31, 2), (31, 3), (31, 10),

    -- O Resgate do Soldado Ryan
    (32, 1), (32, 3), (32, 13),

    -- Interestelar
    (33, 3), (33, 9), (33, 13),

    -- O Silêncio dos Inocentes
    (34, 3), (34, 7), (34, 10), 

    -- Cidade de Deus
    (35, 3), (35, 10),

    -- A Origem
    (36, 1), (36, 9), (36, 13),

    -- O Senhor dos Anéis: As Duas Torres
    (37, 1), (37, 6), (37, 13),

    -- O Labirinto do Fauno
    (38, 3), (38, 6),

    -- A Viagem de Chihiro
    (39, 6), (39, 11), (39, 13),

    -- O Quinto Elemento
    (40, 1), (40, 9), (40, 13);

INSERT INTO tbPlataformasFilmes (plataforma, filme)
VALUES 
    -- Sociedade dos poetas mortos
    (7, 1),

    -- Antes de Amanhecer
    (4, 2), 

    -- Viva
    (3, 3),

    -- Uma noite de crime
    (1, 4), (5, 4), (6, 4), (7, 4),

    -- Whiplash
    (5, 5), (6, 5),

    -- O sexto sentido
    (7, 6),

    -- A outra face
    (7, 7),

    -- O show de truman
    (1, 8), (6, 8), (7, 8),

    -- Jogos mortais
    (4 , 9), (7, 9),

    -- Truque de mestre
    (4, 10), (5, 10), (7, 10),

    -- Truque de mestre 2
    (4, 11), (5, 11),

    -- Velozes e furiosos 5
    (1, 12), (7, 12),

    -- Pantera negra
    (3, 13),

    -- A grande Muralha
    (1, 14), (5, 14),

    -- Piratas do Caribe
    (3, 15),

    -- Soul
    (3 , 16), 

    -- A nova onda do imperador
    (3, 17),

    -- As vantagens de ser invisível
    (1, 18), (2, 18), (4, 18), (5, 18), (6, 18),

    -- O castelo animado
    (5, 19),

    -- Barbie
    (1, 22), (2, 22), (6, 22) ,

    -- Matrix
    (1, 23), (2, 23), (4, 23), (6, 23),

    -- Era uma Vez no Oeste
    (1, 24), (2, 24), (6, 24),

    -- O Senhor dos Anéis: A Sociedade do Anel
    (1, 25), (2, 25), (4, 25), (6, 25),  

    -- Os Infiltrados
    (1, 26), (2, 26), (4, 26), (6, 26),

    -- Gladiador 
    (1, 27), (2, 27), (5, 27), (6, 27), (7, 27),

    -- O Poderoso Chefão 
    (1, 28), (2, 28), (5, 28), (7, 28),

    -- Forrest Gump
    (1, 29), (2, 29), (6, 29),

    -- Vingadores: Ultimato
    (3, 30),
    
    -- Pulp Fiction: Tempo de Violência
    (1, 31), (2, 31), (6, 31),

    -- O Resgate do Soldado Ryan
    (1, 32), (2, 32), (5, 32), (6, 32),

    -- Interestelar
    (1, 33), (2, 33), (4, 33), (6, 33),

    -- O Silêncio dos Inocentes
    (1, 34), (2, 34), (6, 34), 

    -- Cidade de Deus
    (1, 35), (5, 35), (6, 35),

    -- A Origem
    (1, 36), (2, 36), (6, 36),

    -- O Senhor dos Anéis: As Duas Torres
    (1, 37), (2, 37), (4, 37), (6, 37),

    -- O Labirinto do Fauno
    (1, 38), 

    -- A Viagem de Chihiro
    (5, 39),

    -- O Quinto Elemento
    (1, 40);


INSERT INTO tbReacoes(id, icone, descricao)
VALUES 
    (1, 'emoji-frown', 'triste'),
    (2, 'emoji-neutral', 'tedioso'),
    (3, 'emoji-smile', 'satisfeito'),
    (4, 'emoji-laughing', 'animado'),
    (5, 'emoji-dizzy', 'abismado'),
    (6, 'emoji-heart-eyes', 'amei');