<?php
  namespace App\Models;
  use App\Connection;

  class Plataforma {
    private $id;
    private $nome;
    private $urlIcone;
    private $urlLink;
    private $conexao;

    public function __construct() {
      $this->conexao = Connection::getDb();
    }

    public function __get($atributo) {
      return $this->$atributo;
    }

    public function __set($atributo, $valor) {
      $this->atributo = $valor;
    }

    public function obterPlataformasPorFilme(int $idFilme) {
      $sql = "
        SELECT 
          p.id, p.nome, p.icone, p.url
        FROM 
          tbPlataformasFilmes as pf
        RIGHT JOIN
          tbPlataformas as p
        ON
          (pf.plataforma = p.id)
        WHERE 
          pf.filme = :filme;
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':filme', $idFilme);
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
  }
?>