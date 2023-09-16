<?php
namespace App\Controllers;
use App\Resources\Response;
use App\Models\Resenha;

class ResenhaController {
  public function obterNotaFilme() {
    $resenhaModel = new Resenha();
    $resenhaModel->idFilme = $_GET['id'] ?? 0;
    $nota = $resenhaModel->obterNotaFilme();

    $r = new Response();
    $r->sucesso = !empty($nota);
    if($r->sucesso) $r->dados = $nota;
    $r->enviar();
  }

  public function obterResenhasPorFilme() {
    $resenhaModel = new Resenha();
    $resenhaModel->idFilme = $_GET['filme'] ?? 0;
    $resenhaModel->offset = $_GET['offset'] ?? 0;
    $resenhaModel->limit = $_GET['limit'] ?? 0; 

    $resenhas = $resenhaModel->obterTodasResenhasPorFilme();

    $response = new Response();
    $response->sucesso = !is_array($resenhas);
    if ($response->sucesso) $response->dados = $resenhas;
    $response->enviar();
  }

}

?>