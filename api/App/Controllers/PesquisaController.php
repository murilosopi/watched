<?php

namespace App\Controllers;

use App\Models\Interacoes;
use App\Models\Resenha;
use App\Models\Usuario;
use App\Action;
use App\Resources\Response;

class PesquisaController extends Action
{
  public function pesquisarFilmes()
  {
    $pesquisa = $_GET['pesquisa'];
    $paginaAtual = $_GET['pagina'] ?? 1;

    $params = [
      'include_adult' => false,
      'language' => 'pt-BR',
      'page' => $paginaAtual,
      'query' => $pesquisa
    ];
    $dados = $this->clientRequest('GET', 'https://api.themoviedb.org/3/search/movie', $params);

    if (!empty($dados)) {
      $model = new Resenha();
      $filmes = array_map(function ($item) use ($model, $paginaAtual) {

        $model->filme = $item->id;

        $filme = new \stdClass();
        $filme->id = $item->id ?? null;
        $filme->titulo = $item->title ?? null;
        $filme->relevancia = $item->popularity ?? null;
        $filme->data = $item->release_date ?? null;
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
    $response->dados = [
      'filmes' => $filmes ?? [],
      'proximaPagina' => $dados->total_pages == $paginaAtual ? false : $paginaAtual+1
    ];
    $response->enviar();
  }

  public function pesquisarUsuarios()
  {
    $pesquisa = $_GET['pesquisa'];

    $usuario = new Usuario();
    $usuario->nome = $pesquisa;
    $usuario->username = $pesquisa;
    $usuario->sobre = $pesquisa;
    $usuario->id = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 0;

    $resultados = $usuario->buscarUsuarios();

    $response = new Response();
    $response->dados = $resultados ?? [];
    $response->enviar();
  }
}
