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
}

?>