<?php
  namespace App\Models;
  use App\Connection;

  class Genero {
    private $id;
    private $nome;
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

    public function obterNomesGenerosPorFilme(int $idFilme) {
      $sql = "
        SELECT
          g.nome
        FROM
          tbGenerosFilmes
        RIGHT JOIN
          tbGeneros as g
        ON 
          (genero = g.id)

        WHERE
          filme = :filme
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':filme', $idFilme);
      $stmt->execute();
      
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
  }
?>