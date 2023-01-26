<?php
  namespace App\Views;

  class View {
    static function render($page, $dados = null) {
      require_once "../guia-filmes-private/App/Views/pages/{$page}.php";
    }
  }
?>