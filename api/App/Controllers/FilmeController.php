<?php
  namespace App\Controllers;
  use App\Models\Filme;
  use App\Resources\Response;

  class FilmeController {

    public function obterTodosFilmes() {

      $filmeModel = new Filme();
      $filmeModel->offset = $_GET['offset'] ?? 0;
      $filmeModel->limit = $_GET['limit'] ?? 0;

      $filmes = $filmeModel->obterTodosFilmes();

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

    public function obterConsultarInteracoes() {

      $filmeModel = new Filme();
      $filmeModel->id  = $_POST['id'] ?? 0;

      $idUsuario = $_POST['usuario'] ?? 0;
      
      $filme = $filmeModel->ObterFilmePorUsuario($usuario);
      
      $response = new Response();
      $response->sucesso = !empty($filme);
      if($response->sucesso) $response->dados = $filme;
      $response->enviar();
    }
  }




?> 