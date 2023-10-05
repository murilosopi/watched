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
    $response->sucesso = !empty($resenhas);
    if ($response->sucesso) $response->dados = $resenhas;
    $response->enviar();
  }

  public function obterResenhasPorUsuario() {
    $resenhaModel = new Resenha();
    $resenhaModel->idUsuario = $_GET['uid'] ?? 0;
    $resenhaModel->offset = $_GET['offset'] ?? 0;
    $resenhaModel->limit = $_GET['limit'] ?? 0; 

    $resenhas = $resenhaModel->obterTodasResenhasPorUsuario();

    $response = new Response();
    $response->sucesso = !empty($resenhas);
    if ($response->sucesso) $response->dados = $resenhas;
    $response->enviar();
  }

  public function registrarResenha() {
    $response = new Response();

    if(empty($_SESSION['usuario'])) {
      $response->sucesso = false;
      $response->descricao = "É necessário estar logado para registrar uma resenha.";
      $response->enviar();
    }

    $resenha = new Resenha();
    $resenha->idFilme = $_POST['movie'] ?? 0;
    $resenha->idUsuario = $_SESSION['usuario']['id'];
    $resenha->titulo = $_POST['title'] ?? null;
    $resenha->descricao = $_POST['text'] ?? null;
    $resenha->notaAvaliacao = $_POST['rating'] ?? null;
   
    $response->sucesso = $resenha->registrarResenha();
    $response->enviar();

  }
}

?>