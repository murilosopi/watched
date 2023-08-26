<?php
namespace App\Resources;

class Response {
  public bool $sucesso;
  public string $descricao;
  public object | array $dados;

  public function enviar() {  
    header('Content-Type: application/json');    

    $json = json_encode($this, JSON_UNESCAPED_UNICODE);
    exit($json);
  } 
}
