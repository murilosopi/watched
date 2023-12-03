<?php

namespace App\Models;

use App\Model;

class Postagem extends Model
{
  protected $id;
  protected $texto;
  protected $imagem;
  protected $usuario;

  public function novaPostagem()
  {
    $sql = "INSERT INTO tbPostagens 
                    (texto, imagem, usuario)
                VALUES 
                    (:texto, :imagem, :usuario)";

    $stmt = $this->conexao->prepare($sql);

    $stmt->bindValue(':texto', $this->texto);
    $stmt->bindValue(':imagem', $this->imagem);
    $stmt->bindValue(':usuario', $this->usuario);

    $exec = $stmt->execute();

    return $exec ? $this->conexao->lastInsertId() : false;
  }

  public function adicionarImagem()
  {
    $sql = "UPDATE tbPostagens
                SET imagem = :imagem
                WHERE id = :id";

    $stmt = $this->conexao->prepare($sql);

    $stmt->bindValue(':imagem', $this->imagem);
    $stmt->bindValue(':id', $this->id);

    return $stmt->execute();
  }

  public function buscarPostagens()
  {
    $sql = "SELECT
                tp.id,
                tp.texto,
                tp.data,
                tu.username
              FROM
                tbPostagens as tp
              JOIN tbUsuarios as tu on
                tu.id = tp.usuario
              WHERE tp.data >= CURDATE() - INTERVAL 7 DAY AND tp.id > :id
              ORDER BY
                tp.id DESC";

    $stmt = $this->conexao->prepare($sql);

    if(!empty($this->limit)) {
      $sql = $sql . ' LIMIT :limit OFFSET :offset';

      $stmt = $this->conexao->prepare($sql);

      $stmt->bindValue(':limit', $this->limit ?? 0, \PDO::PARAM_INT);
      $stmt->bindValue(':offset', $this->offset ?? 0, \PDO::PARAM_INT);
    }

    $stmt->bindValue(':id', $this->id ?? 0);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function obterTotalPostagems()
  {
    $sql = "SELECT ifnull(count(*), 0) FROM tbPostagens WHERE data >= CURDATE() - INTERVAL 7 DAY";

    $stmt = $this->conexao->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn(0);
  }
}
