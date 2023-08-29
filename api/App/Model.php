<?php
namespace App;
use App\Connection;

class Model {
  protected \PDO $conexao;
  protected $offset;
  protected $limit;

  public function __construct() {
    $this->conexao = Connection::getDb();
  }

  public function __get($atributo) {
    return $this->$atributo;
  }

  public function __set($atributo, $valor) {
    $this->$atributo = $valor;
    return $this;
  }
}

?>