<?php

namespace App\Models;

use App\Model;

class Interacoes extends Model
{
  protected $usuario;
  protected $filme;
  protected $curtido;
  protected $assistido;
  protected $salvo;

  public function consultarInteracoesFilme() {
    $sql = "SELECT * FROM tbFilmesUsuario WHERE filme = :filme AND usuario = :usuario";

    $stmt = $this->conexao->prepare($sql);
    $stmt->bindValue(':usuario', $this->usuario);
    $stmt->bindValue(':assistido', $this->assistido);
    $stmt->execute();

    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  public function registrarInteracaoFilme() {
    $sql = "INSERT INTO tbFilmesUsuario 
              (filme, usuario, assistido, curtido, salvo)
            VALUES 
              (:filme, :usuario, :assistido, :curtido, :salvo)";

    $stmt = $this->conexao->prepare($sql);

    $stmt->bindValue(':usuario', $this->usuario);
    $stmt->bindValue(':filme', $this->filme);
    $stmt->bindValue(':assistido', $this->assistido ?? false);
    $stmt->bindValue(':curtido', $this->curtido ?? false);
    $stmt->bindValue(':salvo', $this->salvo ?? false);
    
    return $stmt->execute();
  }

  public function alterarFilmeAssistido() {
    $sql = "UPDATE tbFilmesUsuario 
            SET assistido = NOT assistido 
            WHERE usuario = :usuario AND filme = :filme";

    $stmt = $this->conexao->prepare($sql);

    $stmt->bindValue(':usuario', $this->usuario);
    $stmt->bindValue(':filme', $this->filme);

    return $stmt->execute();
  }

  public function alterarFilmeCurtido() {
    $sql = "UPDATE tbFilmesUsuario 
            SET curtido = NOT curtido 
            WHERE usuario = :usuario AND filme = :filme";

    $stmt = $this->conexao->prepare($sql);

    $stmt->bindValue(':usuario', $this->usuario);
    $stmt->bindValue(':filme', $this->filme);

    return $stmt->execute();
  }

  public function alterarFilmeSalvo() {
    $sql = "UPDATE tbFilmesUsuario 
            SET salvo = NOT salvo 
            WHERE usuario = :usuario AND filme = :filme";

    $stmt = $this->conexao->prepare($sql);

    $stmt->bindValue(':usuario', $this->usuario);
    $stmt->bindValue(':filme', $this->filme);

    return $stmt->execute();
  }

  public function consultarTotalAssistidosUsuario() {
    $sql = 
      "SELECT 
        count(*) 
      FROM 
        tbFilmesUsuario 
      WHERE 
        usuario = :usuario AND filme = :filme";


      $stmt = $this->conexao->prepare($sql);

      $stmt->bindValue(':usuario', $this->usuario);
      $stmt->bindValue(':filme', $this->filme);
      $stmt->execute();

      return $stmt->fetchColumn(0);
  }

}
