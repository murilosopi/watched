<?php
  namespace App\Controllers;
  use App\Views\View;
  use App\Models\Filme;

  class HomeController {
    public function home() {
      session_start();
      $idUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 0;
      
      $filme = new Filme();
      $totalFilmes = count($filme->obterTodosFilmes());
      $numFilmesPorPagina = 4;
      $numPaginas = ceil($totalFilmes / $numFilmesPorPagina);
      $paginaAtual = isset($_GET['pag']) ? $_GET['pag'] : 1;
      $apartirDe = $numFilmesPorPagina * ($paginaAtual - 1);
      $filmes = $filme->obterTodosFilmes($numFilmesPorPagina, $apartirDe);
      
      if($idUsuario) {
        foreach ($filmes as $idx => $f) {
          $filme->id = $f['id'];
          $filmes[$idx]['curtido'] = $filme->filmeCurtidoPeloUsuario($idUsuario);
          $filmes[$idx]['assistido'] = $filme->filmeAssistidoPeloUsuario($idUsuario);
          $filmes[$idx]['salvo'] = $filme->filmeSalvoPeloUsuario($idUsuario);
        }

        View::render(
          'home', 
          [
            'filmes' => $filmes,
            'num_paginas' => $numPaginas,
            'pagina_atual' => $paginaAtual,
            'usuario' => $_SESSION['usuario']
          ]
        );
      } 
      
      else {
        View::render(
          'home', 
          [
            'filmes' => $filmes,
            'num_paginas' => $numPaginas,
            'pagina_atual' => $paginaAtual,
            'usuario' => NULL
          ]
        );
      }
    }
  }
?> 