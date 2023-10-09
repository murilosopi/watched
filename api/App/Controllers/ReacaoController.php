<?php
  namespace App\Controllers;
  use App\Models\Usuario;
  use App\Models\Reacao;
  use App\Resources\Response;

  class ReacaoController {
    public function obterIconesReacoes() {
        $model = new Reacao();

        $reacoes = $model->obterIconesReacoes();

        $response = new Response();
        $response->sucesso = !empty($reacoes);
        if($response->sucesso) {
          $response->dados = $reacoes;
        }
        $response->enviar();
    }
  }
?>