<?php
  namespace App\Controllers;
  use App\Models\Usuario;
  use App\Models\Auth;
  use App\Resources\Response;

  class AuthController {
    private Auth $authModel;

    public function __construct()
    {
      $this->authModel = new Auth();
    }

    public function cadastrarUsuario() {
      $nome = $_POST['nome'] ?? NULL;
      $email = $_POST['email'] ?? NULL;
      $senha = $_POST['senha'] ?? NULL;
      $username = $_POST['user'] ?? NULL;


      if(isset($nome, $email, $senha, $username)) {

        $this->authModel
          ->__set('nome', $nome)
          ->__set('email', $email)
          ->__set('senha', $senha)
          ->__set('username', $username);  
          
        $cadastroValido = !$this->authModel->cadastroExistente();
        if($cadastroValido) {
          $this->authModel->cadastrarUsuario();
        }  
      }
      
      $response = new Response();
      $response->sucesso = $cadastroValido ?? false;
      $response->enviar();
    }
    
    public function autenticarUsuario() {
      $username = $_POST['usuario'] ?? NULL; 
      $senha = $_POST['senha'] ?? NULL;
      
      if(isset($username, $senha)) { 
        $this->authModel
        ->__set('username', $username)
        ->__set('senha', $senha);
        
        
        $_SESSION['usuario'] = $this->authModel->obterUsuarioLogin();
      }

      $response = new Response();
      $response->sucesso = !empty($_SESSION['usuario']);
      
      if($response->sucesso) $response->dados = $_SESSION['usuario'];
      $response->enviar();
    }

    public function logoutUsuario() {
      unset($_SESSION['usuario']);

      $response = new Response();
      $response->sucesso = !isset($_SESSION['usuario']);
      $response->enviar();
    }
  }
?>