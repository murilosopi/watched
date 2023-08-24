<?php
  namespace App;

  class Route {
    public function __construct() {
      $this->initRoutes();
      $this->run($this->getUrl());
    }

    // Define as informações de controlador e ação de cada rota acessada pela URL
    protected function initRoutes_old() {

      $routes['sobre-filme'] = array(
        'route' => '/sobre-filme',
        'controller' => 'FilmeController',
        'action' => 'sobreFilme'
      );

      $routes['login'] = array(
        'route' => '/login',
        'controller' => 'UsuarioController',
        'action' => 'login'
      );

      $routes['cadastro'] = array(
        'route' => '/cadastro',
        'controller' => 'UsuarioController',
        'action' => 'cadastro'
      );

      $routes['usuario'] = array(
        'route' => '/usuario',
        'controller' => 'UsuarioController',
        'action' => 'perfilUsuario'
      );

      $routes['meu-perfil'] = array(
        'route' => '/meu-perfil',
        'controller' => 'UsuarioController',
        'action' => 'meuPerfil'
      );

      $routes['pesquisar'] = array(
        'route' => '/pesquisar',
        'controller' => 'PesquisaController',
        'action' => 'pesquisarConteudo'
      );

      $routes['pesquisa-mobile'] = array(
        'route' => '/pesquisa-mobile',
        'controller' => 'PesquisaController',
        'action' => 'telaPesquisaMobile'
      );

      //---------------------------

      $routes['autenticar-cadastro'] = array(
        'route' => '/autenticar-cadastro',
        'controller' => 'AuthController',
        'action' => 'autenticarCadastro'
      );

      $routes['cadastrar-usuario'] = array(
        'route' => '/cadastrar-usuario',
        'controller' => 'AuthController',
        'action' => 'cadastrarUsuario'
      );

      $routes['autenticar-login'] = array(
        'route' => '/autenticar-login',
        'controller' => 'AuthController',
        'action' => 'autenticarLogin'
      );

      $routes['logout'] = array(
        'route' => '/logout',
        'controller' => 'AuthController',
        'action' => 'logout'
      );

      $routes['registrar-resenha'] = array(
        'route' => '/registrar-resenha',
        'controller' => 'FilmeController',
        'action' => 'criarResenha'
      );

      $routes['alterar-sobre'] = array(
        'route' => '/alterar-sobre',
        'controller' => 'UsuarioController',
        'action' => 'alterarSobreUsuario'
      );

      $routes['marcar-curtida'] = array(
        'route' => '/marcar-curtida',
        'controller' => 'FilmeController',
        'action' => 'marcarCurtida'
      );

      $routes['desmarcar-curtida'] = array(
        'route' => '/desmarcar-curtida',
        'controller' => 'FilmeController',
        'action' => 'desmarcarCurtida'
      );

      $routes['marcar-assistido'] = array(
        'route' => '/marcar-assistido',
        'controller' => 'FilmeController',
        'action' => 'marcarFilmeAssistido'
      );

      $routes['desmarcar-assistido'] = array(
        'route' => '/desmarcar-assistido',
        'controller' => 'FilmeController',
        'action' => 'desmarcarFilmeAssistido'
      );

      $routes['salvar-filme'] = array(
        'route' => '/salvar-filme',
        'controller' => 'FilmeController',
        'action' => 'salvarFilme'
      );

      $routes['desmarcar-filme-salvo'] = array(
        'route' => '/desmarcar-filme-salvo',
        'controller' => 'FilmeController',
        'action' => 'desmarcarFilmeSalvo'
      );

      $routes['seguir-perfil'] = array(
        'route' => '/seguir-perfil',
        'controller' => 'UsuarioController',
        'action' => 'seguirPerfil'
      );

      $routes['parar-seguir-perfil'] = array(
        'route' => '/parar-seguir-perfil',
        'controller' => 'UsuarioController',
        'action' => 'pararSeguirPerfil'
      );

      $routes['alterar-foto-perfil'] = array(
        'route' => '/alterar-foto-perfil',
        'controller' => 'UsuarioController',
        'action' => 'alterarFotoPerfil'
      );

      $this->setRoutes($routes); 
    }

    protected function initRoutes() {
      $routes['todos-filmes'] = array(
        'route' => '/todos-filmes',
        'controller' => 'FilmeController',
        'action' => 'obterTodosFilmes'
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

      header('Location: erro');
    }

    // Captura a rota solicitada a partir da URL
    protected function getUrl() {
      $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      $urlRelativa = str_replace('guia-filmes/', '', $url);

      return $urlRelativa;
    }
  }
?>