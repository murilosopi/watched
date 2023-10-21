<?php
  namespace App\Models;
  use App\Model;

  class Usuario extends Model {
    protected $id;
    protected $nome;
    protected $username;
    protected $sobre;
    protected $fotoPerfil;
    protected $email;
    protected $senha;

    // Retorna um usuário que tenha um username ou email e senha compatíveis
    public function obterUsuarioPorId() {
      $sql = "
        SELECT 
          id, nome, username, sobre, foto_perfil
        FROM 
          tbUsuarios 
        WHERE 
          id = :id
      ";
      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id', $this->id);
      $stmt->execute();
      return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Retorna um usuário com um determinado email
    public function obterUsuarioPorEmail() {
      $sql = "
        SELECT 
          id, nome, username, sobre, foto_perfil
        FROM 
          tbUsuarios
        WHERE
          email = :usuario
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':usuario', $this->email);
      $stmt->execute();

      return $stmt->fetch();
    }

    // Retorna um usuário com um determinado username
    public function obterUsuarioPorUsername() {
      $sql = "
        SELECT
          id, nome, username, sobre, assinante
        FROM 
          tbUsuarios 
        WHERE 
          username = :username
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':username', $this->username);
      $stmt->execute();

      return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function obterSeguidores() {
      $sql = "
	    	SELECT 
          s.id, s.nome, s.username, s.sobre
        FROM
          tbUsuariosSeguidores as us
        LEFT JOIN
          tbUsuarios as s
        ON
          (us.seguidor = s.id)
          
       	LEFT JOIN
          tbUsuarios as u
        ON
          (us.id = u.id)
          
        WHERE
          us.id = :id || u.username = :username
      ";
      
      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id_usuario', $this->id);
      $stmt->bindValue(':username', $this->username);
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function obterTotalSeguidores() {
      $sql = "
	    	SELECT 
          count(*)
        FROM
          tbUsuariosSeguidores as us          
        WHERE
          us.usuario = :id
      ";
      
      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id', $this->id);
      $stmt->execute();

      return $stmt->fetchColumn(0);
    }

    public function obterSeguindo() {
      $sql = "
	    	SELECT 
          s.id, s.nome, s.username, s.sobre
        FROM
          tbUsuariosSeguidores as us
        LEFT JOIN
          tbUsuarios as s
        ON
          (us.seguidor = s.id)
        WHERE
          us.seguidor = :id || s.username = :username
      ";
      
      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':usuario', $this->id);
      $stmt->bindValue(':username', $this->username);
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function obterTotalSeguindo() {
      $sql = "
	    	SELECT 
          count(*)
        FROM
          tbUsuariosSeguidores as us          
        WHERE
          us.seguidor = :id
      ";
      
      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id', $this->id);
      $stmt->execute();

      return $stmt->fetchColumn(0);
    }

    // Registra um seguidor ao usuário
    public function registrarSeguidor(int $idSeguidor) {
      $sql = "
        INSERT INTO 
          tbUsuariosSeguidores (id, seguidor)
        VALUES
          (:id, :seguidor)
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id', $this->id);
      $stmt->bindValue(':seguidor', $idSeguidor);

      return $stmt->execute();
    }

    public function removerSeguidor(int $idSeguidor) {
      $sql = "
        DELETE FROM 
          tbUsuariosseguidores
        WHERE
          id = :id && id = :id
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':id', $this->id);
      $stmt->bindValue(':seguidor', $idSeguidor);

      return $stmt->execute();
    }

    // Altera o campo "sobre" de um usuário específico
    public function alterarSobre() {
      $sql = "
        UPDATE 
          tbUsuarios 
        SET 
          sobre = :sobre WHERE id = :id
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':sobre', $this->sobre);
      $stmt->bindValue(':id', $this->id);

      return $stmt->execute();
    }

    public function buscarUsuarios() {
      $sql = "
        SELECT 
          id, nome, username, sobre
        FROM
          tbUsuarios
        WHERE
          (nome LIKE :nome || username LIKE :username || sobre LIKE :sobre) AND id != :id;
      ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(':nome', "%{$this->nome}%");
      $stmt->bindValue(':username', "%{$this->username}%");
      $stmt->bindValue(':sobre', "%{$this->sobre}%");
      $stmt->bindValue(':id', $this->id);
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
  }
?>