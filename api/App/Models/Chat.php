<?php
namespace App\Models;

use App\Model;

class Chat extends Model {
  protected $id;
  protected $tipo;
  protected $data;
  protected $descricao;
  protected $idParticipante;

  public function novoChat() {
    $sql = "INSERT INTO tbChats(tipo) VALUES(:tipo)";
    
    $stmt = $this->conexao->prepare($sql);
    $stmt->bindValue(':tipo', $this->tipo);

    $execute = $stmt->execute();

    return $execute ? $this->conexao->lastInsertId() : false;
  }

  public function adicionarParticipante() {

    $sql = "INSERT INTO tbParticipantesChat(chat, participante) VALUES(:chat, :participante)";
    
    $stmt = $this->conexao->prepare($sql);
    $stmt->bindValue(':participante', $this->idParticipante);
    $stmt->bindValue(':chat', $this->id);

    return $stmt->execute();

  }

  public function removerParticipantes() {
    $sql = "DELETE FROM tbParticipantesChat WHERE chat = :chat";

    $stmt = $this->conexao->prepare($sql);

    $stmt->bindValue(':chat', $this->id);

    return $stmt->execute();

  }

  public function excluirChat() {
    $sql = "DELETE FROM tbChatsChat WHERE id = :chat";

    $stmt = $this->conexao->prepare($sql);

    $stmt->bindValue(':chat', $this->id);

    return $stmt->execute();

  }
}
?>