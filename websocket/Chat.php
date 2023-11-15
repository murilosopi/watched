<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
// use App\Models\Chat as ChatModel;

class Chat implements MessageComponentInterface
{
  protected $conexoes;

  public function onOpen(ConnectionInterface $conn)
  {
    $query = $conn->httpRequest->getUri()->getQuery();
    parse_str($query, $user);

    $conn->idUsuario = $user['uid'];
    
    $this->conexoes[$conn->idUsuario] = $conn;

    print_r(array_keys($this->conexoes));
  }

  public function onMessage(ConnectionInterface $from, $msg)
  {
    $mensagem = json_decode($msg);

    foreach($mensagem->to as $destinatario) {
      $this->conexoes[$destinatario]->send($msg);
    }
  }

  public function onClose(ConnectionInterface $conn)
  {
    unset($this->conexoes[$conn->idUsuario]);
  }

  public function onError(ConnectionInterface $conn, \Exception $e)
  {
    if(isset($this->conexoes[$conn->idUsuario])) {
      unset($this->conexoes[$conn->idUsuario]);
    }
    $conn->close();
  }
}

?>