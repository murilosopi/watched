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
          tb_generos_filmes
        RIGHT JOIN
          tb_generos as g
        ON 
          (id_genero = g.id)

        WHERE
          id_filme = :id_filme
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_filme', $idFilme);
      $stmt->execute();
      
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
  }
?>