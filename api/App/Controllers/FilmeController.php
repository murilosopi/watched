<?php
  namespace App\Controllers;
  use App\Models\Filme;
  use App\Models\Resenha;
  use App\Models\Usuario;
  use App\Models\Plataforma;
  use App\Models\Genero;
  use App\Action;

  class FilmeController extends Action {

    public function obterTodosFilmes() {

      $filmeModel = new Filme();
      $filmeModel->offset = $_GET['offset'] ?? 0;
      $filmeModel->limit = $_GET['limit'] ?? 0;

      $filmes = $filmeModel->obterTodosFilmes();

      $this->retornarResposta($filmes);
    }

  }

?> 