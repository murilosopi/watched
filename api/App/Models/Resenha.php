<?php
  namespace App\Models;
  use App\Connection;

  class Resenha {
    private $id;
    private $idFilme;
    private $idUsuario;
    private $titulo;
    private $descricao;
    private $notaAvaliacao;
    private $dataHora;
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

    // Registra a resenha na base de dados
    public function registrarResenha() {
      $sql = "
        INSERT INTO 
          tb_resenhas (id_filme, id_usuario, titulo, descricao, nota_avaliacao) 
        VALUES
          (:id_filme, :id_usuario, :titulo, :descricao, :nota_avaliacao);
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_filme', $this->idFilme);
      $stmt->bindValue(':id_usuario', $this->idUsuario);
      $stmt->bindValue(':titulo', $this->titulo);
      $stmt->bindValue(':descricao', $this->descricao);
      $stmt->bindValue(':nota_avaliacao', $this->notaAvaliacao);

      return $stmt->execute();
    }

    // Retorna todas as resenhas registradas sobre um filme utilizando o n° identificador
    public function obterTodasResenhasPorFilme() {
      $sql = "
        SELECT 
          r.id, r.id_usuario, r.titulo, r.descricao, r.nota_avaliacao, u.username, u.foto_perfil 
        FROM 
          tb_resenhas as r 
        LEFT JOIN 
          tb_usuarios as u 
        ON
          (r.id_usuario = u.id) 
        WHERE r.id_filme = :id_filme
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_filme', $this->idFilme);
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Retorna todas as resenhas registradas por um usuário utilizando o n° identificador
    public function obterTodasResenhasPorUsuario() {
      $sql = "
        SELECT 
          r.id, r.id_usuario, r.titulo, r.descricao, r.nota_avaliacao, u.username 
        FROM 
          tb_resenhas as r 
        LEFT JOIN 
          tb_usuarios as u 
        ON
          (r.id_usuario = u.id) 
        WHERE 
          r.id_usuario = :id_usuario
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_usuario', $this->idUsuario);
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Retorna uma resenha utilizando os n° identificadores de filme e usuário
    public function obterResenhaPorFilmeUsuario() {
      $sql = "
        SELECT 
          *
        FROM 
          tb_resenhas
        WHERE 
          id_filme = :id_filme AND id_usuario = :id_usuario;
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_filme', $this->idFilme);
      $stmt->bindValue(':id_usuario', $this->idUsuario);
      $stmt->execute();

      return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Exclui a resenha com um determinado n° identificador
    public function deletarResenhaPorFilmeUsuario() {
      $sql = "
        DELETE FROM 
          tb_resenhas
        WHERE 
          id_filme = :id_filme AND id_usuario = :id_usuario
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_filme', $this->idFilme);
      $stmt->bindValue(':id_usuario', $this->idUsuario);
      $stmt->execute();

      return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
  }
?>