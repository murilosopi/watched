<?php
  namespace App\Models;
  use App\Model;

  class Resenha extends Model {
    protected $id;
    protected $filme;
    protected $usuario;
    protected $titulo;
    protected $descricao;
    protected $notaAvaliacao;
    protected $dataHora;
    protected $reacao;

    // Registra a resenha na base de dados
    public function registrarResenha() {
      $sql = "
        INSERT INTO 
          tbResenhas (filme, usuario, titulo, descricao, nota, reacao) 
        VALUES
          (:filme, :usuario, :titulo, :descricao, :nota, :reacao);
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':filme', $this->filme);
      $stmt->bindValue(':usuario', $this->usuario);
      $stmt->bindValue(':titulo', $this->titulo);
      $stmt->bindValue(':descricao', $this->descricao);
      $stmt->bindValue(':nota', $this->notaAvaliacao);
      $stmt->bindValue(':reacao', $this->reacao);

      $execute = $stmt->execute();

      return $execute ? $this->conexao->lastInsertId() : false;
    }

    // Retorna todas as resenhas registradas sobre um filme utilizando o n° identificador
    public function obterTodasResenhasPorFilme() {
      $sql = '
        SELECT 
          r.id, r.filme, r.usuario, r.titulo, r.descricao, r.nota, DATE_FORMAT(r.dataHora, "%d/%m/%Y %I:%i") as data, u.username
        FROM 
          tbResenhas as r 
        JOIN 
          tbUsuarios as u 
        ON
          (r.usuario = u.id) 
        WHERE r.filme = :filme
      ';

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':filme', $this->filme);
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Retorna todas as resenhas registradas por um usuário utilizando o n° identificador
    public function obterTodasResenhasPorUsuario() {
      $sql = 
        "SELECT 
          r.id, r.usuario, r.titulo,
          r.descricao, r.nota, u.username, 
          r.filme,
          reacao.id as idReacao, reacao.descricao as descricaoReacao, reacao.icone as iconeReacao
        FROM 
          tbResenhas as r 
        JOIN tbUsuarios as u ON (r.usuario = u.id)
        LEFT JOIN tbReacoes as reacao ON reacao.id = r.reacao
        WHERE 
          r.usuario = :usuario
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':usuario', $this->usuario);
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function obterTotalResenhasUsuario() {
      $sql = "
        SELECT 
          count(*)
        FROM 
          tbResenhas as r
        WHERE 
          r.usuario = :usuario
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':usuario', $this->usuario);
      $stmt->execute();

      return $stmt->fetchColumn(0);
    }

    // Exclui a resenha com um determinado n° identificador
    public function deletarResenhaPorFilmeUsuario() {
      $sql = "
        DELETE FROM 
          tbResenhas
        WHERE 
          filme = :filme AND usuario = :usuario
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':filme', $this->filme);
      $stmt->bindValue(':usuario', $this->usuario);

      return $stmt->execute();
    }

    public function obterNotaFilme() {
      $sql = "SELECT
                SUM(nota)/COUNT(*) AS nota
              FROM
                tbResenhas
              WHERE 
                filme = :filme
              ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':filme', $this->filme);
      $stmt->execute();

      return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function obterTotalResenhasUsuarioFilme() {
      $sql = "SELECT
                COUNT(*) AS total
              FROM
                tbResenhas
              WHERE 
                filme = :filme
                AND usuario = :usuario
              ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':filme', $this->filme);
      $stmt->bindValue(':usuario', $this->usuario);
      $stmt->execute();

      return $stmt->fetchColumn(0);
    }

    public function avaliacoesPorFilme() {
      $sql = "SELECT nota FROM tbResenhas WHERE filme = :filme";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':filme', $this->filme);
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function reacaoPorFilme() {
      $sql = "SELECT
                reacao.icone as icone,
                reacao.descricao as descricao,
                reacao.id as id,
                count(resenha.id) as total
              FROM
                tbReacoes reacao
              LEFT JOIN
                tbResenhas resenha ON reacao.id = resenha.reacao
              WHERE 
                resenha.filme = :filme
	              OR resenha.id IS NULL
              GROUP BY 
                reacao.descricao, reacao.id, reacao.icone";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':filme', $this->filme);
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
  }
?>