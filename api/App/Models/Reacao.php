<?php
  namespace App\Models;
  use App\Model;

  class Reacao extends Model {
    protected $id;
    protected $descricao;
    protected $icone;

    public function obterIconesReacoes() {
        $sql = "SELECT id, descricao, icone FROM tbReacoes";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
  }
?>