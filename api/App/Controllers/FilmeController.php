<?php
  namespace App\Controllers;
  use App\Models\Filme;
  use App\Models\Resenha;
  use App\Models\Usuario;
  use App\Models\Plataforma;
  use App\Models\Genero;
  use App\Action;

  class FilmeController extends Action {
    // carrega a view do filme e os dados necessários
    public function sobreFilme() {
      $filmeModel = new Filme();
      $filmeModel->id = isset($_GET['id']) ? $_GET['id'] : 0;
      $filme = $filmeModel->obterFilmePorId();
      
      if($filme) {
        session_start();
        $genero = new Genero();
        $plataforma = new Plataforma();
        $resenha = new Resenha();
        $resenha->idFilme = $filme['id'];
      
        $idUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 0;
        if($idUsuario) {
          $resenha->idUsuario = $idUsuario;

          $filme['assistido'] = $filmeModel->filmeAssistidoPeloUsuario($idUsuario);
          $filme['curtido'] = $filmeModel->filmeCurtidoPeloUsuario($idUsuario);
          $filme['avaliado'] = $resenha->obterResenhaPorFilmeUsuario();
          $filme['salvo'] = $filmeModel->filmeSalvoPeloUsuario($idUsuario);
        } 
        else {
          $filme['assistido'] = false;
          $filme['curtido'] = false;
          $filme['avaliado'] = false;
          $filme['salvo'] = false;
        }

        $filme['elenco'] = explode(';', $filme['elenco']);

        $dados = [
          'filme' => $filme,
          'resenhas' => $resenha->obterTodasResenhasPorFilme($filme['id']),
          'plataformas' => $plataforma->obterPlataformasPorFilme($filme['id']),
          'generos' => $genero->obterNomesGenerosPorFilme($filme['id']),
          'usuario' => $idUsuario ? $_SESSION['usuario'] : NULL
        ];

        $this->retornarResposta($dados);
      } 

      else {
        // View::render('erro');
      }
    }

    // Captura os dados da resenha e faz inserção e deleção de dados das tabelas referentes à resenha e filme
    public function criarResenha() {
      session_start();

      $idUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 0;
      if($idUsuario)  {
        // Obtém todos os dados do formulário
        $idFilme = $_POST['id-filme'];
        $titulo = trim($_POST['titulo']);
        $curtiu = $_POST['curtiu'];
        $descricao = trim($_POST['descricao']);
        $notaAvaliacao = $_POST['avaliacao'];
        
        // Verifica se os campos obrigatórios foram preenchidos
        if(empty($descricao)) {
          header("Location: sobre-filme?id={$idFilme}&erro=vazio#section-form-review");
          die;
        } 

        // Registrar resenha no banco de dados
        $resenha = new Resenha();
        $resenha->idUsuario = $idUsuario;
        $resenha->idFilme = $idFilme;
        $resenha->titulo = empty($titulo) ? NULL : $titulo;
        $resenha->descricao = $descricao;
        $resenha->notaAvaliacao = $notaAvaliacao;
        $resenha->registrarResenha();
        

        
        // Marca o filme como assistido para o usuário logado, caso já não esteja marcado
        $filme = new filme();
        $filme->id = $idFilme;
        if(!$filme->filmeAssistidoPeloUsuario($idUsuario)) {
          $filme->adicionarFilmeAosAssistidos($idUsuario);
          $filme->atualizarNumAssistidos();
        }

        // Marca ou desmarca a curtida de um usuário para um filme
        if($curtiu && !$filme->filmeCurtidoPeloUsuario($idUsuario)) {
          $filme->adicionarCurtidaAoFilme($idUsuario);
          $filme->atualizarNumCurtidas();
        } else if(!$curtiu) {
          $filme->removerCurtidaDoFilme($idUsuario);
          $filme->atualizarNumCurtidas();
        }

        // Atualiza a média de avaliação do filme
        $filme->atualizarNotaAvaliacao();

        header("Location: sobre-filme?id={$idFilme}");
        die;
      } 

      else {
        View::render('erro');
      }
    }

    // Marca a curtida de um filme por um usuário logado, caso já tenha sido marcada
    public function marcarCurtida() {
      session_start();

      $idFilme = isset($_POST['id']) ? $_POST['id'] : 0;
      if($idFilme) {
        $filme = new filme();
        $filme->id= $idFilme;
        $rotaOrigem = isset($_GET['rota']) ? $_GET['rota'] : 'sobre-filme';
        
        $idUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 0;
        if($idUsuario) {

          if(!$filme->filmeCurtidoPeloUsuario($idUsuario)) {
            $filme->adicionarCurtidaAoFilme($idUsuario);
            $filme->atualizarNumCurtidas();
          }

          header("Location: $rotaOrigem" . ($rotaOrigem == "sobre-filme" ? "?id=$idFilme" : ''));
          die;
        } 
        
        else {
          header("Location: $rotaOrigem" . ($rotaOrigem == "sobre-filme" ? "?id=$idFilme&erro=login" : '&erro=login'));
          die;
        }
      }
      
      else {
        View::render('erro');
      }
    }

    // Retira a curtida de um filme do usuário logado e atualiza as estatísticas do filme
    public function desmarcarCurtida() {
      session_start();

      $idFilme = isset($_POST['id']) ? $_POST['id'] : 0;
      $idUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 0;
      if($idUsuario && $idFilme) {
        $rotaOrigem = isset($_GET['rota']) ? $_GET['rota'] : 'sobre-filme';
        
        $filme = new filme();
        $filme->id = $idFilme;
        $filme->removerCurtidaDoFilme($idUsuario);
        $filme->atualizarNumCurtidas();
        header("Location: $rotaOrigem" . ($rotaOrigem == "sobre-filme" ? "?id=$idFilme" : ''));
        die;
      }

      else {
        View::render('erro');
      }
    }

    // Adiciona um filme à lista de assistidos do usuário logado e atualiza as estatísticas do filme
    public function marcarFilmeAssistido() {
      $idFilme = isset($_POST['id']) ? $_POST['id'] : 0;
      
      if($idFilme) {
        $rotaOrigem = isset($_GET['rota']) ? $_GET['rota'] : 'sobre-filme';
        
        session_start();
        $idUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 0;
        if($idUsuario) {
          $filme = new filme();
          $filme->id = $idFilme;
          if(!$filme->filmeAssistidoPeloUsuario($idUsuario)) {
            $filme->adicionarFilmeAosAssistidos($idUsuario);
            $filme->atualizarNumAssistidos();
          }
          header("Location: $rotaOrigem" . ($rotaOrigem == "sobre-filme" ? "?id=$idFilme" : ''));
          die;
        } 

        else {
          header("Location: $rotaOrigem" . ($rotaOrigem == "sobre-filme" ? "?id=$idFilme&erro=login" : '&erro=login'));
          die;
        }
      }

      else {
        View::render('erro');
      }
    }

    // Retira um filme da lista de assistidos do usuário logado e apaga as resenhas feitas por ele sobre este filme
    public function desmarcarFilmeAssistido() {
      session_start();
      
      $idFilme = isset($_POST['id']) ? $_POST['id'] : 0;
      $idUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 0;

      if($idUsuario && $idFilme) {
        $rotaOrigem = isset($_GET['rota']) ? $_GET['rota'] : 'sobre-filme';
        
        $resenha = new Resenha();
        $resenha->idFilme = $idFilme;
        $resenha->idUsuario = $idUsuario;
        $resenha->deletarResenhaPorFilmeUsuario();
        
        $filme = new filme();
        $filme->id = $idFilme;
        $filme->removerFilmeDeAssistidos($idUsuario);
        $filme->atualizarNumAssistidos();
        $filme->atualizarNotaAvaliacao();

        header("Location: $rotaOrigem" . ($rotaOrigem == "sobre-filme" ? "?id=$idFilme" : ''));
        die;
      }

      else {
        View::render('erro');
      }
    }

   
    // Adiciona um filme para a lista de s de um usuário
    public function salvarFilme() {
      session_start();
      $idFilme = isset($_POST['id']) ? $_POST['id'] : 0;
      
      if($idFilme) {
        $rotaOrigem = isset($_GET['rota']) ? $_GET['rota'] : 'sobre-filme';
        
        $idUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 0;
        if($idUsuario) {
          $filme = new filme();
          $filme->id = $idFilme;
          if(!$filme->filmeSalvoPeloUsuario($idUsuario)) {
            $filme->adicionarFilmeAosSalvos($idUsuario);
            $filme->atualizarNumSalvos();
          }
          header("Location: $rotaOrigem" . ($rotaOrigem == "sobre-filme" ? "?id=$idFilme" : ''));
          die;
        } 
        
        else {
          header("Location: $rotaOrigem" . ($rotaOrigem == "sobre-filme" ? "?id=$idFilme&erro=login" : '&erro=login'));
          die;
        }
      }

      else {
        View::render('erro');
      }
    }

    // Retira um filme da lista de s do usuário logado e atualiza as estatísticas do filme
    public function desmarcarFilmeSalvo() {
      session_start();
      $idFilme = isset($_POST['id']) ? $_POST['id'] : 0;
      $idUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 0;

      if($idFilme && $idUsuario) {
        $rotaOrigem = isset($_GET['rota']) ? $_GET['rota'] : 'sobre-filme';
        
        $filme = new filme();
        $filme->id = $idFilme;
        $filme->removerFilmeDeSalvos($idUsuario);
        $filme->atualizarNumSalvos();
        header("Location: $rotaOrigem" . ($rotaOrigem == "sobre-filme" ? "?id=$idFilme" : ''));
        die;
      }

      else {
        View::render('erro');
      }
    }
  }

?> 