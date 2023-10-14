<?php

namespace App\Controllers;

use App\Action;
use App\Resources\Response;
use App\Models\Genero;

class GenerosController extends Action
{
  public function obterGenerosFilme()
  {
    $filme = $_GET['id'] ?? 0;

    $generoModel = new Genero();
    $generos = $generoModel->obterNomesGenerosPorFilme($filme);

    $response = new Response();
    $response->sucesso = !empty($generos);
    if ($response->sucesso) $response->dados = $generos;
    $response->enviar();
  }
}
