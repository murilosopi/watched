<?php
  namespace App\Models;
  use App\Model;

  class Reacao extends Model {
    protected $id;
    protected $descricao;
    protected $icone;
    protected $resenha;

    public function obterIconesReacoes() {
        $sql = "SELECT id, descricao, icone FROM tbReacoes";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function registrarReacaoResenha() {
        $sql = "INSERT INTO tbReacoesResenha (resenha, reacao) VALUES(:resenha, :reacao)";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':resenha', $this->resenha);
        $stmt->bindValue(':reacao', $this->id);
        
        return $stmt->execute();
    }
  }
?>