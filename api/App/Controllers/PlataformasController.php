<?php

namespace App\Controllers;

use App\Action;
use App\Resources\Response;
use App\Models\Plataforma;

class PlataformasController extends Action
{
  public function obterPlataformasFilme()
  {
    $filme = $_GET['id'] ?? 0;

    $dados = $this->clientRequest('GET', "https://api.themoviedb.org/3/movie/{$filme}/watch/providers");
    
    $plataformas = [];

    if(!empty($dados->results->BR)) {
      $dados = $dados->results->BR;

      $plataformas = [
        'buy' => $dados->buy ?? [],
        'rent' => $dados->rent ?? [],
        'flatrate' => $dados->flatrate ?? []
      ];

      foreach($plataformas as &$modalidade) {

        foreach($modalidade as &$plataforma) {
          $plataforma = [
            'id' => $plataforma->provider_id,
            'name' => $plataforma->provider_name,
            'icon' => 'https://www.themoviedb.org/t/p/original'.$plataforma->logo_path,
          ];
        }

      }
    }

    $response = new Response();
    $response->sucesso = !empty($plataformas);
    if ($response->sucesso) $response->dados = $plataformas;
    $response->enviar();
  }
}
