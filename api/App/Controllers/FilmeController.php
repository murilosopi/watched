<?php

namespace App\Controllers;

use App\Models\Filme;
use App\Models\Interacoes;
use App\Models\Resenha;
use App\Resources\Response;
use App\Action;
use stdClass;

class FilmeController extends Action
{

  public function obterTodosFilmes()
  {

    $originResponse = $this->clientRequest('GET', 'https://api.themoviedb.org/3/trending/movie/week?language=pt');

    if (!empty($originResponse)) {
      $model = new Resenha();
      $filmes = array_map(function ($item) use ($model) {

        $model->filme = $item->id;

        $filme = new stdClass();
        $filme->id = $item->id ?? null;
        $filme->titulo = $item->title ?? null;
        $filme->cartaz = "https://image.tmdb.org/t/p/w500/{$item->poster_path}" ?? null;
        $filme->nota = $model->obterNotaFilme()['nota'] ?? null;

        return $filme;
      }, $originResponse->results);
    } else {
      $response = new Response;
      $response->erro('Ocorreu um erro ao buscar informações');
    }

    if (isset($_SESSION['usuario'])) {
      $interacoesModel = new Interacoes();
      $interacoesModel->usuario = $_SESSION['usuario']['id'];

      foreach ($filmes as &$filme) {
        $interacoesModel->filme = $filme->id;
        $interacoes = $interacoesModel->consultarInteracoesFilme();
        $filme = array_merge((array)$filme, $interacoes);
      }
    }

    $response = new Response();
    $response->sucesso = !empty($filmes);
    if ($response->sucesso) $response->dados = $filmes;
    $response->enviar();
  }

  public function obterInformacoesFilme()
  {
    $filmeModel = new Filme();
    $filmeModel->id = $_GET['id'] ?? 0;
    $filme = $filmeModel->obterInformacoesFilme();

    $response = new Response();
    $response->sucesso = !empty($filme);
    if ($response->sucesso) $response->dados = $filme;
    $response->enviar();
  }

  public function obterDetalhesFilme()
  {
    $filmeModel = new Filme();
    $filmeModel->id = $_GET['id'] ?? 0;
    $filme = $filmeModel->obterDetalhesFilme();

    $response = new Response();
    $response->sucesso = !empty($filme);
    if ($response->sucesso) $response->dados = $filme;
    $response->enviar();
  }
}
