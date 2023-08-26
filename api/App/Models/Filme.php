<?php
  namespace App\Models;
  use App\Connection;

  class Filme {
    private $id;
    private $nome;
    private $sinopse;
    private $notaAvaliacao;
    private $duracaoMin;
    private $numCurtidas;
    private $numSalvos;
    private $numAssistidos;
    private $anoLancamento;
    private $direcao;
    private $roteiro;
    private $distribuicao;
    private $idiomaOriginal;
    private $pais;
    private $nomeOriginal;
    private $conexao;

    public function __construct() {
      $this->conexao = Connection::getDb();
    }

    public function __get($atributo) {
      return $this->$atributo;
    }

    public function __set($atributo, $valor) {
      $this->$atributo = $valor;
      return $this->$atributo;
    }

    // Retorna todos os filmes registrados no banco de dados, podendo limitar os resultados
    public function obterTodosFilmes(int $offset = 0, int $limite = 0) {
      $sql = 'SELECT id, nome, url_cartaz, nota_avaliacao FROM tb_filmes';
      
      $stmt = $this->conexao->prepare($sql);
      if($limite > 0) {
        $sql = $sql . ' LIMIT :offset, :limite;';
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':limite', $limite, \PDO::PARAM_INT);
      } 
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Retorna um filme específico a partir de seu n° identificador
    public function obterFilmePorId() {
      $sql = 'SELECT * FROM tb_filmes WHERE id = :id';

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id', $this->id);
      $stmt->execute();

      return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Retorna todos os filmes da lista de assistidos de um usuário
    public function obterFilmesAssistidosPorUsuario(int $idUsuario) {
      $sql = "
        SELECT 
          f.id, f.nome, f.nota_avaliacao, f.url_cartaz
        FROM 
          tb_filmes_assistidos_usuario as a
        INNER JOIN
          tb_filmes as f
        ON
          (a.id_filme = f.id)
        WHERE 
          id_usuario = :id_usuario
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_usuario', $idUsuario);
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function obterFilmesCurtidosPorUsuario(int $idUsuario) {
      $sql = "
        SELECT 
          f.id, f.nome, f.nota_avaliacao, f.url_cartaz
        FROM 
          tb_filmes_curtidos_usuario as c

        INNER JOIN
          tb_filmes as f
        ON
          (c.id_filme = f.id)
        WHERE 
          id_usuario = :id_usuario;
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_usuario', $idUsuario);
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function obterFilmesSalvosPorUsuario(int $idUsuario) {
      $sql = "
        SELECT 
          f.id, f.nome, f.nota_avaliacao, f.url_cartaz
        FROM 
          tb_filmes_salvos_usuario as s

        INNER JOIN
          tb_filmes as f
        ON
          (s.id_filme = f.id)
        WHERE 
          id_usuario = :id_usuario;
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_usuario', $idUsuario);
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Retorna um valor lógico para a presença do filme na lista de assistidos de um usuário específico
    public function filmeAssistidoPeloUsuario(int $idUsuario) {
      $sql = "
        SELECT 
          *
        FROM 
          tb_filmes_assistidos_usuario 
        WHERE 
          id_usuario = :id_usuario AND id_filme = :id_filme
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_usuario', $idUsuario);
      $stmt->bindValue(':id_filme', $this->id);
      $stmt->execute();

      return boolval($stmt->fetch(\PDO::FETCH_ASSOC));
    }

    // Retorna um valor lógico para a presença do filme na lista de curtidas de um usuário
    public function filmeCurtidoPeloUsuario(int $idUsuario) {
      $sql = "
        SELECT 
          * 
        FROM 
          tb_filmes_curtidos_usuario 
        WHERE 
          id_usuario = :id_usuario AND id_filme = :id_filme
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_usuario', $idUsuario);
      $stmt->bindValue(':id_filme', $this->id);
      $stmt->execute();

      return boolval($stmt->fetch(\PDO::FETCH_ASSOC));
    }

    // Retorna um valor lógico para a presença do filme na lista de s de um usuário
    public function filmeSalvoPeloUsuario(int $idUsuario) {
      $sql = "
        SELECT 
          * 
        FROM 
          tb_filmes_salvos_usuario 
        WHERE 
          id_usuario = :id_usuario AND id_filme = :id_filme
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_usuario', $idUsuario);
      $stmt->bindValue(':id_filme', $this->id);
      $stmt->execute();

      return boolval($stmt->fetch(\PDO::FETCH_ASSOC));
    }

    // Adiciona o filme na lista de curtidos de um usuário
    public function adicionarCurtidaAoFilme(int $idUsuario) {
      $sql = "
        INSERT INTO 
          tb_filmes_curtidos_usuario(id_usuario, id_filme) 
        VALUES
          (:id_usuario, :id_filme)
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_usuario', $idUsuario);
      $stmt->bindValue(':id_filme', $this->id);

      return $stmt->execute();
    }

    // Exclui o filme da lista de curtidos de um usuário
    public function removerCurtidaDoFilme(int $idUsuario) {
      $sql = "
        DELETE FROM
          tb_filmes_curtidos_usuario 
        WHERE 
          id_usuario = :id_usuario AND id_filme = :id_filme
      ";
      
      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_usuario', $idUsuario);
      $stmt->bindValue(':id_filme', $this->id);

      return $stmt->execute();
    }

    // Adiciona o filme na lista de assistidos de um usuário
    public function adicionarFilmeAosAssistidos(int $idUsuario) {
      $sql = "
        INSERT INTO 
          tb_filmes_assistidos_usuario(id_usuario, id_filme) 
        VALUES
          (:id_usuario, :id_filme)
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_usuario', $idUsuario);
      $stmt->bindValue(':id_filme', $this->id);

      return $stmt->execute();
    }

    // Exclui o filme na lista de assistidos de um usuário
    public function removerFilmeDeAssistidos(int $idUsuario) {
      $sql = "
        DELETE FROM
          tb_filmes_assistidos_usuario 
        WHERE 
          id_usuario = :id_usuario AND id_filme = :id_filme
      ";
      
      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_usuario', $idUsuario);
      $stmt->bindValue(':id_filme', $this->id);
      
      return $stmt->execute();
    }

    // Adiciona o filme na lista de filmes salvos de um usuário
    public function adicionarFilmeAosSalvos(int $idUsuario) {
      $sql = "
        INSERT INTO 
          tb_filmes_salvos_usuario(id_usuario, id_filme) 
        VALUES
          (:id_usuario, :id_filme)
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_usuario', $idUsuario);
      $stmt->bindValue(':id_filme', $this->id);

      return $stmt->execute();
    }

    // Adiciona o filme na lista de salvos de um usuário
    public function removerFilmeDeSalvos(int $idUsuario) {
      $sql = "
        DELETE FROM
          tb_filmes_salvos_usuario 
        WHERE 
          id_usuario = :id_usuario AND id_filme = :id_filme
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_usuario', $idUsuario);
      $stmt->bindValue(':id_filme', $this->id);
      
      return $stmt->execute();
    }

    // Atualiza a tabela filmes com os a contagem de todos os usuários que marcaram o filme como assistido
    public function atualizarNumAssistidos() {
      $sql = "
        UPDATE 
          tb_filmes
        SET 
          num_assistidos = (SELECT COUNT(*) FROM tb_filmes_assistidos_usuario WHERE id_filme = :id) 
        WHERE 
          id = :id
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id', $this->id);

      return $stmt->execute();
    }

    // Atualiza a tabela filmes com os a contagem de todos os usuários que curtiram o filme
    public function atualizarNumCurtidas() {
      $sql = "
        UPDATE 
          tb_filmes
        SET 
          num_curtidas = (SELECT COUNT(*) FROM tb_filmes_curtidos_usuario WHERE id_filme = :id) 
        WHERE 
          id = :id
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id', $this->id);

      return $stmt->execute();
    }

    // Atualiza a tabela filmes com os a contagem de todos os usuários que salvaram o filme
    public function atualizarNumSalvos() {
      $sql = "
        UPDATE 
          tb_filmes
        SET 
          num_salvos = (SELECT COUNT(*) FROM tb_filmes_salvos_usuario WHERE id_filme = :id) 
        WHERE 
          id = :id
      ";
      
      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id', $this->id);

      return $stmt->execute();
    }

    // Atualiza a avaliação do filme utilizando a média entre todas as notas registradas na tabela de resenhas, caso existam
    public function atualizarNotaAvaliacao() {
      $sql = "
        SET @num_resenhas = (SELECT COUNT(*) FROM tb_resenhas WHERE id_filme = :id);
        SET @media = (SELECT AVG(nota_avaliacao) FROM tb_resenhas WHERE id_filme = :id);
        
        UPDATE 
          tb_filmes 
        SET 
          nota_avaliacao = (SELECT IF(@num_resenhas = 0, 0, @media))
        WHERE id = :id;
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id', $this->id);

      return $stmt->execute();
    }

    public function buscarFilmes(string $pesquisa) {
      $sql = "
        SELECT 
          id, nome, url_cartaz, nota_avaliacao
        FROM
          tb_filmes
        WHERE
          nome LIKE :pesquisa
      ";
      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':pesquisa', "%$pesquisa%");
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
  }
?>