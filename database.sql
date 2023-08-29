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
    ultimoAcesso DATE,
    dataCadastro DATE DEFAULT CURRENT_TIMESTAMP
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

CREATE TABLE tbFilmes(
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(100) NOT NULL,
    tituloOriginal VARCHAR(100),
    cartaz TEXT NOT NULL,
    sinopse TEXT NOT NULL,
    nota DECIMAL(2, 1) DEFAULT 0.0,
    duracaoMin INT(3) NOT NULL,
    anoLancamento INT(4) NOT NULL,
    direcao VARCHAR(400) NOT NULL,
    roteiro VARCHAR(400) NOT NULL,
    distribuicao VARCHAR(100) NOT NULL,
    idioma VARCHAR(200) NOT NULL,
    pais VARCHAR(30) NOT NULL,
    elenco VARCHAR(500) NOT NULL
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

CREATE TABLE tbResenhas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    filme INT NOT NULL,
    usuario INT NOT NULL,
    titulo VARCHAR(100) DEFAULT "",
    descricao TEXT NOT NULL,
    nota DECIMAL(2, 1) DEFAULT 0.0,
    dataHora DATETIME DEFAULT CURRENT_TIMESTAMP,
    reacao CHAR(1),
    FOREIGN KEY (usuario) REFERENCES tbUsuarios (id),
    FOREIGN KEY (filme) REFERENCES tbFilmes (id)
);


/*Chat: */
CREATE TABLE tbChats(
    id INT PRIMARY KEY AUTO_INCREMENT,
    tipo CHAR(1) NOT NULL, -- I: individual | G: grupo,
    data DATE DEFAULT CURRENT_TIMESTAMP,
    descricao VARCHAR(1000)
);

CREATE TABLE tbParticipantesChat(
    chat INT NOT NULL,
    participante INT NOT NULL,
    adm BOOLEAN DEFAULT FALSE,
    entrada DATE DEFAULT CURRENT_TIMESTAMP,
    saida DATE,
    expulso BOOLEAN
);

CREATE TABLE tbMensagens(
    chat INT NOT NULL,
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    texto VARCHAR(600) NOT NULL
);



/* TABELAS AUXILIARES (N-N) */

CREATE TABLE tbGenerosFilmes(
    genero INT NOT NULL,
    filme INT NOT NULL,
    FOREIGN KEY (genero) REFERENCES tbGeneros (id),
    FOREIGN KEY (filme) REFERENCES tbFilmes (id)
);

CREATE TABLE tbPlataformasFilmes(
    plataforma INT NOT NULL,
    filme INT NOT NULL,
    FOREIGN KEY (plataforma) REFERENCES tbPlataformas (id), 
    FOREIGN KEY (filme) REFERENCES tbFilmes (id)
);

CREATE TABLE tbFilmesUsuario(
    filme INT NOT NULL,
    usuario INT NOT NULL,
    assistido BOOLEAN DEFAULT FALSE,
    curtido BOOLEAN DEFAULT FALSE,
    salvo BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (filme) REFERENCES tbFilmes (id),
    FOREIGN KEY (usuario) REFERENCES tbUsuarios (id)
);

CREATE TABLE tbUsuariosSeguidores (
    usuario INT NOT NULL,
    seguidor INT NOT NULL,
    FOREIGN KEY(usuario) REFERENCES tbUsuarios(id),
    FOREIGN KEY(seguidor) REFERENCES tbUsuarios(id)
);

INSERT INTO tbFilmes (titulo, Cartaz, sinopse, duracaoMin, anoLancamento, direcao, roteiro, distribuicao, idioma, pais, tituloOriginal, elenco)
VALUES 
    ("Sociedade dos Poetas Mortos", "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRcYujNBQq53Q8zvISFhnguM42cFndgo-8UQso2ZMZREnEhhMQW", "O novo professor de Inglês John Keating é introduzido a uma escola preparatória de meninos que é conhecida por suas antigas tradições e alto padrão. Ele usa métodos pouco ortodoxos para atingir seus alunos, que enfrentam enormes pressões de seus pais e da escola. Com a ajuda de Keating, os alunos Neil Perry, Todd Anderson e outros aprendem como não serem tão tímidos, seguir seus sonhos e aproveitar cada dia.", 128, 1989, "Peter Weir", "Tom Schulman", "Disney", "Inglês", "Estados Unidos", "Dead Poets Society", "Robin Williams;Ethan Hawke;Robert Sean;Josh Charles"),
    ("Antes do Amanhecer", "https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcRytXtKVFseDVfEqbi-SFX_OXjedSzDJWd0qQ9MPdclk-YcKc8", "Jesse, um jovem americano, e Celine, uma linda francesa, se conhecem no trem para Paris, e começam uma conversa que os leva a fazer uma escala em Viena e ficar um pouco mais juntos, sem imaginar o que o destino os reserva.", 105, 1995, "Richard Linklater", "Richard Linklater, Kim Krizan", "Columbia Pictures", "Inglês", "Estados Unidos e Áustria", "Before Sunrise", "Ethan Hawke;Julie Delpy;Hanno Poschl;Hans Weingartner"),
    ("Viva: A Vida é Uma Festa", "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQLlC1BU-d_49KZvZrLQ6vhp_dsWObCyp9a7UuJe0-8tpQcJ3fM", "Apesar da proibição da música por gerações de sua família, o jovem Miguel sonha em se tornar um músico talentoso como seu ídolo Ernesto de la Cruz. Desesperado para provar seu talento, Miguel se encontra na deslumbrante e colorida Terra dos Mortos. Depois de conhecer um charmoso malandro chamado Héctor, os dois novos amigos embarcam em uma jornada extraordinária para desvendar a verdadeira história por trás da história da família de Miguel.", 105, 2017, "Adrian Molina, Lee Unkrich", "Adrian Molina, Lee Unkrich, Matthew Aldrich, Jason Katz", "Disney", "Inglês", "Estados Unidos", "Coco", "Arthur Salerno;Leando Luna;Nando Pradho;Adriana Quadros"),
    ("Uma Noite de Crime", "https://br.web.img3.acsta.net/pictures/210/335/21033500_20130830193413918.jpg", "The Purge é uma franquia americana de filmes de terror e ação, composta por cinco filmes e uma série de televisão. A franquia se passa numa versão distópica dos Estados Unidos onde, uma vez por ano, durante um período de 12 horas, todo crime, incluindo até mesmo estupro e homicídio, é legalizado.", 88, 2013, "James DeMonaco", "James DeMonaco", "Universal Pictures", "Inglês", "Estados Unidos", "The Purge", "Ethan Hawke;Lena Headey;Max Burkholder;Adelaide Kane"),
    ("Em Busca da Perfeição", "https://i.pinimg.com/originals/e3/ae/19/e3ae19905686795e350cbb54ff4c99ea.jpg", "Andrew sonha em ser o melhor baterista de sua geração. Ele chama a atenção do impiedoso mestre do jazz Terence Fletcher, que ultrapassa os limites e transforma seu sonho em uma obsessão, colocando em risco a saúde física e mental do jovem músico.", 107, 2014, "Damien Chazelle", "Damien Chazelle", "Sony Pictures Classics", "Inglês", "Estados Unidos", "Whiplash", "Miles Teller;J.K Simmons;Paul Reiser;Melissa Benoist"),
    ("O Sexto Sentido", "https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcSm1bD7Hdfo2lFPc4GdhCWa0moWg5jkLRnnD8eIJz0BmaSCe2V", "Um garoto vê o espírito de pessoas mortas à sua volta. Um dia, ele conta o segredo ao psicólogo Malcolm Crowe, que tenta ajudá-lo a descobrir o que está por trás dos distúrbios. A pesquisa de Crowe sobre os poderes do garoto causa consequências inesperadas a ambos.", 107, 1999, "M. Night Shyamalan", "M. Night Shyamalan", "Buena Vista Pictures Distribution", "Inglês", "Estados Unidos", "The Sixth Sense", "Bruce Willis;Haley Joel Osment;Toni Collete;Olivia Williams"),
    ("A Outra Face", "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS4yxlPR0kQVjAP_xXjOYdtdrxTEsvNNq1utBORBZqQUo5CBtZz", "Agente do FBI troca de rosto com um terrorista para vingar a morte do filho, mas tudo se transforma em um grande pesadelo e ele precisa lutar pela sua vida e também de sua família.", 138, 1997, "John Woo", "Mike Werb e Michael Colleary", "Paramount Pictures (América do Norte) e Buena Vista International", "Inglês", "Estados Unidos", "Face Off", "John Travolta;Nicolas Cage;Joan Allen;Alessandro Nivola"),
    ("O Show de Truman", "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTOcA2mFPvtwJaYBUmFebJ0g6DUyrsl912CcPkAFhnkkj2Dt-d6", "Truman Burbank é um pacato vendedor de seguros que leva uma vida simples com sua esposa Meryl Burbank. Porém, algumas coisas ao seu redor fazem com que ele passe a estranhar sua cidade, seus supostos amigos e até sua mulher. Após conhecer a misteriosa Lauren, ele fica intrigado e acaba descobrindo que toda sua vida foi monitorada por câmeras e transmitida em rede nacional.", 103, 1998, "Peter Weir", "Andrew Niccol", "Paramount Pictures", "Inglês", "Estado Unidos", "The Thuman Show", "Jim Carrey;Laura Linney;Ed Harris;Noah Emmerich;Natascha McElhone"),
    ("Jogos Mortais", "https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQ_bHH1GHmNAry7yF3QASbvbIb-pV6xwmnad02t0HWw2CHO5-mS", "Dois homens acordam acorrentados em um banheiro como prisioneiros de um assassino em série que leva suas vítimas a situações limítrofes em um jogo macabro. Para sobreviver, eles terão de desvendar juntos as peças desse quebra-cabeças doentio.", 103, 2004, "James Wan", "Leigh Whannell", "Lions Gate Films e Paris Filmes (Brasil)", "Inglês", "Estados Unidos", "The Thuman Show", "Tobin Beel;Cary Elwes;Leigh Whannell;Shawnee Smith;Danny Glover;Michael Emerson"),
    ("Truque de Mestre", "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRrBOuSm7oyIe_011NtkMuNHwxtZNFQIeqZLtMHjM3K33dEOgOe", "Um grupo de ilusionistas encanta o público com suas mágicas e também rouba bancos em outro continente, distribuindo a quantia para os próprios espectadores. O agente do FBI Dylan Hobbs está determinado a capturá-los e conta com a ajuda de Alma Vargas, uma detetive da Interpol, e também de Thaddeus Bradley, um veterano desmistificador de mágicos que insiste que os assaltos são realizados a partir de disfarces e jogos envolvendo vídeos.", 115, 2013, "Louis Leterrier", "Ed Solomon e Boaz Yakin", "Lionsgate", "Inglês", "Estados Unidos", "Insaisissables", "Jesse Eisenberg;Mark Ruffalo;Woody Harrelson;Morgan Freeman"),
    ("Truque de Mestre 2", "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRLhkR1Ujnjew3254Vmxtg8fwKntloYLedwswqCaMBoS-oe91bR", "Após enganarem o FBI, os cavaleiros Daniel Atlas, Merritt McKinney e Jack Wilder estão foragidos. Eles seguem as ordens de Dylan Rhodes, que segue trabalhando no FBI de forma a impedir os avanços na procura dos próprios cavaleiros. Paralelamente, o grupo planeja seu novo ato: desmascarar um jovem gênio da informática, cujo novo lançamento coleta dados pessoais dos usuários.", 130, 2016, "Jon M. Chu", "Ed Solomon", "Summit Entertainment", "Inglês", "Estado Unidos", "Insaisissables 2", "Jesse Eisenberg;Mark Ruffalo;Woody Harrelson;Lizzy Caplan"),
    ("Velozes e Furiosos 5: Operação Rio", "https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTo3ITeQq2pZsUEsuo30L9sTU3bCnRR4qN5l_4CVkYGd-VskiP8", "Desde que o ex-policial Brian O'Conner e Mia Toretto libertaram Dom da prisão, eles viajam pelo mundo para fugir das autoridades. No Rio de Janeiro, eles são obrigados a fazer um último trabalho antes de ganhar sua liberdade definitiva. Brian e Dom montam uma equipe de elite de pilotos de carro para executar a tarefa, mas precisam enfrentar um empresário corrupto e também um obstinado agente federal norte-americano.", 130, 2011, "Justin Lin", "chris Morgan", "Universal Pictures", "Inglês", "Estados Unidos", "Fast & Furious 5: Rio Heis", "Vin Diesel;Paul Walker;Gal Gadot;Dwayne Johnson"),
    ("Pantera Negra", "https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQarmjVytz3ISRKJNwmxG7o-r4sWWN5VxbPp9qJauK4VvGrKu36", "Em Pantera Negra, após a morte do rei T'Chaka (John Kani), o príncipe T'Challa (Chadwick Boseman) retorna a Wakanda para a cerimônia de coroação. Nela são reunidas as cinco tribos que compõem o reino, sendo que uma delas, os Jabari, não apoia o atual governo. T'Challa logo recebe o apoio de Okoye (Danai Gurira), a chefe da guarda de Wakanda, da irmã Shuri (Letitia Wright), que coordena a área tecnológica do reino, e também de Nakia (Lupita Nyong'o), a grande paixão do atual Pantera Negra, que não quer se tornar rainha. Juntos, eles estão à procura de Ulysses Klaue (Andy Serkis), que roubou de Wakanda um punhado de vibranium, alguns anos atrás.", 135, 2018, "Ryan Coogler", "Stan Lee", "Disney", "Inglês", "Estados Unidos", "Black Panther", "Chadwick Boseman;Lupita Nyong'o;Michael B. Jordan;Danai Gurira"),
    ("A Grande Muralha", "https://br.web.img3.acsta.net/pictures/16/08/01/14/48/338063.jpg", "Um grupo de soldados britânicos está lutando na China e se depara com o início das construções da Grande Muralha. Eles percebem que o intuito não é apenas proteger a população do inimigo mongol e que a construção esconde na verdade um grande segredo.", 103, 2017, "Zhang Yimou", "Carlo Bernard e Doug Miro", " 	Universal Pictures e China Film Group", "Inglês", "Estados Unidos", "The Great Wall", "Matt Damon;Jing Tian;Willem Dafoe;Pedro Pascal"),
    ("Piratas do Caribe: A Maldição do Pérola Negra", "https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcTvMYX13i4GzSEzDGhNKaLu-eu7zRcScx_BjTDK2gvvwRkRcqWz", "O pirata Jack Sparrow tem seu navio saqueado e roubado pelo capitão Barbossa e sua tripulação. Com o navio de Sparrow, Barbossa invade a cidade de Port Royal, levando consigo Elizabeth Swann, filha do governador. Para recuperar sua embarcação, Sparrow recebe a ajuda de Will Turner, um grande amigo de Elizabeth. Eles desbravam os mares em direção à misteriosa Ilha da Morte, tentando impedir que os piratas-esqueleto derramem o sangue de Elizabeth para desfazer a maldição que os assola.", 153, 2003, "Gore Verbinski", "Ted Elliott, Terry Rossio, Stuart Beattie e Jay Wolpert", "Buena Vista Pictures", "Inglês", "Estados Unidos", "Pirates of the Caribbean: The Curse of the Black Pearl", "Johnny Depp;Keira Knightley;Orlando Bloom;Geoffrey Rush"),
    ("Soul", "https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcRmL0LHrUY5XZWfDmHV6-WbTQH6J2FMlZ_JqK7E8oPXcqYgVEE-", "Joe é um professor de música do ensino médio apaixonado por jazz, cuja vida não foi como ele esperava. Quando ele viaja a uma outra realidade para ajudar outra pessoa a encontrar sua paixão, ele descobre o verdadeiro sentido da vida.", 100, 2020, "Pete Docter, Kemp Powers", "Pete Docter, Kemp Powers", "Disney", "Inglês", "Estados Unidos", NULL, "Jamie Foxx;Tina Fey;Graham Norton"),
    ("A Nova Onda do Imperador", "https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQCsKA1RQh59O3CUu_h7Q3UBqG90RfN7MfgOxtAnTQwCNQN-0ag", "O jovem e arrogante Imperador Kuzco é transformado em uma lhama por sua poderosa mentora chamada Yzma. Perdido na floresta, a única chance de Kuzco recuperar seu trono é com a ajuda de Pacha, um humilde camponês. Juntos, eles precisam enfrentar a bruxa Yzma antes de concluir sua jornada.", 78, 2000, "Mark Dindal", "Stephen J. Anderson, Don Hall", "Buena Vista Pictures", "Inglês", "Estados Unidos", "The Emperor's New Groove", "David Spade;John Goodman;Patrick Warburton;Eartha Kitt"),
    ("As Vantagens de Ser Invisível", "https://br.web.img3.acsta.net/medias/nmedia/18/90/78/52/20295598.jpg", "Um jovem tímido se esconde em seu próprio mundo até conhecer dois irmãos que o ajudam a viver novas experiências. Embora esteja feliz nessa nova fase, ele não esquece as tristezas do passado, que têm origem em uma chocante revelação.", 105, 2012, "Stephen Chbosky", "Stephen Chbosky, Stephen Chbosky", "Summit Entertainment", "Inglês", "Estados Unidos", "The Perks of Being a Wallflower", "Logan Lerman;Emma Watson;Ezra Miller;Erin Wilhelmi"),
    ("O Castelo Animado", "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKZ7FR5KMc8sY9rMJ520kSC1C_o6IxYl-vs5vKzglEhcEA755p", "Uma bruxa lança uma terrível maldição sobre a jovem Sophie transformando-a numa velha de 90 anos. Desesperada, ela embarca numa odisseia em busca do Castelo Andante, onde reside um misterioso feiticeiro que poderá ajudá-la a reverter o feitiço.", 99, 2004, "Hayao Miyazaki", "Diana Wynne Jones, Hayao Miyazaki", "Toho", "Japonês", "Japão", "Hauru no Ugoku Shiro", "Chieko Baishô;Takuya Kimura;Ryûnosuke Kamiki;Mitsunori Isaki"),
    ("O Homem de Palha", "https://blogdokira250242846.files.wordpress.com/2020/08/homem.jpg", "Uma jovem desaparece misteriosamente. Para investigar o desaparecimento, o Sargento Howie viaja para uma remota ilha escocesa onde conhece o esquisito Lord Summerisle, um líder religioso da pequena comunidade que realiza estranhos rituais pagãos.", 92, 1973, "Robin Hardy", "Anthony Shaffer", "British Lion Films", "Inglês", "Reino Unido", "The Wicker Man", "Edward Woodward;Diane Cilento;Ingrid Pitt;Chrisstopher Lee");


INSERT INTO tbPlataformas (nome, icone, url)
VALUES 
    ("Amazon Prime", "assets/img/icons/amazon-icon.svg", "https://www.primevideo.com/"),
    ("Apple TV+", "assets/img/icons/apple-icon.svg", "https://www.apple.com/br/apple-tv-plus/"),
    ("Disney +", "assets/img/icons/disney-icon.svg", "https://www.disneyplus.com/"),
    ("HBO Go", "assets/img/icons/hbo-icon.svg", "https://www.hbomax.com/"),
    ("Netflix", "assets/img/icons/netflix-icon.svg", "https://www.netflix.com"),
    ("Youtube", "assets/img/icons/yt-icon.svg", "https://www.youtube.com/feed/storefront"),
    ("Star +", "assets/img/icons/star-plus-icon.svg", "https://www.starplus.com");


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
    (20, 7), (20, 6), (20, 10);


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
    (5, 19);