<?php
namespace App\Resources;

class Logger {

    private string $data;
    private string $horario;
    private string $tipo;

    public function __construct($tipo)
    {
        $this->data = date('d-m-Y');
        $this->horario = date('G:i:s');
        $this->tipo = ucfirst($tipo);
    }

    public function registrar($conteudo) {
        $path = __DIR__."/../Logs/{$this->tipo}";

        if(!file_exists($path)) mkdir($path);

        $arquivo = fopen($path."/{$this->data}.txt", "a+");

        $log = "{$this->horario}: {$conteudo}" . PHP_EOL;
        fwrite($arquivo, $log);
    }
}
