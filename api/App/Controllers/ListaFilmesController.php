<?php
namespace App\Controllers;
use App\Resources\Response;
use App\Models\ListaFilmes;
use App\Models\Interacoes;

class ListaFilmesController {
    public function obterListaCurtidos() {
        $model = new Interacoes();
        $model->usuario = $_GET['uid'] ?? 0;
        $model->curtido = true;

        $listas = $model->obterFilmesInteracoesUsuario();

        $response = new Response();
        $response->sucesso = !empty($listas);
        if($response->sucesso) $response->dados = $listas;
        $response->enviar();
    }

    public function obterListaSalvos() {
        $model = new Interacoes();
        $model->usuario = $_GET['uid'] ?? 0;
        $model->salvo = true;

        $listas = $model->obterFilmesInteracoesUsuario();

        $response = new Response();
        $response->sucesso = !empty($listas);
        if($response->sucesso) $response->dados = $listas;
        $response->enviar();
    }

    public function obterListaAssistidos() {
        $model = new Interacoes();
        $model->usuario = $_GET['uid'] ?? 0;
        $model->assistido = true;

        $listas = $model->obterFilmesInteracoesUsuario();

        $response = new Response();
        $response->sucesso = !empty($listas);
        if($response->sucesso) $response->dados = $listas;
        $response->enviar();
    }
}