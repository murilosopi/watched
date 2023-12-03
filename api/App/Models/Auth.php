<?php

namespace App\Models;

use App\Model;

class Auth extends Model
{
  protected int $id;
  protected string $email;
  protected string $username;
  protected string $senha;
  protected string $nome;
  protected string $token;

  public function cadastroExistente()
  {
    $sql = "SELECT COUNT(*) AS TOTAL
            FROM tbUsuarios 
            WHERE email = :email OR username = :username";

    $stmt = $this->conexao->prepare($sql);

    $stmt->bindValue(':email', $this->email);
    $stmt->bindValue(':username', $this->username);

    $stmt->execute();

    $total = $stmt->fetch()['TOTAL'] ?? 0;

    return $total > 0;
  }

  public function cadastrarUsuario()
  {
    $sql = "
      INSERT INTO 
        tbUsuarios(nome, username, email, senha)
      VALUES
        (:nome, :username, :email, :senha)
    ";

    $stmt = $this->conexao->prepare($sql);
    $stmt->bindValue(':nome', $this->nome);
    $stmt->bindValue(':username', $this->username);
    $stmt->bindValue(':email', $this->email);
    $stmt->bindValue(':senha', $this->senha);

    return $stmt->execute();
  }


  // Retorna um usuário que tenha um username ou email e senha compatíveis
  public function obterUsuarioLogin()
  {
    $sql = "
        SELECT 
          id, nome, username, sobre, senha, email, status, token
        FROM 
          tbUsuarios 

        LEFT JOIN
          tbTokens ON tbTokens.usuario = tbUsuarios.id
        WHERE 
          (username = :username OR email = :username)
      ";
    $stmt = $this->conexao->prepare($sql);
    $stmt->bindValue(':username', $this->username);
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  public function atualizarAcesso()
  {
    $sql = "UPDATE tbUsuarios SET ultimoAcesso = CURRENT_TIMESTAMP WHERE id = :id";

    $stmt = $this->conexao->prepare($sql);
    $stmt->bindValue(':id', $this->id);

    return $stmt->execute();
  }

  public function registrarToken()
  {
    $sql = "
      INSERT INTO 
        tbTokens(token, usuario)
      VALUES
        (:token, :usuario)
    ";

    $stmt = $this->conexao->prepare($sql);
    $stmt->bindValue(':token', $this->token);
    $stmt->bindValue(':usuario', $this->id);

    return $stmt->execute();
  }

  public function removerToken()
  {
    $sql = "
      DELETE FROM 
        tbTokens
      WHERE usuario = :usuario
    ";

    $stmt = $this->conexao->prepare($sql);
    $stmt->bindValue(':usuario', $this->id);

    return $stmt->execute();
  }

  public function atualizarToken()
  {
    $sql = "
      UPDATE 
        tbTokens
      SET
        data = CURRENT_TIMESTAMP,
        token = :token
      WHERE usuario = :usuario
    ";

    $stmt = $this->conexao->prepare($sql);
    $stmt->bindValue(':usuario', $this->id);
    $stmt->bindValue(':token', $this->token);

    return $stmt->execute();
  }

  public function existeToken()
  {
    $sql = "
      SELECT 
        count(*)
      FROM
        tbTokens
      WHERE usuario = :usuario AND token = :token
    ";

    $stmt = $this->conexao->prepare($sql);
    $stmt->bindValue(':usuario', $this->id);
    $stmt->bindValue(':token', $this->token);
    $stmt->execute();

    $total = $stmt->fetchColumn(0);
    return ($total ?? 0) > 0;
  }
}
