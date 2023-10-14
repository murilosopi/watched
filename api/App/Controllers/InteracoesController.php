<?php

namespace App\Controllers;

use App\Models\Interacoes;
use App\Resources\Response;
use App\Action;

class InteracoesController extends Action
{

  public function alterarFilmeAssistido()
  {

    $model = new Interacoes();
    $model->filme = $_POST['filme'] ?? 0;
    $model->usuario = $_SESSION['usuario']['id'];

    $existe = $model->existeInteracoesFilmeUsuario();

    if (!$existe) {
      $model->assistido = true;

      $sucesso = $model->registrarInteracaoFilme();
    } else {
      $sucesso = $model->alterarFilmeAssistido();
    }


    $response = new Response();
    $response->sucesso = $sucesso;
    $response->enviar();
  }

  public function alterarFilmeCurtido()
  {

    $model = new Interacoes();
    $model->filme = $_POST['filme'] ?? 0;
    $model->usuario = $_SESSION['usuario']['id'];

    $existe = $model->existeInteracoesFilmeUsuario();

    if (!$existe) {
      $model->curtido = true;

      $sucesso = $model->registrarInteracaoFilme();
    } else {
      $sucesso = $model->alterarFilmeCurtido();
    }


    $response = new Response();
    $response->sucesso = $sucesso;
    $response->enviar();
  }

  public function alterarFilmeSalvo()
  {

    $model = new Interacoes();
    $model->filme = $_POST['filme'] ?? 0;
    $model->usuario = $_SESSION['usuario']['id'];

    $existe = $model->existeInteracoesFilmeUsuario();

    if (!$existe) {
      $model->salvo = true;

      $sucesso = $model->registrarInteracaoFilme();
    } else {
      $sucesso = $model->alterarFilmeSalvo();
    }


    $response = new Response();
    $response->sucesso = $sucesso;
    $response->enviar();
  }

  public function buscarInteracoesFilme()
  {
    $model = new Interacoes();
    $model->filme = $_GET['id'] ?? 0;

    $interacoes = $model->obterTotaisPorFilme() ?? [];


    if (isset($_SESSION['usuario'])) {
      $model->usuario = $_SESSION['usuario']['id'];

      $interacoesUsuario = $model->consultarInteracoesFilme();

      if (!empty($interacoesUsuario)) {
        $interacoes = array_merge($interacoesUsuario, $interacoes);
      }
    }

    $response = new Response();
    $response->sucesso = !empty($_GET['id']);
    if ($response->sucesso) $response->dados = $interacoes;
    $response->enviar();
  }
}
