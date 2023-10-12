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
    $stmt->bindValue(':filme', $this->filme);
    $stmt->execute();

    $interacoes =  $stmt->fetch(\PDO::FETCH_ASSOC);
    
    return [
      'assistido' => !empty($interacoes['assistido']),
      'curtido' => !empty($interacoes['curtido']),
      'salvo' => !empty($interacoes['salvo']),
    ];
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

  public function obterTotaisPorFilme() {
    $sql = 
      "SELECT 
        IFNULL(sum(assistido), 0) AS totalAssistido,
        IFNULL(sum(curtido), 0) AS totalCurtido,
        IFNULL(sum(salvo), 0) AS totalSalvo
      FROM 
        tbFilmesUsuario 
      WHERE 
        filme = :filme";


      $stmt = $this->conexao->prepare($sql);

      $stmt->bindValue(':filme', $this->filme);
      $stmt->execute();

      return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  public function consultarTotalAssistidosUsuario() {
    $sql = 
      "SELECT 
        count(*) 
      FROM 
        tbFilmesUsuario 
      WHERE 
        usuario = :usuario and assistido = true";


      $stmt = $this->conexao->prepare($sql);

      $stmt->bindValue(':usuario', $this->usuario);
      $stmt->execute();

      return $stmt->fetchColumn(0);
  }

  public function obterFilmesInteracoesUsuario() {
    $sql = "SELECT 
                F.id, F.titulo, F.cartaz
              FROM 
                tbFilmesUsuario as U
              JOIN tbFilmes as F ON (U.filme = F.id)
              WHERE 
                  U.usuario = :usuario
      ";

    $sql .= isset($this->assistido) ? 'AND U.assistido = TRUE' : '';
    $sql .= isset($this->curtido) ? 'AND U.curtido = TRUE' : '';
    $sql .= isset($this->salvo) ? 'AND U.salvo = TRUE' : '';

    $stmt = $this->conexao->prepare($sql);
    $stmt->bindValue(':usuario', $this->usuario);
    $stmt->execute();
    
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

}
