<?php
  namespace App\Models;
  use App\Model;

  class Interacoes extends Model {
    protected $id;
    protected $assistido;
    protected $curtido;
    protected $salvo;

    public function InteracoesAssistido(int $usuario) {
        $sql = "UPDATE tbFilmesUsuario SET assistido = :assistido WHERE usuario AND filme = :filme";
        
    
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':usuario', $usuario);
        $stmt->bindValue(':assistido', $assistido);
        $stmt->bindValue(':filme', $this->id);
    
        return $stmt-execute();
      }

      public function InteracoesCurtido(int $usuario) {
        $sql = "UPDATE tbFilmesUsuario SET curtido = :curtido WHERE usuario AND filme = :filme";
    
    
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':usuario', $usuario);
        $stmt->bindValue(':curtido', $this->curtido);
        $stmt->bindValue(':filme', $this->id);
    
        return $stmt-execute();
      }

      public function InteracoesModel(int $usuario) {
        $sql = "UPDATE tbFilmesUsuario SET salvo = :salvo WHERE usuario AND filme =:filme";
    
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':usuario', $usuario);
        $stmt->bindValue(':salvo', $this->salvo);
        $stmt->bindValue(':filme', $this->id);
    
        return $stmt-execute();
      }
  }
?>
  
