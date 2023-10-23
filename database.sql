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

INSERT INTO tbReacoes(id, icone, descricao)
VALUES 
    (1, 'emoji-frown', 'triste'),
    (2, 'emoji-neutral', 'tedioso'),
    (3, 'emoji-smile', 'satisfeito'),
    (4, 'emoji-laughing', 'animado'),
    (5, 'emoji-dizzy', 'abismado'),
    (6, 'emoji-heart-eyes', 'amei');