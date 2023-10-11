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

      $routes['obter-resenhas-filme'] = array(
        'route' => '/obter-resenhas-filme',
        'controller' => 'ResenhaController',
        'action' => 'obterResenhasPorFilme'
      );

      $routes['obter-resenhas-usuario'] = array(
        'route' => '/obter-resenhas-usuario',
        'controller' => 'ResenhaController',
        'action' => 'obterResenhasPorUsuario'
      );

      $routes['usuario-checar-acesso'] = array(
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

      $routes['alterar-curtida-filme'] = array(
        'route' => '/alterar-curtida-filme',
        'controller' => 'InteracoesController',
        'action' => 'alterarFilmeCurtido'
      );

      $routes['alterar-salvo-filme'] = array(
        'route' => '/alterar-salvo-filme',
        'controller' => 'InteracoesController',
        'action' => 'alterarFilmeSalvo'
      );

      $routes['alterar-assistido-filme'] = array(
        'route' => '/alterar-assistido-filme',
        'controller' => 'InteracoesController',
        'action' => 'alterarFilmeAssistido'
      );

      $routes['obter-informacoes-perfil'] = array(
        'route' => '/obter-informacoes-perfil',
        'controller' => 'UsuarioController',
        'action' => 'obterInformacoesPerfil'
      );

      $routes['obter-estatiscas-perfil'] = array(
        'route' => '/obter-estatiscas-perfil',
        'controller' => 'UsuarioController',
        'action' => 'obterEstatiscasPerfil'
      );

      $routes['lista-curtidos'] = array(
        'route' => '/lista/curtidos',
        'controller' => 'ListaFilmesController',
        'action' => 'obterListaCurtidos'
      );

      $routes['lista-assistidos'] = array(
        'route' => '/lista/assistidos',
        'controller' => 'ListaFilmesController',
        'action' => 'obterListaAssistidos'
      );

      $routes['lista-salvos'] = array(
        'route' => '/lista/salvos',
        'controller' => 'ListaFilmesController',
        'action' => 'obterListaSalvos'
      );

      $routes['obter-icones-reacoes'] = array(
        'route' => '/obter-icones-reacoes',
        'controller' => 'ReacaoController',
        'action' => 'obterIconesReacoes'
      );

      $routes['usuario/alterar-sobre'] = array(
        'route' => '/usuario/alterar-sobre',
        'controller' => 'UsuarioController',
        'action' => 'alterarSobreUsuario'
      );
      
      $routes['existe-resenha-filme-usuario'] = array(
        'route' => '/existe-resenha-filme-usuario',
        'controller' => 'ResenhaController',
        'action' => 'existeResenhaFilmeUsuario'
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