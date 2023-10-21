<?php

namespace App\Controllers;

use App\Action;
use App\Models\Usuario;
use App\Models\Reacao;
use App\Resources\Response;

class ReacaoController extends Action
{
  public function obterIconesReacoes()
  {
    $model = new Reacao();

    $reacoes = $model->obterIconesReacoes();

    $response = new Response();
    $response->sucesso = !empty($reacoes);
    if ($response->sucesso) {
      $response->dados = $reacoes;
    }
    $response->enviar();
  }
}
