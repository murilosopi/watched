<?php
  namespace App\Controllers;
  use App\Models\Filme;
use App\Models\Interacoes;
use App\Resources\Response;

  class FilmeController {

    public function obterTodosFilmes() {

      if(isset($_SESSION['usuario'])) {
        $model = new Interacoes();
        $model->offset = $_GET['offset'] ?? 0;
        $model->limit = $_GET['limit'] ?? 0;
        $model->usuario = $_SESSION['usuario']['id'];
  
        $filmes = $model->obterTodosFilmes();
      } else {
        $model = new Filme();
        $model->offset = $_GET['offset'] ?? 0;
        $model->limit = $_GET['limit'] ?? 0;
  
        $filmes = $model->obterTodosFilmes();
      }

      $response = new Response();
      $response->sucesso = !empty($filmes);
      if($response->sucesso) $response->dados = $filmes;
      $response->enviar();
    }

    public function obterInformacoesFilme() {
      $filmeModel = new Filme();
      $filmeModel->id = $_GET['id'] ?? 0;
      $filme = $filmeModel->obterInformacoesFilme();
  
      $response = new Response();
      $response->sucesso = !empty($filme);
      if($response->sucesso) $response->dados = $filme;
      $response->enviar();
    }

    public function obterDetalhesFilme() {
      $filmeModel = new Filme();
      $filmeModel->id = $_GET['id'] ?? 0;
      $filme = $filmeModel->obterDetalhesFilme();
  
      $response = new Response();
      $response->sucesso = !empty($filme);
      if($response->sucesso) $response->dados = $filme;
      $response->enviar();
    }
  }




?> 