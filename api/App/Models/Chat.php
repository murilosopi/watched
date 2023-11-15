<?php
namespace App\Models;

use App\Model;

class Chat extends Model {
  protected $id;
  protected $tipo;
  protected $data;
  protected $descricao;
  protected $participante;

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
    $stmt->bindValue(':participante', $this->participante);
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

  public function buscarConversasRecentesUsuario() {
    $sql = "SELECT
              tc.*
            FROM
              tbChats tc
            JOIN
              tbParticipantesChat tpc on tpc.chat = tc.id
            WHERE 
              tpc.participante = :participante";

    $stmt = $this->conexao->prepare($sql);

    $stmt->bindValue(':participante', $this->participante);

    $stmt->execute();

    $conversas = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    foreach($conversas as &$conversa) {
      $this->id = $conversa['id'];
      $conversa['participantes'] = $this->obterParticipantesConversa();
      unset($this->id);
    }

    return $conversas;
  }

  public function obterParticipantesConversa() {
    $sql = "SELECT
              tpc.entrada, tu.id, tu.nome, tu.username
            FROM
              tbParticipantesChat tpc
            JOIN 
              tbUsuarios tu on tpc.participante = tu.id 
            WHERE 
              tpc.chat = :id";

    $stmt = $this->conexao->prepare($sql);

    $stmt->bindValue(':id', $this->id);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
}
?>