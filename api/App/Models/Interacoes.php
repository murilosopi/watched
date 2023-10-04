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
        $stmt->bindValue(':filme', $filme);
    
        return $stmt-execute();
      }

      public function InteracoesCurtido(int $usuario) {
        $sql = "UPDATE tbFilmesUsuario SET curtido = :curtido WHERE usuario AND filme = :filme";
    
    
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':usuario', $usuario);
        $stmt->bindValue(':curtido', $curtido);
        $stmt->bindValue(':filme', $filme);
    
        return $stmt-execute();
      }

      public function InteracoesSalvo(int $usuario) {
        $sql = "UPDATE tbFilmesUsuario SET salvo = :salvo WHERE usuario AND filme =:filme";
    
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':usuario', $usuario);
        $stmt->bindValue(':salvo', $salvo);
        $stmt->bindValue(':filme', $filme);
    
        return $stmt-execute();
      }
  }
?>
  
