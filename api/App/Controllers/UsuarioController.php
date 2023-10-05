<?php

namespace App\Controllers;

use App\Resources\Response;
use App\Models\Usuario;
use App\Models\Filme;
use App\Models\Interacoes;
use App\Models\Resenha;

class UsuarioController
{

  public function obterInformacoesPerfil()
  {
    $model = new Usuario();
    $model->username = $_POST['username'] ?? 0;

    $usuario = $model->obterUsuarioPorUsername();

    $response = new Response();
    $response->sucesso = !empty($usuario);
    if ($response->sucesso) $response->dados = $usuario;

    $response->enviar();
  }

  public function obterEstatiscasPerfil() {

    $usuarioModel = new Usuario();
    $usuarioModel->id = $_GET['uid'] ?? 0;

    $resenhaModel = new Resenha();
    $resenhaModel->idUsuario = $_GET['uid'] ?? 0;

    $interacoesModel = new Interacoes();
    $interacoesModel->usuario = $_GET['uid'] ?? 0;
    $interacoesModel->filme = $_GET['movie'] ?? 0;

    $totais = [
      'seguidores' => (int)$usuarioModel->obterTotalSeguidores(),
      'resenhas' => (int)$resenhaModel->obterTotalResenhasUsuario(),
      'assistidos' => (int)$interacoesModel->consultarTotalAssistidosUsuario()
    ];
    
    $response = new Response();
    $response->sucesso = !empty($_GET['uid']) && !empty($_GET['movie']);

    if($response->sucesso) $response->dados = $totais;

    $response->enviar();
    
  }
}
