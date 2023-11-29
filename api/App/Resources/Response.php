<?php

namespace App\Resources;

class Response
{
  public bool $sucesso;
  public string $descricao;
  public $dados;
  public $tipo;

  public function __construct($tipo = 'json')
  {
    $this->tipo = $tipo;
  }

  public function enviar()
  {

    $metodo = 'enviar' . ucfirst($this->tipo);

    $this->$metodo();
  }

  public function erro($msg = 'Ocorreu um erro, tente novamente mais tarde.')
  {
    $this->descricao = $msg;
    $this->sucesso = false;
    $this->enviar();
  }

  private function enviarJson()
  {
    header('Content-Type: application/json');

    $json = json_encode($this, JSON_UNESCAPED_UNICODE);
    exit($json);
  }

  private function enviarImagem()
  {
    header('Content-Type: ' . mime_content_type($this->dados));
    header('Content-Length: ' . filesize($this->dados));
    readfile($this->dados);
    exit;
  }
}
