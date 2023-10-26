<?php

namespace App\Controllers;

use App\Resources\Response;
use App\Action;
use App\Models\Postagem;

class PostagemController extends Action
{

  public function registrarPostagem() {
    $response = new Response();

    $uid = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : false;

    if($uid) {

      $texto = $_POST['postagem'] ?? false;

      $imagem = isset($_POST['imagem']) ? $_FILES['imagem'] : false;

      if(empty($texto) && empty($imagem)) {
        $response->erro("Não foi enviado nenhum texto ou imagem.");
      }

      $postagem = new Postagem();
      $postagem->texto = $texto;
      $postagem->usuario = $uid;
      $postagem->id = $postagem->novaPostagem();

      if($imagem) {
        $ext = explode('/', $imagem['type'])[1];
        $path = UPLOAD_PATH . "img/posts/{$uid}/{$postagem->id}.{$ext}";

        $movido = move_uploaded_file($imagem['uri'], $path);
        if($movido) {
          $postagem->imagem = $path;
          $postagem->adicionarImagem();
        }
      }
    } else {
      $response->erro("É necessário estar logado para registrar uma resenha");
    }
  }
}
