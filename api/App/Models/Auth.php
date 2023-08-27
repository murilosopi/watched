<?php
namespace App\Models;
use App\Table;

class Auth extends Table {
  protected string $email;
  protected string $username;
  protected string $senha;
  protected string $nome;

  public function cadastroExistente() {
    $sql = "SELECT COUNT(*) AS TOTAL
            FROM tb_usuarios 
            WHERE email = :email OR username = :username";

    $stmt = $this->conexao->prepare($sql);
    
    $stmt->bindValue(':email', $this->email);
    $stmt->bindValue(':username', $this->username);

    $stmt->execute();

    $total = $stmt->fetch()['TOTAL'] ?? 0;

    return $total > 0;
  }

  public function cadastrarUsuario() {
    $sql = "
      INSERT INTO 
        tb_usuarios(nome, username, email, senha)
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
    public function obterUsuarioLogin() {
      $sql = "
        SELECT 
          id, nome, username, sobre, foto_perfil
        FROM 
          tb_usuarios 
        WHERE 
          (username = :username OR email = :username) AND senha = :senha
      ";
      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':username', $this->username);
      $stmt->bindValue(':senha', $this->senha);
      $stmt->execute();
      return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

}

?>