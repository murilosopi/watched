<?php
namespace App;

class Action {
    protected function retornarResposta(array|object $dados) {
        header('Content-Type: application/json');
        $json = json_encode($dados, JSON_UNESCAPED_UNICODE);

        if($json === null) $this->retornarErro();

        exit($json);
    }

    protected function retornarErro($erro = null) {

    }
}

?>