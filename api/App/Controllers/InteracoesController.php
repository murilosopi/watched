<?php

 namespace App\Controllers;
 use App\Models\Filme;
 use App\Resources\Response;

 class InteracoesController {

    public function obterAssistidoPorFilme() {
      
      $InteracoesModel = new Interacoes();
      $InteracoesModel->filme = $_POST['filme'] ?? 0;

      $usuario = $_POST['usuario'] ?? 0;
      $assistido = $_POST['assistido'] ?? 0;

      $Interacoes = $InteracoesModel->InteracoesAssistido($usuario);

      $response = new Response();
      $response->sucesso = !empty($filme);
      if($response->sucesso) $response->dados = $filme;
      $response->enviar();
    }

     public function obterCurtiidoPorFilme() {
      $InteracoesModel = new Interacoes();
      $InteracoesModel->filme = $_POST['filme'] ?? 0;
  
      $usuario = $_POST['usuario'] ?? 0;
      $curtido = $_POST['curtido'] ?? 0;

  
      $Interacoes = $InteracoesModel->InteracoesCurtido($usuario);
  
      $response = new Response();
      $response->sucesso = !empty($filme);
      if($response->sucesso) $response->dados = $filme;
      $response->enviar();
      }

      public function obterSalvoPorFilme() {
      $InteracoesModel = new Interacoes();
      $InteracoesModel->filme = $_POST['filme'] ?? 0;
  
      $usuario = $_POST['usuario'] ?? 0;
      $salvo = $_POST['salvo'] ?? 0;
  
      $Interacoes = $InteracoesModel->InteracoesSalvo($usuario);
  
      $response = new Response();
      $response->sucesso = !empty($filme);
      if($response->sucesso) $response->dados = $filme;
      $response->enviar();
      }


    }
    

