<?php

namespace App\Controllers;

use App\Action;
use App\Resources\Response;
use App\Models\Chat;

class ChatController extends Action
{
  public function novoChatIndividual() {
    if(isset($_SESSION['usuario'])) {
      $uid = $_POST['uid'] ?? 0;

      $participantes = [
        $_SESSION['usuario']['id'],
        $uid
      ];

      if(count($participantes) == 2) {
        $chat = new Chat;

        $chat->tipo = 'I';
        $chat->id = $chat->novoChat();

        if(!empty($chat->id)) {

          foreach($participantes as $usuario) {
  
            $chat->idParticipante = $usuario;
  
            $inseriu = $chat->adicionarParticipante();

            if(!$inseriu) {
              $chat->removerParticipantes();
              $chat->excluirChat();
            }
          }
        }
      }
    }



  }

  public function buscarConversasRecentes() {
    $response = new Response;
    if (empty($_SESSION['usuario'])) {
      $response->sucesso = false;
      $response->descricao = "É necessário estar logado para registrar uma resenha.";
      $response->enviar();
    } else {
      $chat = new Chat;
      $chat->participante = $_SESSION['usuario']['id'];
      $conversas = $chat->buscarConversasRecentesUsuario();

      $response->dados = $conversas;
      $response->enviar();
    }
  }
}
