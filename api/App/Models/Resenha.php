<?php
  namespace App\Models;
  use App\Model;

  class Resenha extends Model {
    protected $id;
    protected $idFilme;
    protected $idUsuario;
    protected $titulo;
    protected $descricao;
    protected $notaAvaliacao;
    protected $dataHora;

    // Registra a resenha na base de dados
    public function registrarResenha() {
      $sql = "
        INSERT INTO 
          tbResenhas (filme, usuario, titulo, descricao, nota) 
        VALUES
          (:filme, :usuario, :titulo, :descricao, :nota);
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':filme', $this->idFilme);
      $stmt->bindValue(':usuario', $this->idUsuario);
      $stmt->bindValue(':titulo', $this->titulo);
      $stmt->bindValue(':descricao', $this->descricao);
      $stmt->bindValue(':nota', $this->notaAvaliacao);

      return $stmt->execute();
    }

    // Retorna todas as resenhas registradas sobre um filme utilizando o n° identificador
    public function obterTodasResenhasPorFilme() {
      $sql = "
        SELECT 
          r.id, r.usuario, r.titulo, r.descricao, r.nota, u.username
        FROM 
          tbResenhas as r 
        LEFT JOIN 
          tbUsuarios as u 
        ON
          (r.usuario = u.id) 
        WHERE r.filme = :filme
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':filme', $this->idFilme);
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Retorna todas as resenhas registradas por um usuário utilizando o n° identificador
    public function obterTodasResenhasPorUsuario() {
      $sql = "
        SELECT 
          r.id, r.usuario, r.titulo, r.descricao, r.nota, u.username 
        FROM 
          tbResenhas as r 
        LEFT JOIN 
          tbUsuarios as u 
        ON
          (r.usuario = u.id) 
        WHERE 
          r.usuario = :usuario
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':usuario', $this->idUsuario);
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
      $stmt->bindValue(':filme', $this->idFilme);
      $stmt->bindValue(':usuario', $this->idUsuario);
      $stmt->execute();

      return $stmt->fetch(\PDO::FETCH_ASSOC);
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
      $stmt->bindValue(':filme', $this->idFilme);
      $stmt->execute();

      return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
  }
?>