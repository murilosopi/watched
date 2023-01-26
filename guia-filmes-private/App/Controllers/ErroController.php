<?php
  namespace App\Controllers;
  use App\Views\View;

  class ErroController {
    public function telaErro() {
      View::render('erro');
    }
  }

?>