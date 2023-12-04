<?php

namespace App\Controllers;

use App\Resources\Response;
use App\Action;
use App\Models\Postagem;

class PostagemController extends Action
{

  public function registrarPostagem()
  {
    $response = new Response();

    $uid = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : false;

    if ($uid) {

      $texto = $_POST['postagem'] ?? false;

      $imagem = isset($_POST['imagem']) ? $_FILES['imagem'] : false;

      if (empty($texto) && empty($imagem)) {
        $response->erro("Não foi enviado nenhum texto ou imagem.");
      }

      $postagem = new Postagem();
      $postagem->texto = $texto;
      $postagem->usuario = $uid;
      $postagem->id = $postagem->novaPostagem();

      if ($imagem) {
        $ext = explode('/', $imagem['type'])[1];

        $path = "img/posts/{$uid}/{$postagem->id}.{$ext}";

        $movido = move_uploaded_file($imagem['uri'], UPLOAD_PATH . $path);
        if ($movido) {
          $postagem->imagem = $path;
          $postagem->adicionarImagem();
        }
      }

      $response->sucesso = $postagem->id !== false;
      $response->enviar();
    } else {
      $response->erro("É necessário estar logado para registrar uma resenha");
    }
  }

  public function buscarTodasPostagens()
  {
    $pagina = (int)($_GET['pagina'] ?? 1);

    $postagem = new Postagem;
    $postagem->limit = 15;
    $postagem->offset = ($pagina - 1) * 15;
    if(isset($_SESSION['usuario'])) {
      $postagem->usuario = $_SESSION['usuario']['id'];
    }

    $totalPaginas = ceil($postagem->obterTotalPostagems() / $postagem->limit);
    $resultados = $postagem->buscarPostagens();

    $response = new Response();

    $response->dados = [
      'postagens' => empty($resultados) ? [] : $resultados,
      'pagina' => $pagina,
      'totalPaginas' => $totalPaginas
    ];


    $response->enviar();
  }

  public function buscarPostagensRecentes()
  {

    $postagem = new Postagem;

    $postagem->id = (int)($_GET['id'] ?? 0);

    if(isset($_SESSION['usuario'])) {
      $postagem->usuario = $_SESSION['usuario']['id'];
    }

    $resultados = $postagem->buscarPostagens();

    $response = new Response();
    $response->dados = empty($resultados) ? [] : $resultados;


    $response->enviar();
  }

  public function registrarVoto()
  {
    $response = new Response;

    if(isset($_SESSION['usuario'])) {
      $postagem = new Postagem;
      $postagem->id = (int)($_POST['id'] ?? 0);
      $postagem->voto = $_POST['voto'] ?? null;
      $postagem->usuario = $_SESSION['usuario']['id'];
      
      if ($postagem->voto != 'U' && $postagem->voto != 'D') {
        $response->erro("Voto inválido.");
      }
      
      $existeVoto = $postagem->existeVoto();
      
      if($existeVoto) {
        $response->sucesso = $postagem->atualizarVoto();
      } else {
        $response->sucesso = $postagem->registrarVoto();
      }

      $response->enviar();
    } else {
      $response->erro("É necessário estar logado para realizar esta ação.");
    }
  }

  public function removerVoto()
  {
    $response = new Response;

    if(isset($_SESSION['usuario'])) {
      $postagem = new Postagem;
      $postagem->id = (int)($_POST['id'] ?? 0);
      $postagem->usuario = $_SESSION['usuario']['id'];

      $response->sucesso = $postagem->deletarVoto();

      $response->enviar();
    } else {
      $response->erro("É necessário estar logado para realizar esta ação.");
    }
  }

  public function obterPostagensUsuario() {

    $postagem = new Postagem;
    $postagem->usuario = $_GET['uid'] ?? 0;

    $usuarioLogado = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 0;

    $postagens = $postagem->obterPostagensUsuario($usuarioLogado);

    $response = new Response;
    $response->sucesso = !empty($postagens);
    if($response->sucesso) $response->dados = $postagens;
    $response->enviar();
  }
}
