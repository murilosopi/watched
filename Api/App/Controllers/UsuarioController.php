<?php
  namespace App\Controllers;
  use App\Views\View;
  use App\Models\Usuario;
  use App\Models\Filme;
  use App\Models\Resenha;

  class UsuarioController {
    // Renderiza a tela de cadastro
    public function cadastro() {
      session_start();
      if(isset($_SESSION['usuario'])) {
        header('Location: /guia-filmes');
        die;
      }
      View::render(
        'sign-up',
        [
          'usuario' => isset($_GET['u']) ? $_GET['u'] : '',
          'nome' => isset($_GET['n']) ? $_GET['n'] : '',
          'email' => isset($_GET['e']) ? $_GET['e'] : '',
        ]
      );
    }

    // Renderiza a tela de login
    public function login() {
      session_start();
      if(isset($_SESSION['usuario'])) {
        header('Location: /guia-filmes');
        die;
      }
      View::render(
        'login',
        [
          'usuario' => isset($_GET['u']) ? $_GET['u'] : ''
        ]
      );
    }

    public function alterarFotoPerfil() {
      session_start();
      $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : NULL;
      $arquivo = isset($_FILES['img']) ? $_FILES['img'] : NULL;

      if($usuario && $arquivo) {
        if($arquivo['error']) {
          header('Location: meu-perfil?erro=upload');
          die;
        }
        
        if($arquivo['size'] > 5 * 1024 * 1024) {
          header('Location: meu-perfil?erro=tamanho');
          die;
        }

        if(is_bool(strpos($arquivo['type'], 'image'))) {
          header('Location: meu-perfil?erro=tipo');
          die;
        }
          
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        $novaFoto = "assets/img/users/{$usuario['id']}_{$usuario['username']}.$extensao";
        
        $sucesso = move_uploaded_file($arquivo['tmp_name'], $novaFoto);
        if($sucesso) {
          $usuarioObj = new Usuario();
          $usuarioObj->id = $usuario['id'];

          $fotoAntiga = ($usuarioObj->obterUsuarioPorId())['foto_perfil'];
          if($fotoAntiga != 'assets/img/users/default.svg' && $fotoAntiga != $novaFoto) {
            unlink($fotoAntiga);
          }

          $usuarioObj->fotoPerfil = $novaFoto;
          if($usuarioObj->atualizarFotoPerfil())
            $_SESSION['usuario']['foto_perfil'] = $novaFoto;

          header('Location: meu-perfil');
          die;
        }

        header('Location: meu-perfil?erro=upload');
        die;
      } 
      
      else {
        header('Location: erro');
      }
    }

    public function seguirPerfil() {
      session_start();
      $idUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 0;

      if($idUsuario && isset($_POST['id'])) {
        $rota = $_GET['rota'];
        $perfil = new Usuario();
        $perfil->id = $_POST['id'];

        $seguidores = $perfil->obterSeguidores();
        $idSeguidores = array_column($seguidores, 'id');

        if(!(in_array($idUsuario, $idSeguidores))) {
          $perfil->registrarSeguidor($idUsuario);
          header("Location: $rota");
        } else {
          header("Location: $rota&erro=seguir");
        }      
      }
      
      else {
        header('Location: login');
      }
    }

    public function pararSeguirPerfil() {
      session_start();
      $idUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 0;

      if($idUsuario && isset($_POST['id'])) {
        $rota = $_GET['rota'];
        $perfil = new Usuario();
        $perfil->id = $_POST['id'];

        $seguidores = $perfil->obterSeguidores();
        $idSeguidores = array_column($seguidores, 'id');

        if((in_array($idUsuario, $idSeguidores))) {
          $perfil->removerSeguidor($idUsuario);
          header("Location: $rota");
        } else {
          header("Location: $rota&erro=parar-seguir");
        }      
      }
      
      else {
        header('Location: erro');
      }
    }

    // Altera o texto de "sobre" do usuário e no sucesso retorna para a página do usuário logado
    public function alterarSobreUsuario() {
      session_start();
      
      $idUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 0;
      if($idUsuario) {        
        $usuario = new Usuario();
        $usuario->id = $idUsuario;

        $sobre = trim($_POST['sobre']);
        if(empty($sobre)) {
          header("Location: meu-perfil?erro=vazio");
          die;
        }
        
        $usuario->sobre = $sobre;
        
        if($usuario->alterarSobre()) {
          $_SESSION['usuario'] = $usuario->obterUsuarioPorId();
          header("Location: meu-perfil");
        }
      }

      else {
        header('Location: erro');
      }
    }

    // Renderiza as telas dos demais usuários, passando os dados necessários
    public function perfilUsuario() {
      session_start();
      $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : NULL;

      $perfil = new Usuario();
      $perfil->username = isset($_GET['u']) ? $_GET['u'] : '';
      $perfil = $perfil->obterUsuarioPorUsername();
      
      if($perfil == $usuario) {
        header("Location: meu-perfil");
        die;
      }
      
      if($perfil) { 
        $perfil = $this->atribuiNumSeguindoSeguidores($perfil);
        $filme = new Filme();
        $filmesAssistidos = $filme->obterFilmesAssistidosPorUsuario($perfil['id']);
        $filmesCurtidos = $filme->obterFilmesCurtidosPorUsuario($perfil['id']);
        $filmesAssistidos = $this->atribuirRelUsuario($filmesAssistidos);
        $filmesCurtidos = $this->atribuirRelUsuario($filmesCurtidos);
        
        $resenha = new Resenha();
        $resenha->idUsuario = $perfil['id'];

        View::render(
          'usuario', 
          [
            'perfil' => $perfil,
            'editavel' => false,
            'filmes' => [
              'curtidos' => $filmesCurtidos,
              'assistidos' => $filmesAssistidos,
            ],
            'num_assistidos' => count($filmesAssistidos),
            'num_resenhas' => count($resenha->obterTodasResenhasPorUsuario()),
            'usuario' => $usuario
          ]
        );
      }

      else {
        header('Location: erro');
      }
    }

    // Renderiza a tela de perfil do usuário logado
    public function meuPerfil() {
      session_start();
      
      $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : NULL;

      if($usuario) {
        $idUsuario = $_SESSION['usuario']['id'];

        $filme = new Filme();
        $filmesAssistidos = $filme->obterFilmesAssistidosPorUsuario($idUsuario);
        $filmesAssistidos = $this->atribuirRelUsuario($filmesAssistidos, $idUsuario);
        $filmesCurtidos = $filme->obterFilmesCurtidosPorUsuario($idUsuario);
        $filmesCurtidos = $this->atribuirRelUsuario($filmesCurtidos, $idUsuario);
        $filmesSalvos = $filme->obterFilmesSalvosPorUsuario($idUsuario);
        $filmesSalvos = $this->atribuirRelUsuario($filmesSalvos, $idUsuario);
        
        $resenha = new Resenha();
        $resenha->idUsuario = $idUsuario;

        View::render(
          'usuario', 
          [
            'perfil' => $this->atribuiNumSeguindoSeguidores($usuario),
            'editavel' => true,
            'filmes' => [
              'curtidos' => $filmesCurtidos,
              'assistidos' => $filmesAssistidos,
              'salvos' => $filmesSalvos
            ],
            'num_assistidos' => count($filmesAssistidos),
            'num_resenhas' => count($resenha->obterTodasResenhasPorUsuario()),
            'usuario' => $usuario
          ]
        );
      } 
      
      else {
        header("Location: login");
        die;
      }
    }


    private function atribuiNumSeguindoSeguidores(array $perfil) {
      $perfilObj = new Usuario();
      $perfilObj->id = isset($perfil['id']) ? $perfil['id'] : 0;
      $perfilObj->username = isset($perfil['username']) ? $perfil['username'] : '';

      $seguidores = $perfilObj->obterSeguidores();
      $seguindo = $perfilObj->obterSeguindo();
      
      $perfil['num_seguidores'] = count($seguidores);
      $perfil['num_seguindo'] = count($seguindo);

      $idUsuarioLogado = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 0;
      if($perfil['id'] != $idUsuarioLogado) {
        $perfil['seguido'] = in_array($idUsuarioLogado, array_column($seguidores, 'id'));
      }

      return $perfil;
    }


    private function atribuirRelUsuario($filmes) {
      $filme = new Filme();
      $idUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 0;

      foreach ($filmes as $idx => $f) {
        $filme->id = $f['id'];
        
        $filmes[$idx]['curtido'] = $filme->filmeCurtidoPeloUsuario($idUsuario);
        $filmes[$idx]['assistido'] = $filme->filmeAssistidoPeloUsuario($idUsuario);
        $filmes[$idx]['salvo'] = $filme->filmeSalvoPeloUsuario($idUsuario);
      }

      return $filmes;
    }

  }
?> 