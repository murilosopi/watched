<?php

namespace App\Controllers;

use App\Models\Interacoes;
use App\Resources\Response;

class InteracoesController
{

  public function alterarFilmeAssistido()
  {

    $model = new Interacoes();
    $model->filme = $_POST['filme'] ?? 0;
    $model->usuario = $_POST['usuario'] ?? 0;

    $interacoes = $model->consultarInteracoesFilme();

    if(empty($interacoes)) {
      $model->assistido = true;

      $model->registrarInteracaoFilme();
    } else {
      $model->alterarFilmeAssistido();
    }


    $response = new Response();
    $response->sucesso = !empty($filme);
    $response->enviar();
  }

  public function alterarFilmeCurtido()
  {

    $model = new Interacoes();
    $model->filme = $_POST['filme'] ?? 0;
    $model->usuario = $_POST['usuario'] ?? 0;

    $interacoes = $model->consultarInteracoesFilme();

    if(empty($interacoes)) {
      $model->curtido = true;

      $model->registrarInteracaoFilme();
    } else {
      $model->alterarFilmeCurtido();
    }


    $response = new Response();
    $response->sucesso = !empty($filme);
    $response->enviar();
  }

  public function alterarFilmeSalvo()
  {

    $model = new Interacoes();
    $model->filme = $_POST['filme'] ?? 0;
    $model->usuario = $_POST['usuario'] ?? 0;

    $interacoes = $model->consultarInteracoesFilme();

    if(empty($interacoes)) {
      $model->salvo = true;

      $model->registrarInteracaoFilme();
    } else {
      $model->alterarFilmeSalvo();
    }


    $response = new Response();
    $response->sucesso = !empty($filme);
    $response->enviar();
  }
}
