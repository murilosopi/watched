<?php

namespace App\Controllers;

use App\Action;
use App\Resources\Response;
use App\Models\Usuario;
use App\Models\Filme;
use App\Models\Interacoes;
use App\Models\Resenha;

class UsuarioController extends Action
{

  public function obterInformacoesPerfil()
  {
    $model = new Usuario();
    $model->username = $_GET['username'] ?? '';

    $usuario = $model->obterUsuarioPorUsername();

    if(!empty($usuario)) {
      
      $model->id = $usuario['id'];

      if(isset($_SESSION['usuario'])) {
        $model->seguidor = $_SESSION['usuario']['id'];

        $usuario['seguindo'] = $model->existeSeguidor();
      }

      $model->adicionarVisualizacaoPerfil();
    }

    $response = new Response();
    $response->sucesso = !empty($usuario);
    if ($response->sucesso) $response->dados = $usuario;

    $response->enviar();
  }

  public function obterEstatiscasPerfil()
  {

    $usuarioModel = new Usuario();
    $usuarioModel->id = $_GET['uid'] ?? 0;

    $resenhaModel = new Resenha();
    $resenhaModel->usuario = $_GET['uid'] ?? 0;

    $interacoesModel = new Interacoes();
    $interacoesModel->usuario = $_GET['uid'] ?? 0;


    $totais = [
      'seguidores' => (int)$usuarioModel->obterTotalSeguidores(),
      'seguindo' => (int)$usuarioModel->obterTotalSeguindo(),
      'resenhas' => (int)$resenhaModel->obterTotalResenhasUsuario(),
      'assistidos' => (int)$interacoesModel->consultarTotalAssistidosUsuario()
    ];

    $response = new Response();
    $response->sucesso = !empty($_GET['uid']);

    if ($response->sucesso) $response->dados = $totais;

    $response->enviar();
  }

  public function alterarSobreUsuario()
  {

    $response = new Response();

    if (isset($_SESSION['usuario'])) {
      $model = new Usuario();
      $model->id = $_SESSION['usuario']['id'];
      $model->sobre = $_POST['sobre'] ?? 0;

      $response->sucesso = $model->alterarSobre();
    } else {
      $response->sucesso = false;
      $response->descricao = 'Necessário estar autenticado para realizar esta alteração';
    }

    $response->enviar();
  }

  public function seguirUsuario() {
    $response = new Response;

    if (isset($_SESSION['usuario'])) {
      $usuario = new Usuario;
      $usuario->id = $_POST['uid'] ?? NULL;
      $usuario->seguidor = $_SESSION['usuario']['id'];

      $response->sucesso = $usuario->registrarSeguidor();
    } else {
      $response->erro('Necessário estar autenticado para realizar esta ação');
    }

    $response->enviar();
  }

  public function pararSeguirUsuario() {
    $response = new Response;

    if (isset($_SESSION['usuario'])) {
      $usuario = new Usuario;
      $usuario->id = $_POST['uid'] ?? NULL;
      $usuario->seguidor = $_SESSION['usuario']['id'];

      $response->sucesso = $usuario->removerSeguidor();
    } else {
      $response->erro('Necessário estar autenticado para realizar esta ação');
    }

    $response->enviar();
  }

  public function AtualizarAvatarPersonalizado() {
    $imagem = $_FILES['avatar'] ?? null;

    if(empty($imagem)) (new Response())->erro('O arquivo não foi enviado');
    if(empty($_SESSION['usuario'])) (new Response())->erro('Necessário estar autenticado para realizar esta ação');

    $diretorio = UPLOAD_PATH . "/{$_SESSION['usuario']['id']}";
    if(!file_exists($diretorio)) mkdir($diretorio, 0777, true);
    $ext = explode('/', $imagem['type'])[1];

    $nomeArquivo = "avatar_". date('ymd') .".{$ext}";

    move_uploaded_file($imagem['tmp_name'], "{$diretorio}/{$nomeArquivo}");

    
    $usuario = new Usuario;
    $usuario->id = $_SESSION['usuario']
  }
}
