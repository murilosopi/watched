<?php
  namespace App\Controllers;
  use App\Views\View;
  use App\Models\Usuario;
  use App\Models\Filme;

  class PesquisaController {
    public function telaPesquisaMobile() {
      session_start();
      View::render(
        'pesquisa-mobile',
        [
          'usuario' => isset($_SESSION['usuario']) ? $_SESSION['usuario'] : NULL,
          'rota' => isset($_GET['rota']) ? $_GET['rota'] : '/guia-filmes'
        ]
      );
    }

    public function pesquisarConteudo() {
      session_start();
      $idUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 0;
      $pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';  
      $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'nenhum';
      $filmes = [];
      $usuarios = [];

      if(!empty($pesquisa) && $filtro != 'filmes') {
        $usuario = new Usuario();
        $usuario->id = $idUsuario;
        $usuarios = $usuario->buscarUsuarios($pesquisa);
        
        foreach($usuarios as $idx => $usuario) {
          $usuarios[$idx] = $this->atribuiNumSeguindoSeguidores($usuario);
        }
      }
      
      if(!empty($pesquisa) && $filtro != 'usuarios') {
        $filme = new Filme();
        $filmes = $filme->buscarFilmes($pesquisa);
        
        if($idUsuario) {
          foreach ($filmes as $idx => $f) {
            $filme->id = $f['id'];
            
            $filmes[$idx]['curtido'] = $filme->filmeCurtidoPeloUsuario($idUsuario);
            $filmes[$idx]['assistido'] = $filme->filmeAssistidoPeloUsuario($idUsuario);
            $filmes[$idx]['salvo'] = $filme->filmeSalvoPeloUsuario($idUsuario);
         }
        }    
      }


      View::render(
        'pesquisa',
        [
          'pesquisa' => $pesquisa,
          'filtro' => $filtro,
          'usuarios' => $usuarios,
          'num_usuarios' => count($usuarios),
          'num_filmes' => count($filmes),
          'filmes' => $filmes,
          'num_resultados' => count($filmes) + count($usuarios),
          'usuario' => $idUsuario ? $_SESSION['usuario'] : NULL
          ]
      );
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
  }
?>