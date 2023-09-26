<?php
  namespace App;

  class Route {
    private $routes;
    public function __construct() {
      $this->initRoutes();
      $this->run($this->getUrl());
    }

    protected function initRoutes() {
      $routes['todos-filmes'] = array(
        'route' => '/todos-filmes',
        'controller' => 'FilmeController',
        'action' => 'obterTodosFilmes'
      );

      $routes['detalhes-filme'] = array(
        'route' => '/detalhes-filme',
        'controller' => 'FilmeController',
        'action' => 'obterDetalhesFilme'
      );

      $routes['info-filme'] = array(
        'route' => '/filme',
        'controller' => 'FilmeController',
        'action' => 'obterInformacoesFilme'
      );

      $routes['obter-nota-filme'] = array(
        'route' => '/obter-nota-filme',
        'controller' => 'ResenhaController',
        'action' => 'obterNotaFilme'
      );

      $routes['registrar-resenha'] = array(
        'route' => '/registrar-resenha',
        'controller' => 'ResenhaController',
        'action' => 'registrarResenha'
      );

      $routes['obter-resenhas-por-filme'] = array(
        'route' => '/obter-resenhas-por-filme',
        'controller' => 'ResenhaController',
        'action' => 'obterResenhasPorFilme'
      );

      $routes['usuario/checar-acesso'] = array(
        'route' => '/usuario/checar-acesso',
        'controller' => 'AuthController',
        'action' => 'checarAcessoUsuario'
      );

      $routes['obter-generos-filme'] = array(
        'route' => '/obter-generos-filme',
        'controller' => 'GenerosController',
        'action' => 'obterGenerosFilme'
      );

      $routes['obter-plataformas-filme'] = array(
        'route' => '/obter-plataformas-filme',
        'controller' => 'PlataformasController',
        'action' => 'obterPlataformasFilme'
      );

      $routes['cadastrar-usuario'] = array(
        'route' => '/usuario/cadastrar',
        'controller' => 'AuthController',
        'action' => 'cadastrarUsuario'
      );

      $routes['login'] = array(
        'route' => '/usuario/login',
        'controller' => 'AuthController',
        'action' => 'autenticarUsuario'
      );

      
      $routes['logout-usuario'] = array(
        'route' => '/usuario/logout', 
        'controller' => 'AuthController',
        'action' => 'logoutUsuario'
      );

      $routes['consultar-interacoes'] = array(
        'route' => '/filme/consultar-interacoes',
        'controller' => 'FilmeController',
        'action' => 'consultarInteracoes'
      );

      $this->setRoutes($routes); 
    }

    // Retorna todas as rotas criadas
    public function getRoutes() {
      return $this->routes;
    }

    // Atribui as rotas iniciadas ao contexto do objeto
    public function setRoutes(array $routes) {
      $this->routes = $routes;
    }

    // Percorre todas as rotas disponíveis testando a compatibilidade com a rota atual
    protected function run(string $url) {
      foreach ($this->routes as $key => $route) {
        if($url == $route['route']) {
          $nomeClasse = 'App\\Controllers\\'.$route['controller'];
          $controller = new $nomeClasse;

          $action = $route['action'];
          $controller->$action();
          die;
        }
      }
    }

    // Captura a rota solicitada a partir da URL
    protected function getUrl() {
      $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      $urlRelativa = str_replace('guia-filmes/', '', $url);

      return $urlRelativa;
    }
  }
?>