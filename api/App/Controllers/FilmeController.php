<?php

namespace App\Controllers;

use App\Models\Filme;
use App\Models\Interacoes;
use App\Models\Resenha;
use App\Resources\Response;
use App\Action;

class FilmeController extends Action
{

  public function obterTodosFilmes()
  {

    $dados = $this->clientRequest('GET', 'https://api.themoviedb.org/3/trending/movie/day');

    if (!empty($dados)) {
      $model = new Resenha();
      $filmes = array_map(function ($item) use ($model) {

        $model->filme = $item->id;

        $filme = new \stdClass();
        $filme->id = $item->id ?? null;
        $filme->titulo = $item->title ?? null;
        $filme->cartaz = "https://image.tmdb.org/t/p/w500/{$item->poster_path}" ?? null;
        $filme->nota = $model->obterNotaFilme()['nota'] ?? null;

        return $filme;
      }, $dados->results);
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

  public function obterDetalhesFilme()
  {
  
    $id = $_GET['id'] ?? 0;

    $dados = $this->clientRequest('GET', "https://api.themoviedb.org/3/movie/{$id}");
    $credits = $this->clientRequest('GET', "https://api.themoviedb.org/3/movie/{$id}/credits");

    
    if(!empty($dados)) {
      $filme = [
        'tituloOriginal' => $dados->original_title,
        'anoLancamento' => date('Y', strtotime($dados->release_date)),
        'titulo' => $dados->title,
        'sinopse' => $dados->overview,
        'generos' => $dados->genres,
        'producao' => $dados->production_companies,
        'elenco' => array_slice($credits->cast, 0, 10),
        'cartaz' => "https://image.tmdb.org/t/p/w500/{$dados->poster_path}",
        'duracaoMin' => $dados->runtime
      ];
    } else {
      $response = new Response;
      $response->erro('Ocorreu um erro ao buscar informações');
    }

    $response = new Response();
    $response->sucesso = !empty($filme);
    if ($response->sucesso) $response->dados = $filme;
    $response->enviar();
  }

  public function obterInformacoesFilme()
  {
    $filme = new Filme();

    $id = $_GET['id'] ?? 0;

    $dados = $this->clientRequest('GET', "https://api.themoviedb.org/3/movie/{$id}");

    
    if(!empty($dados)) {

      $filme = new \stdClass();
      $filme->id = $dados->id;
      $filme->tituloOriginal = $dados->original_title;
      $filme->anoLancamento = date('Y', strtotime($dados->release_date));
      $filme->titulo = $dados->title;
      $filme->sinopse = $dados->overview;
      $filme->cartaz = "https://image.tmdb.org/t/p/w500/{$dados->poster_path}";

      $model = new Resenha();
      $model->filme = $dados->id;
      $filme->nota = $model->obterNotaFilme()['nota'] ?? 0;

      if (isset($_SESSION['usuario'])) {
        $interacoesModel = new Interacoes();
        $interacoesModel->usuario = $_SESSION['usuario']['id'];
  
        $interacoesModel->filme = $filme->id;
        $interacoes = $interacoesModel->consultarInteracoesFilme();
        $filme = array_merge((array)$filme, $interacoes);
      }
    } else {
      $response = new Response;
      $response->erro('Ocorreu um erro ao buscar informações');
    }

    $response = new Response();
    $response->sucesso = !empty($filme);
    if ($response->sucesso) $response->dados = $filme;
    $response->enviar();
  }

  public function obterEstatisticasFilmes() {
    $resenha = new Resenha;
    $resenha->filme = $_GET['id'] ?? 0;

    $avaliacoes = $resenha->avaliacoesPorFilme();
    $totalGeralNotas = count($avaliacoes);
    $totaisNotas = [0, 0, 0, 0, 0];
    foreach($avaliacoes as $a) {
      $totaisNotas[round($a['nota'])-1]++;
    }
    $avaliacoes = array_map(function($avaliacao) use ($totalGeralNotas) {
      return [
        'total' => $avaliacao,
        'porcentagem' => $totalGeralNotas == 0 ? 0: $avaliacao / $totalGeralNotas * 100
      ];
    }, $totaisNotas);

    $reacoes = $resenha->reacaoPorFilme();
    $totalGeralReacoes = array_sum(array_column($reacoes, 'total'));
    $reacoes = array_map(function($reacao) use ($totalGeralReacoes) {
      return array_merge([
        'porcentagem' => $totalGeralReacoes == 0 ? 0 : $reacao['total'] / $totalGeralReacoes * 100
      ], $reacao);
    }, $reacoes);

    $response = new Response;
    $response->dados = [
      'avaliacao' => $avaliacoes,
      'reacao' => $reacoes
    ];
    $response->enviar();    
  }
}
