<?php

namespace App\Models;

use App\Connection;
use App\Model;

class Plataforma extends Model
{
  protected $id;
  protected $nome;
  protected $urlIcone;
  protected $urlLink;

  public function obterPlataformasPorFilme(int $idFilme)
  {
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

  public function plataformaPorId()
  {
    $sql = "
        SELECT 
          icone, url
        FROM 
          tbPlataformas
        WHERE 
          id = :id;
      ";

    $stmt = $this->conexao->prepare($sql);
    $stmt->bindValue(':id', $this->id);
    $stmt->execute();

    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }
}
