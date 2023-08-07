<?php
namespace App;

class Action {
    protected function retornarResposta(array|object $dados) {
        $json = json_encode($dados, JSON_UNESCAPED_UNICODE);

        if($json === null) $this->retornarErro();

        exit($json);
    }

    protected function retornarErro($erro = null) {

    }
}

?>