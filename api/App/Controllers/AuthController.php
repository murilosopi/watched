<?php

namespace App\Controllers;

use App\Action;
use App\Models\Auth;
use App\Resources\Email;
use App\Resources\Response;

class AuthController extends Action
{
  private Auth $authModel;

  public function __construct()
  {
    parent::__construct();
    $this->authModel = new Auth();
  }

  public function cadastrarUsuario()
  {
    $nome = $_POST['nome'] ?? NULL;
    $email = $_POST['email'] ?? NULL;
    $senha = $_POST['senha'] ?? NULL;
    $username = $_POST['user'] ?? NULL;

    $response = new Response();

    if (isset($nome, $email, $senha, $username)) {

      $this->authModel
        ->__set('nome', strtolower($nome))
        ->__set('email', strtolower($email))
        ->__set('senha', password_hash($senha, PASSWORD_BCRYPT))
        ->__set('username', strtolower($username));

      $cadastroValido = !$this->authModel->cadastroExistente();
      if ($cadastroValido) {
        $this->authModel->cadastrarUsuario();
      } else {
        $response->erro('Outro usuário já cadastrado com esse e-mail e/ou username.');
      }
    }

    $response->sucesso = $cadastroValido ?? false;
    $response->enviar();
  }

  public function autenticarUsuario()
  {
    $username = $_POST['usuario'] ?? NULL;
    $senha = $_POST['senha'] ?? NULL;

    if (isset($username, $senha)) {
      $this->authModel
        ->__set('username', $username)
        ->__set('senha', $senha);

      $usuario = $this->authModel->obterUsuarioLogin();

      if (!empty($usuario) && password_verify($senha, $usuario['senha'])) {

        if ($usuario['status'] == 0) {
          $this->authModel->id = $usuario['id'];
          $this->authModel->token = $this->gerarTokenAleatorio();

          if(empty($usuario['token'])) {
            $this->authModel->registrarToken();
          } else {
            $this->authModel->atualizarToken();
          }

          $email = new Email;
          $email->setDestinatario($usuario['email']);
          $email->setAssunto('Verificação de sua conta Watched');
          $email->setConteudo("Não compartilhe esse token com ninguém! Token: {$this->authModel->token}");
          $email->enviar();

          $response = new Response();
          $response->erro('validacao');
        }


        $_SESSION['usuario'] = [
          'id' => $usuario['id'],
          'nome' => $usuario['nome'],
          'username' => $usuario['username'],
          'sobre' => $usuario['sobre'],
        ];

        $this->authModel->id = $usuario['id'];
        $this->authModel->atualizarAcesso();
      }
    }

    $response = new Response();
    $response->sucesso = !empty($_SESSION['usuario']);

    if ($response->sucesso) $response->dados = $_SESSION['usuario'];
    $response->enviar();
  }

  public function autenticarToken() {
    $username = $_POST['usuario'] ?? NULL;
    $senha = $_POST['senha'] ?? NULL;
    $token = $_POST['token'] ?? NULL;

    if (isset($username, $senha, $token)) {
      $this->authModel
        ->__set('username', $username)
        ->__set('senha', $senha)
        ->__set('token', $token);

      $usuario = $this->authModel->obterUsuarioLogin();

      if (!empty($usuario) && password_verify($senha, $usuario['senha'])) {
        $this->authModel->id = $usuario['id'];

        $tokenValido = $this->authModel->existeToken();

        if($tokenValido) {
          $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'nome' => $usuario['nome'],
            'username' => $usuario['username'],
            'sobre' => $usuario['sobre'],
          ];
  
          $this->authModel->atualizarAcesso();
        }
      }
    }

    $response = new Response();
    $response->sucesso = !empty($_SESSION['usuario']);

    if ($response->sucesso) $response->dados = $_SESSION['usuario'];
    $response->enviar();
  }

  public function checarAcessoUsuario()
  {
    $response = new Response();
    $response->sucesso = !empty($_SESSION['usuario']);
    if ($response->sucesso) {
      $response->dados = $_SESSION['usuario'];

      $this->authModel->id = $_SESSION['usuario']['id'];
      $this->authModel->atualizarAcesso();
    }
    $response->enviar();
  }

  public function logoutUsuario()
  {
    unset($_SESSION['usuario']);

    $response = new Response();
    $response->sucesso = !isset($_SESSION['usuario']);
    $response->enviar();
  }

  private function gerarTokenAleatorio($length = 5)
  {
    return strtoupper(bin2hex(random_bytes($length)));
  }
}
