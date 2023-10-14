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

    $plataformaModel = new Plataforma;
    $plataformas = $plataformaModel->obterPlataformasPorFilme($filme);

    $response = new Response();
    $response->sucesso = !empty($plataformas);
    if ($response->sucesso) $response->dados = $plataformas;
    $response->enviar();
  }
}
