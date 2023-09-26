<?php
  namespace App\Models;
  use App\Model;

  class Filme extends Model {
    protected $id;
    protected $titulo;
    protected $sinopse;
    protected $duracaoMin;
    protected $anoLancamento;
    protected $direcao;
    protected $roteiro;
    protected $distribuicao;
    protected $idiomaOriginal;
    protected $pais;
    protected $tituloOriginal;
    protected $assistido;
    protected $curtido;
    protected $salvo;
    protected $numCurtidas;
    protected $numSalvos;
    protected $numAssistidos;

    // Retorna todos os filmes registrados no banco de dados, podendo limitar os resultados
    public function obterTodosFilmes() {
      $sql = 'SELECT id, titulo, cartaz, 
                     (SELECT SUM(nota)/COUNT(*) FROM tbResenhas WHERE filme = F.id) as nota
              FROM tbFilmes as F';
      
      $stmt = $this->conexao->prepare($sql);
      if($this->limit) {
        $sql = $sql . ' LIMIT :offset, :limite;';
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':offset', $this->offset, \PDO::PARAM_INT);
        $stmt->bindValue(':limite', $this->limit, \PDO::PARAM_INT);
      } 
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Retorna um filme específico a partir de seu n° identificador
    public function obterFilmePorId() {
      $sql = 'SELECT * FROM tbFilmes WHERE id = :id';

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id', $this->id);
      $stmt->execute();

      return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function obterDetalhesFilme() {
      $sql = 'SELECT 
                tituloOriginal,
                anoLancamento,
                elenco,
                direcao,
                roteiro,
                distribuicao,
                idioma,
                pais
              FROM tbFilmes WHERE id = :id';

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id', $this->id);
      $stmt->execute();

      return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function obterInformacoesFilme() {
      $sql = 'SELECT 
                titulo,
                cartaz,
                sinopse,
                duracaoMin
              FROM tbFilmes WHERE id = :id';

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id', $this->id);
      $stmt->execute();

      return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Retorna todos os filmes da lista de assistidos de um usuário
    public function obterFilmesPorUsuario(int $idUsuario) {
      $sql = "SELECT 
                F.id, F.titulo, F.cartaz
              FROM 
                tbFilmesUsuario as U
              JOIN tbFilmes as F ON (U.filme = F.id)
              WHERE 
                  U.usuario = :usuario
      ";

      $sql .= isset($this->assistido) ? 'AND U.assistido = TRUE' : '';
      $sql .= isset($this->curtido) ? 'AND U.curtido = TRUE' : '';
      $sql .= isset($this->salvo) ? 'AND U.salvo = TRUE' : '';

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':usuario', $idUsuario);
      $stmt->execute();

      $filmes = [];
      
      foreach($stmt->fetchAll(\PDO::FETCH_OBJ) as $filme) {
        if($filme->assistido) $filmes['assistidos'][] = $filme;
        if($filme->curtido) $filmes['curtidos'][] = $filme;
        if($filme->salvo) $filmes['salvos'][] = $filme;
      }

      return $filmes;
    }

    public function obterFilmePorUsuario(int $idUsuario) {
      $sql = "SELECT 
                curtido, assistido, salvo
              FROM 
                tbFilmesUsuario 
              WHERE 
                usuario = :usuario AND filme = :filme
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':usuario', $idUsuario);
      $stmt->bindValue(':filme', $this->id);
      $stmt->execute();

      return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function atualizarCurtidaFilme(int $usuario) {
      $sql = "UPDATE tbFilmesUsuario SET curtido = :curtido WHERE usuario = :usuario AND filme = :filme";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':usuario', $usuario);
      $stmt->bindValue(':curtido', $this->curtido);
      $stmt->bindValue(':filme', $this->id);

      return $stmt->execute();
    }

    public function atualizarAssistidoFilme(int $usuario) {
      $sql = "UPDATE tbFilmesUsuario SET assistido = :assistido WHERE usuario = :usuario AND filme = :filme";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':usuario', $usuario);
      $stmt->bindValue(':assistido', $this->assistido);
      $stmt->bindValue(':filme', $this->id);

      return $stmt->execute();
    }

    public function atualizarSalvoFilme(int $usuario) {
      $sql = "UPDATE tbFilmesUsuario SET salvo = :salvo WHERE usuario = :usuario AND filme = :filme";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':usuario', $usuario);
      $stmt->bindValue(':salvo', $this->salvo);
      $stmt->bindValue(':filme', $this->id);

      return $stmt->execute();
    }

    public function buscarFilmes(string $pesquisa) {
      $sql = "
        SELECT 
          id, titulo, cartaz
        FROM
          tbFilmes
        WHERE
          titulo LIKE :pesquisa
      ";
      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':pesquisa', "%$pesquisa%");
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
  }
?>