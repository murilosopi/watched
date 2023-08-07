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
          p.id, p.nome, p.url_icone, p.url_link
        FROM 
          tb_plataformas_filmes as pf
        RIGHT JOIN
          tb_plataformas as p
        ON
          (pf.id_plataforma = p.id)
        WHERE 
          pf.id_filme = :id_filme;
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_filme', $idFilme);
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
  }
?>