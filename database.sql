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
    reacao INT,
    FOREIGN KEY (usuario) REFERENCES tbUsuarios (id),
    FOREIGN KEY (filme) REFERENCES tbFilmes (id),
    FOREIGN KEY (reacao) REFERENCES tbReacoes (id)
);

CREATE TABLE tbReacoes(
    id INT PRIMARY KEY AUTO_INCREMENT,
    icone VARCHAR(50),
    descricao VARCHAR(50)
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
    ("O Homem de Palha", "https://blogdokira250242846.files.wordpress.com/2020/08/homem.jpg", "Uma jovem desaparece misteriosamente. Para investigar o desaparecimento, o Sargento Howie viaja para uma remota ilha escocesa onde conhece o esquisito Lord Summerisle, um líder religioso da pequena comunidade que realiza estranhos rituais pagãos.", 92, 1973, "Robin Hardy", "Anthony Shaffer", "British Lion Films", "Inglês", "Reino Unido", "The Wicker Man", "Edward Woodward;Diane Cilento;Ingrid Pitt;Chrisstopher Lee"),
    ("Oppenheimer", "https://uploads.jovemnerd.com.br/wp-content/uploads/2022/07/oppenheimer_poster_1__o1a073.jpg", "O físico J. Robert Oppenheimer trabalha com uma equipe de cientistas durante o Projeto Manhattan, levando ao desenvolvimento da bomba atômica.", 180, 2023, "Christopher Nolan", "Christopher Nolan", "Universal Studios", "Inglês", "Estados Unidos", "Oppenheimer", "Cillian Murphy;Florence Pugh;Robert Downey Jr;Emily Blunt"),
    ("Barbie", "https://s2-vogue.glbimg.com/XzSoRntJ3C_YdnlfaW21juqM4Ck=/0x0:480x600/1000x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_5dfbcf92c1a84b20a5da5024d398ff2f/internal_photos/bs/2023/x/C/jqAddPQOijfNlCNKNEFg/339277575-166477655924790-1364217602656200753-n.jpeg", "Depois de ser expulsa da Barbieland por ser uma boneca de aparência menos do que perfeita, Barbie parte para o mundo humano em busca da verdadeira felicidade.", 114, 2023, "Greta Gerwig", "Greta Gerwig, Noah Baumbach", "Warner Bros. Pictures", "Inglês", "Reino Unido", "Barbie", "Margot Robbie;Ryan Gosling;Will Ferrell;Emma Mackey"),

    ("Matrix", "https://img.elo7.com.br/product/main/2679A20/big-poster-filme-matrix-lo03-tamanho-90x60-cm-geek.jpg", "Um programador de computador descobre que a realidade que ele conhece não passa de uma simulação criada por máquinas para escravizar a humanidade. Ele se junta a um grupo de rebeldes para combater as máquinas e libertar a humanidade.", 136, 1999, "Lana Wachowski, Lilly Wachowski", "Lana Wachowski, Lilly Wachowski", "Warner Bros.", "Inglês", "Estados Unidos", "The Matrix", "Keanu Reeves;Laurence Fishburne;Carrie-Anne Moss;Hugo Weaving"),
    ("Era uma Vez no Oeste", "https://leiturafilmica.com.br/wp-content/webp-express/webp-images/uploads/2017/05/era-uma-vez-no-oeste-poster-1.jpg.webp", "A história de um misterioso forasteiro, um homem sem nome, que chega a uma pequena cidade fronteiriça do Velho Oeste. Ele está determinado a proteger uma mulher, que está sendo ameaçada por um magnata da ferrovia, que quer tomar suas terras.", 175, 1968, "Sergio Leone", "Sergio Leone, Sergio Donati", "Paramount Pictures", "Inglês", "Itália e Estados Unidos", "Once Upon a Time in the West", "Henry Fonda;Charles Bronson;Claudia Cardinale;Jason Robards"),
    ("O Senhor dos Anéis: A Sociedade do Anel", "https://br.web.img3.acsta.net/c_310_420/medias/nmedia/18/92/91/32/20224832.jpg", "Um jovem hobbit chamado Frodo recebe uma missão: destruir um anel mágico que pode trazer a destruição do mundo. Ele parte em uma jornada épica, acompanhado de um grupo de amigos e aliados, para cumprir essa tarefa.", 178, 2001, "Peter Jackson", "J.R.R. Tolkien, Fran Walsh, Philippa Boyens, Peter Jackson", "New Line Cinema", "Inglês", "Estados Unidos e Nova Zelândia", "The Lord of the Rings: The Fellowship of the Ring", "Elijah Wood;Ian McKellen;Viggo Mortensen;Sean Astin"),
    ("Os Infiltrados", "https://br.web.img2.acsta.net/c_310_420/medias/nmedia/18/90/18/94/20085052.jpg", "Dois policiais, um infiltrado na máfia e outro como um espião na polícia, tentam descobrir a identidade um do outro enquanto enfrentam o crime organizado em Boston. Um jogo mortal de gato e rato se desenrola.", 151, 2006, "Martin Scorsese", "William Monahan", "Warner Bros.", "Inglês", "Estados Unidos", "The Departed", "Leonardo DiCaprio;Matt Damon;Jack Nicholson;Mark Wahlberg"),
    ("Gladiador", "https://multiversonoticias.com.br/wp-content/uploads/2021/09/gladiador-2-poster.jpg", "Um general romano é traído e sua família é assassinada. Ele se torna um escravo e é forçado a lutar como gladiador para vingar a morte de sua família e recuperar sua honra.", 155, 2000, "Ridley Scott", "David Franzoni, John Logan, William Nicholson", "DreamWorks Pictures", "Inglês", "Estados Unidos e Reino Unido", "Gladiator", "Russell Crowe;Joaquin Phoenix;Connie Nielsen;Oliver Reed"),
    ("O Poderoso Chefão", "https://macabra.tv/wp-content/uploads/2019/05/the-godfather-macabra-poster-380x568.jpg", "A saga de uma família ítalo-americana envolvida no mundo do crime organizado nos Estados Unidos. O patriarca da família, Vito Corleone, tenta passar o controle dos negócios para seu filho Michael, mas uma série de eventos violentos o impedem de fazer isso.", 175, 1972, "Francis Ford Coppola", "Mario Puzo, Francis Ford Coppola", "Paramount Pictures", "Inglês", "Estados Unidos", "The Godfather", "Marlon Brando;Al Pacino;James Caan;Robert Duvall"),
    ("Forrest Gump", "https://upload.wikimedia.org/wikipedia/pt/thumb/c/c0/ForrestGumpPoster.jpg/240px-ForrestGumpPoster.jpg", "A história da vida de Forrest Gump, um homem comum com baixo QI que acidentalmente se envolve em alguns dos eventos mais significativos da história dos Estados Unidos, enquanto busca o amor de sua vida.", 142, 1994, "Robert Zemeckis", "Winston Groom, Eric Roth", "Paramount Pictures", "Inglês", "Estados Unidos", "Forrest Gump", "Tom Hanks;Robin Wright;Gary Sinise;Sally Field"),
    ("Vingadores: Ultimato", "https://img.elo7.com.br/product/main/2678F78/cartaz-poster-vingadores-4-ultimato-filme-marvel-avengers-colecionador.jpg", "Os Vingadores se reúnem para uma última missão: derrotar Thanos, um vilão poderoso que quer destruir metade do universo. Eles viajam no tempo e enfrentam desafios épicos para salvar o mundo.", 181, 2019, "Anthony Russo, Joe Russo", "Christopher Markus, Stephen McFeely", "Marvel Studios", "Inglês", "Estados Unidos", "Avengers: Endgame", "Robert Downey Jr.;Chris Evans;Mark Ruffalo;Chris Hemsworth"),
    ("Pulp Fiction: Tempo de Violência", "https://m.media-amazon.com/images/M/MV5BNGNhMDIzZTUtNTBlZi00MTRlLWFjM2ItYzViMjE3YzI5MjljXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_.jpg", "Uma série de histórias interligadas envolvendo criminosos, gangsters, boxeadores e outros personagens peculiares em Los Angeles. A narrativa segue uma estrutura não linear e é repleta de diálogos memoráveis.", 154, 1994, "Quentin Tarantino", "Quentin Tarantino", "Miramax Films", "Inglês", "Estados Unidos", "Pulp Fiction", "John Travolta;Samuel L. Jackson;Uma Thurman;Bruce Willis"),
    ("O Resgate do Soldado Ryan", "https://image.tmdb.org/t/p/original/hMLxNLCXRDd62acfCBn6mIyW1HU.jpg", "Durante a Segunda Guerra Mundial, um grupo de soldados americanos é enviado para resgatar um soldado cujos irmãos foram mortos em combate. A missão é perigosa e repleta de ação.", 169, 1998, "Steven Spielberg", "Robert Rodat", "Paramount Pictures", "Inglês", "Estados Unidos", "Saving Private Ryan", "Tom Hanks;Matt Damon;Tom Sizemore;Edward Burns"),
    ("Interestelar", "https://upload.wikimedia.org/wikipedia/pt/3/3a/Interstellar_Filme.png", "Em um futuro distante, a Terra enfrenta um colapso ambiental. Um grupo de astronautas embarca em uma jornada interestelar para encontrar um novo lar para a humanidade. Eles enfrentam desafios cósmicos e temporais em sua busca desesperada.", 169, 2014, "Christopher Nolan", "Jonathan Nolan, Christopher Nolan", "Warner Bros.", "Inglês", "Estados Unidos e Reino Unido", "Interstellar", "Matthew McConaughey;Anne Hathaway;Jessica Chastain;Michael Caine"),
    ("O Silêncio dos Inocentes", "https://upload.wikimedia.org/wikipedia/pt/0/0a/Silence_of_the_lambs.png", "Uma agente do FBI busca a ajuda de um famoso psiquiatra canibal para capturar um serial killer que está à solta. O psiquiatra, Hannibal Lecter, é brilhante, mas também perigoso.", 118, 1991, "Jonathan Demme", "Thomas Harris, Ted Tally", "Orion Pictures", "Inglês", "Estados Unidos", "The Silence of the Lambs", "Jodie Foster;Anthony Hopkins;Scott Glenn;Ted Levine"),
    ("Cidade de Deus", "https://www1.folha.uol.com.br/folha/especial/2002/cidadededeus/images/promocao-premios-200x265.jpg", "A história de dois jovens que crescem em uma favela violenta no Rio de Janeiro. Um deles se torna um fotógrafo, enquanto o outro se envolve no crime organizado. Suas vidas se entrelaçam de maneira surpreendente.", 130, 2002, "Fernando Meirelles, Kátia Lund", "Paulo Lins, Bráulio Mantovani", "Miramax Films", "Português", "Brasil", "Cidade de Deus", "Alexandre Rodrigues;Leandro Firmino;Phellipe Haagensen;Douglas Silva"),
    ("A Origem", "https://br.web.img3.acsta.net/c_310_420/medias/nmedia/18/87/32/31/20028688.jpg", "Em um mundo onde é possível entrar nos sonhos das pessoas e roubar informações, um ladrão especializado em invadir mentes é contratado para implantar uma ideia na mente de um empresário. Ele enfrenta desafios complexos em camadas de realidade.", 148, 2010, "Christopher Nolan", "Christopher Nolan", "Warner Bros.", "Inglês", "Estados Unidos e Reino Unido", "Inception", "Leonardo DiCaprio;Joseph Gordon-Levitt;Ellen Page;Tom Hardy"),
    ("O Senhor dos Anéis: As Duas Torres", "https://br.web.img3.acsta.net/c_310_420/medias/nmedia/18/92/34/89/20194741.jpg", "A segunda parte da trilogia O Senhor dos Anéis, onde a sociedade do anel se separa e enfrenta desafios em diferentes partes da Terra-média, enquanto Frodo e Sam continuam sua jornada para destruir o Um Anel.", 179, 2002, "Peter Jackson", "J.R.R. Tolkien, Fran Walsh, Philippa Boyens, Peter Jackson", "New Line Cinema", "Inglês", "Estados Unidos e Nova Zelândia", "The Lord of the Rings: The Two Towers", "Elijah Wood;Ian McKellen;Viggo Mortensen;Sean Astin"),
    ("O Labirinto do Fauno", "https://br.web.img3.acsta.net/r_1920_1080/pictures/16/02/25/16/13/277742.jpg", "No pós-Guerra Civil Espanhola, uma jovem garota se muda com sua mãe para o campo, onde ela descobre um mundo mágico habitado por criaturas místicas e enfrenta desafios perigosos.", 118, 2006, "Guillermo del Toro", "Guillermo del Toro", "Warner Bros.", "Espanhol", "Espanha", "El Laberinto del Fauno", "Ivana Baquero;Sergi López;Maribel Verdú;Doug Jones"),
    ("A Viagem de Chihiro", "https://media.fstatic.com/jw3LjzagsuxKP9jjg-Fs8-TR4CM=/210x312/smart/filters:format(webp)/media/movies/covers/2018/11/MV5BOGJjNzZmMmUtMjljNC00ZjU5LWJiODQtZmEzZTU0MjBlNzgxL2ltYWdlXkEyXk_kisQANO.jpg", "Chihiro, uma jovem garota, entra em um mundo mágico repleto de espíritos e deuses japoneses. Para salvar seus pais transformados em porcos, ela embarca em uma jornada extraordinária.", 125, 2001, "Hayao Miyazaki", "Hayao Miyazaki", "Studio Ghibli", "Japonês", "Japão", "Sen to Chihiro no Kamikakushi", "Rumi Hiiragi;Miyu Irino;Mari Natsuki;Takeshi Naito"),
    ("O Quinto Elemento", "https://br.web.img2.acsta.net/pictures/14/02/07/20/09/270960.jpg", "No século 23, um motorista de táxi do Brooklyn se envolve em uma missão para salvar o mundo quando descobre que uma jovem é a chave para evitar a destruição iminente.", 126, 1997, "Luc Besson", "Luc Besson", "Columbia Pictures", "Inglês", "França", "The Fifth Element", "Bruce Willis;Milla Jovovich;Gary Oldman;Ian Holm");

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