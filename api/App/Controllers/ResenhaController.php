<?php

namespace App\Controllers;

use App\Action;
use App\Resources\Response;
use App\Models\Resenha;
use App\Models\Reacao;

class ResenhaController extends Action
{
  public function obterNotaFilme()
  {
    $resenhaModel = new Resenha();
    $resenhaModel->filme = $_GET['id'] ?? 0;
    $nota = $resenhaModel->obterNotaFilme();

    $r = new Response();
    $r->sucesso = !empty($nota);
    if ($r->sucesso) $r->dados = $nota;
    $r->enviar();
  }

  public function obterResenhasPorFilme()
  {
    $resenhaModel = new Resenha();
    $resenhaModel->filme = $_GET['filme'] ?? 0;
    $resenhaModel->offset = $_GET['offset'] ?? 0;
    $resenhaModel->limit = $_GET['limit'] ?? 0;

    $resenhas = $resenhaModel->obterTodasResenhasPorFilme();

    $response = new Response();
    $response->sucesso = !empty($resenhas);
    if ($response->sucesso) $response->dados = $resenhas;
    $response->enviar();
  }

  public function obterResenhasPorUsuario()
  {
    $resenhaModel = new Resenha();
    $resenhaModel->usuario = $_GET['uid'] ?? 0;
    $resenhaModel->offset = $_GET['offset'] ?? 0;
    $resenhaModel->limit = $_GET['limit'] ?? 0;

    $resenhas = $resenhaModel->obterTodasResenhasPorUsuario();

    $reacaoModel = new Reacao();
    foreach ($resenhas as &$resenha) {
      $reacaoModel->resenha = $resenha['id'];
      $resenha['reacao'] = $reacaoModel->obterReacaoResenha();
    }

    $response = new Response();
    $response->sucesso = !empty($resenhas);
    if ($response->sucesso) $response->dados = $resenhas;
    $response->enviar();
  }

  public function registrarResenha()
  {
    $response = new Response();

    if (empty($_SESSION['usuario'])) {
      $response->sucesso = false;
      $response->descricao = "É necessário estar logado para registrar uma resenha.";
      $response->enviar();
    }

    $resenha = new Resenha();
    $resenha->filme = $_POST['movie'] ?? 0;
    $resenha->usuario = $_SESSION['usuario']['id'];
    $resenha->titulo = $_POST['title'] ?? null;
    $resenha->descricao = $_POST['text'] ?? null;
    $resenha->reacao = $_POST['reaction'] ?? null;
    $resenha->notaAvaliacao = $_POST['rating'] ?? null;

    $id = $resenha->registrarResenha();
    $response->sucesso = !empty($id);

    $response->enviar();
  }

  public function existeResenhaFilmeUsuario()
  {
    $resenha = new Resenha();
    $resenha->filme = $_GET['filme'] ?? 0;
    $resenha->usuario = $_GET['usuario'] ?? 0;

    $total = $resenha->obterTotalResenhasUsuarioFilme();

    $response = new Response();
    $response->sucesso = !empty($total);
    $response->enviar();
  }
}
