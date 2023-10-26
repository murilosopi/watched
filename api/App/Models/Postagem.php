<?php
  namespace App\Models;
  use App\Model;

  class Postagem extends Model {
    protected $id;
    protected $texto;
    protected $imagem;
    protected $usuario;

    public function novaPostagem() {
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

    public function adicionarImagem() {
        $sql = "UPDATE tbPostagens
                SET imagem = :imagem
                WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);
        
        $stmt->bindValue(':imagem', $this->imagem);
        $stmt->bindValue(':id', $this->id);

        return $stmt->execute();
    }
  }
?>