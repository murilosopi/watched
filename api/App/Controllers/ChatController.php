<?php

namespace App\Controllers;

use App\Action;
use App\Resources\Response;
use App\Models\Chat;

class ChatController extends Action
{
  public function novoChatIndividual()
  {
    $response = new Response;
    if (isset($_SESSION['usuario'])) {
      $uid = $_POST['uid'] ?? 0;

      $participantes = [
        $_SESSION['usuario']['id'],
        $uid
      ];

      $chat = new Chat;

      $chat->tipo = 'I';
      $chat->id = $chat->novoChat();

      if ($chat->id !== false) {

        foreach ($participantes as $usuario) {

          $chat->participante = $usuario;
          $inseriu = $chat->adicionarParticipante();

          if (!$inseriu) {
            $chat->removerParticipantes();
            $chat->excluirChat();
            
            $response->erro("Ocorreu um erro ao adicionar o usuario {$usuario} ao chat.");
          }
        }
      } else {
        $response->erro("Ocorreu um erro ao iniciar o chat.");
      }
      
      $response->dados = $chat->id;
      $response->sucesso = !empty($response->dados);
      $response->enviar();
    } else {
      $response->erro("É necessário estar logado para realizar esta ação.");
    }
  }

  public function buscarConversasRecentes()
  {
    $response = new Response;
    if (empty($_SESSION['usuario'])) {
      $response->sucesso = false;
      $response->descricao = "É necessário estar logado para realizar esta ação.";
      $response->enviar();
    } else {
      $chat = new Chat;
      $chat->participante = $_SESSION['usuario']['id'];
      $conversas = $chat->buscarConversasRecentesUsuario();

      $response->dados = $conversas;
      $response->enviar();
    }
  }

  public function buscarConversasSeguindo()
  {
    $response = new Response;
    if (empty($_SESSION['usuario'])) {
      $response->sucesso = false;
      $response->descricao = "É necessário estar logado para realizar esta ação.";
      $response->enviar();
    } else {
      $chat = new Chat;
      $chat->participante = $_SESSION['usuario']['id'];
      $conversas = $chat->buscarSeguidoresSemConversa();

      $response->dados = $conversas;
      $response->enviar();
    }
  }
}
