<?php

 namespace App\Controllers;
 use App\Models\Filme;
 use App\Resources\Response;

 class InteracoesController {

    public function InteracoesAssistido() {
      $InteracoesModel = new Filme();
      $InteracoesModel->id = $_POST['id'] ?? 0;

      $usuario = $_POST['usuario'] ?? 0;
      $assistido = $_POST['assistido'] ?? 0;

      $Interacoes = $InteracoesModel->InteracoesAssistido();

      $response = new Response();
      $response->sucesso = !empty($filme);
      if($response->sucesso) $response->dados = $filme;
      $response->enviar();
    }

    public function InteracoesCurtido() {
        $InteracoesModel = new Filme();
        $InteracoesModel->id = $_POST['id'] ?? 0;
  
        $usuario = $_POST['usuario'] ?? 0;
        $curtido = $_POST['curtido'] ?? 0;

  
        $Interacoes = $InteracoesModel->InteracoesCurtido();
  
        $response = new Response();
        $response->sucesso = !empty($filme);
        if($response->sucesso) $response->dados = $filme;
        $response->enviar();
      }

      public function InteracoesSalvo() {
        $InteracoesModel = new Filme();
        $InteracoesModel->id = $_POST['id'] ?? 0;
  
        $usuario = $_POST['usuario'] ?? 0;
        $salvo = $_POST['salvo'] ?? 0;
  
        $Interacoes = $InteracoesModel->InteracoesSalvo();
  
        $response = new Response();
        $response->sucesso = !empty($filme);
        if($response->sucesso) $response->dados = $filme;
        $response->enviar();
      }


    }
    

