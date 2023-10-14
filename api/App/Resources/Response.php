<?php
namespace App\Resources;

class Response {
  public bool $sucesso;
  public string $descricao;
  public $dados;

  public function enviar() {  
    header('Content-Type: application/json');    

    $json = json_encode($this, JSON_UNESCAPED_UNICODE);
    exit($json);
  } 

  public function erro($msg = 'Ocorreu um erro, tente novamente mais tarde.') {
    $this->descricao = $msg;
    $this->sucesso = false;
    $this->enviar();
  }
}
