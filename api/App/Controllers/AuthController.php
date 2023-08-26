<?php
  namespace App\Controllers;
  use App\Models\Usuario;
  use App\Models\Auth;
  use App\Resources\Response;

  class AuthController {
    private Usuario $usuarioModel;
    private Auth $authModel;

    public function __construct()
    {
      $this->usuarioModel = new Usuario();
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

    // Realiza as verificações de dados necessárias e cadastra o usuário
    public function autenticarCadastro() {
      $nomeCadastro = trim($_POST['nome']);
      $usernameCadastro = strtolower(trim($_POST['username']));
      $emailCadastro = trim($_POST['email']);
      $confSenhaCadastro = trim($_POST['confirme_senha']);
      $senhaCadastro = $_POST['senha'];

      $cond = (
        empty($nomeCadastro) ||
        empty($usernameCadastro) ||
        empty($emailCadastro) ||
        empty($confSenhaCadastro) ||
        empty($senhaCadastro)
      );

      if($cond) {
        header(
          "Location: cadastro?erro=vazio" . 
          (!empty($nomeCadastro) ? "&n=$nomeCadastro" : '') .
          (!empty($usernameCadastro) ? "&u=$usernameCadastro" : '') .
          (!empty($emailCadastro) ? "&e=$emailCadastro" : '')
        );
        die;
      }

      $usuario = new Usuario();
      $usuario->nome = $nomeCadastro;
      $usuario->username = $usernameCadastro;
      $usuario->email = $emailCadastro;
      $usuario->senha = md5($senhaCadastro);
      
      // Verifica se há outro usuário com o mesmo email
      if($usuario->obterUsuarioPorEmail()) {
        header("Location: cadastro?erro=email&n=$usuario->nome&u=$usuario->username");
        die;
      }

      // Verifica se há outro usuário com o mesmo username
      if($usuario->obterUsuarioPorUsername()) {
        header("Location: cadastro?erro=username&n=$usuario->nome&e=$usuario->email");
        die;
      }
      
      // Confirma se as senhas são iguais
      if($usuario->senha != md5($confSenhaCadastro)) {
        header("Location: cadastro?erro=senhal&n=$usuario->nome&u=$usuario->username&e=$usuario->email");
        die;
      } 

      if($usuario->cadastrarUsuario()) {
        header("Location: login?u=$usuario->username");
      }
    }

    // Autentica o login e inicia a sessão para armazenar os dados do usuário
    public function autenticarLogin() {
      $usuarioLogin = trim($_POST['usuario']);
      $senhaLogin = $_POST['senha'];
      
      if(empty($usuarioLogin) || empty($senhaLogin)) {
        header("Location: login?erro=vazio" . (!empty($usuarioLogin) ? "&u=$usuarioLogin" : ''));
        die;
      }

      $usuario = new Usuario();
      $usuario->username = $usuarioLogin;
      $usuario->senha = md5($senhaLogin);
      $usuario = $usuario->obterUsuarioLogin();
      
      if($usuario) {
        session_start();
        $_SESSION['usuario'] = $usuario;
        header("Location: /guia-filmes");
        die;
      } 
      else {
        header("Location: login?erro=autenticacao&u=$usuarioLogin");
        die;
      }
    }

    // Realiza a destruição da sessão e retorna para a home
    public function logout() {
      session_start();
      session_destroy();
      header('Location: /guia-filmes');
    }
  }
?>