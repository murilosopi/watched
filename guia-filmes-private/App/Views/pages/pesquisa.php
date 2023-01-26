<?php
  $usuario = $dados['usuario'];
  $pesquisa = $dados['pesquisa'];
  $filtro = $dados['filtro'];
  $numUsuarios = $dados['num_usuarios'];
  $numFilmes = $dados['num_filmes'];
  $numResultados = $dados['num_resultados'];
  $filmes = $dados['filmes'];
?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesquisa</title>
    <link rel="icon" href="assets/img/favicons/pesquisa.svg" type="image/svg+xml">
    
    <!-- Bootstrap e ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <!-- Estilos básicos -->
    <link rel="stylesheet" href="assets/styles/base/normalize.css">
    <link rel="stylesheet" href="assets/styles/base/colors.css">
    <link rel="stylesheet" href="assets/styles/base/fonts.css">

    <!-- Estilos de componentes -->
    <link rel="stylesheet" href="assets/styles/components/title.css">
    <link rel="stylesheet" href="assets/styles/components/button-custom.css">
    <link rel="stylesheet" href="assets/styles/components/input-custom.css">
    <link rel="stylesheet" href="assets/styles/components/line-box.css">
    <link rel="stylesheet" href="assets/styles/components/search-box.css">
    <link rel="stylesheet" href="assets/styles/components/poster-card.css">
    <link rel="stylesheet" href="assets/styles/components/icon-button.css">
    <link rel="stylesheet" href="assets/styles/components/dark-box.css">
    <link rel="stylesheet" href="assets/styles/components/pagination-dark.css">
    <link rel="stylesheet" href="assets/styles/components/divider.css">
    <link rel="stylesheet" href="assets/styles/components/user-header.css">
    <link rel="stylesheet" href="assets/styles/components/scroller.css">
    <link rel="stylesheet" href="assets/styles/components/user-photo.css">

    <!-- Estilos de layout -->
    <link rel="stylesheet" href="assets/styles/layout/l-fit.css">
    <link rel="stylesheet" href="assets/styles/layout/l-poster.css">
    <link rel="stylesheet" href="assets/styles/layout/z-index.css">
    <link rel="stylesheet" href="assets/styles/layout/l-users.css">
  </head>
  
  <body class="position-relative">
    <!-- Cabeçalho da página -->
    <header class="py-4 px-md-3">
      <div class="navbar navbar-expand-lg navbar-dark">
        <div class="container-md justify-content-between">
          <h1 class="title mb-0"><a class="fw-normal" href="/guia-filmes">Watched!</a></h1>

          <!-- Formulário de pesquisa -->
          <form action="pesquisar" class="d-none d-sm-flex flex-grow-1 mx-3 mx-md-5" id="form-search">
            <div class="input-group search-box w-100">
              <input type="search" autocomplete="off"  name="pesquisa" placeholder="Busque por filmes e usuários..." class="flex-grow-1">
              <button type="submit">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>

          <!-- Navegação -->
          <button class="ms-auto navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse flex-grow-0" id="navbar">      
            <nav class="navbar-nav text-end py-3 px-4 gap-3">
              <a href="/guia-filmes" class="nav-link fw-bold">
                <i class="bi bi-house"></i>
                Home
              </a>

              <a href="pesquisa-mobile?rota=pesquisar?pesquisa=<?= $pesquisa ?>" class="nav-link fw-bold d-sm-none">
                <i class="bi bi-search"></i>
                Pesquisar
              </a>

              <?php if(!$usuario): ?>
              <a href="login" class="nav-link fw-bold">
                <i class="bi bi-box-arrow-in-right"></i>
                Entre na sua conta!
              </a>
              <?php else: ?>
              <a href="meu-perfil" class="nav-link fw-bold">
                <i class="bi bi-person-circle"></i>
                Meu perfil
              </a>
              <a href="logout" class="nav-link fw-bold">
                <i class="bi bi-box-arrow-left"></i>
                Sair
              </a>
              <?php endif; ?>
            </nav>
          </div>
        </div>
      </div>
    </header>

    <div class="line-box">
      <div class="line mb-3 w-50"></div>
      <div class="line mb-3 w-100"></div>
      <div class="line mb-3 w-75"></div>
    </div>

        <!-- Alertas de erro -->
    <?php if(isset($_GET['erro'])): ?>
    <p class="alert alert-warning alert-dismissible fade show position-fixed w-75 top-0 start-50 translate-middle-x mt-4 z-index" role="alert">
      <?php
        switch ($_GET['erro']) {
            case 'login':
              echo '<a href="cadastro">Cadastre-se</a> ou <a href="login">faça login</a> para aproveitar este recurso';
              break;
            
            default:
                echo "Algo deu errado, tente novamente mais tarde";
                break;
        }
      ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </p>
    <?php endif; ?>
    
    <!-- Início conteúdo principal -->
    <main class="container py-5">

      <!-- Cabeçalho da pesquisa -->
      <header class="d-flex align-items-center justify-content-between px-3">
        <p class="title h3 lh-base">
          <?= $numResultados > 0 ? $numResultados : 'Nenhum' ?>
          <?= $numResultados > 1 ? 'resultados' : 'resultado' ?> para: 
          <span class="fs-5">"<?= $pesquisa ?>"</span>
        </p>
        <div class="dropdown dropdown-menu-end">
          <button class="icon-button dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">
            <i class="bi bi-funnel"></i>
          </button>
          <form method="get" class="dropdown-menu form-check form-switch">
            <input type="hidden" name="pesquisa" value="<?= $pesquisa ?>">


            <label class="text-nowrap dropdown-item ps-5" for="all-results">
                Todos
                <input class="form-check-input" type="radio" name="filtro" role="switch" id="all-results" value="nenhum" <?= $filtro == 'nenhum' ? 'checked' : '' ?>>
            </label>

            <label class="text-nowrap dropdown-item ps-5" for="only-users">
                Apenas usuários
                <input class="form-check-input" type="radio" name="filtro" role="switch" id="only-users" value="usuarios" <?= $filtro == 'usuarios' ? 'checked' : '' ?>>
            </label>

            <label class="text-nowrap dropdown-item ps-5" for="only-movies">
                Apenas filmes
                <input class="form-check-input" type="radio" name="filtro" role="switch" id="only-movies" value="filmes" <?= $filtro == 'filmes' ? 'checked' : '' ?>>
            </label>

            <div class="dropdown-divider">
              <hr>
            </div>
            <button type="submit" class="dropdown-item">
              Aplicar filtros
            </button>
          </form>
        </div>
      </header>
      <hr class="divider">
      
      <!-- Seção de usuários encontrados -->
      <?php if($numUsuarios > 0): ?>
      <section class="container-fluid mt-5">
        <h2 class="title h1 text-center mb-4">Usuários</h2>

        <!-- Listagem de usuários -->
        <ul class="list-unstyled row flex-nowrap px-4 l-users" id="found-users-list">
          <?php foreach($dados['usuarios'] as $u): ?>
          <li class="rounded user-header dark-box p-3 pt-4 mx-auto col-10 col-sm-9 col-md-8 col-lg-6 col-xl-5">        
            <article>
              <div class="d-flex align-items-center gap-3">
                <figure class="col-3 col-sm-2 col-xl-1">
                  <img class="user-photo w-100" src="<?= $u['foto_perfil']?>" alt="Imagem de perfil do <?= $u['username']?>">
                </figure>
                <h3 class="title"><?= $u['username'] ?></h2>
              </div>

              <div class="row mt-auto">
                
              <?php if(!$u['seguido'] && $usuario): ?>
                <form action="seguir-perfil?rota=pesquisar?pesquisa=<?= $pesquisa ?>" method="post" class="col">
                  <button class="button-custom button-custom-azul w-100">Seguir</button>
                  <input type="hidden" name="id" value="<?= $u['id'] ?>">
                </form>

              <?php elseif($u['seguido']): ?>
                <form action="parar-seguir-perfil?rota=pesquisar?pesquisa=<?= $pesquisa ?>" method="post" class="col">
                  <button class="button-custom button-custom-azul w-100">Deixar de seguir</button>
                  <input type="hidden" name="id" value="<?= $u['id'] ?>">
                </form>
              <?php endif; ?>
  
                <div class="col">
                  <a class="d-block button-custom fw-normal w-100" href="usuario?u=<?= $u['username'] ?>">
                    Visitar perfil
                  </a>
                </div>
              </div>
            </article>
          </li>
          <?php endforeach; ?>
        </ul>
          
        <!-- Componente de rolagem -->
        <div class="scroller d-flex px-2">
          <button class="scroller-prev me-auto" type="button" onclick="prevScroll('found-users-list')">
            <i class="bi bi-arrow-bar-left"></i>
          </button>
          <button class="scroller-next ms-auto" type="button" onclick="nextScroll('found-users-list')">
            <i class="bi bi-arrow-bar-right"></i>
          </button>
        </div>
      </section>
      <hr class="divider mb-5">
      <?php endif; ?>

      
      <!-- Seção de filmes encontrados -->
      <?php if($numFilmes): ?>
      <section class="container-fluid">
        <h2 class="title h1 text-center m-0">Filmes</h2>

        <!-- Listagem de filmes -->
        <ul class="list-unstyled l-poster w-100 flex-wrap">
          <?php foreach($filmes as $filme): ?>
          <li>
            <article class="poster-card"">
              <img class="poster-img w-100" src="<?= $filme['url_cartaz'] ?>" alt="Cartaz do filme <?= $filme['nome'] ?>">
            
              <div class="poster-inner">
                <!-- Formulários de controle -->
                <div class="poster-top d-flex justify-content-between">
                  <div class="d-flex flex-column gap-2">
                    <!-- Curtir/descurtir -->
                    <form method="post" action='<?=
                            isset($filme['curtido']) && $filme['curtido'] ?
                            "desmarcar-curtida?rota=pesquisar?pesquisa={$pesquisa}"
                            :
                            "marcar-curtida?rota=pesquisar?pesquisa={$pesquisa}"
                    ?>'>
                      <button class="icon-button d-flex flex-column">
                        <i class="<?= isset($filme['curtido']) && $filme['curtido'] ? 'bi bi-heart-fill' : 'bi bi-heart' ?>"></i>
                      </button>
                      <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                    </form>

                    <!-- Marcar/desmarcar como assistido -->
                    <?php if(isset($filme['assistido']) && $filme['assistido']): ?>
                      <!-- Toggler do modal de confirmação -->
                      <button class="icon-button d-flex flex-column" data-bs-toggle="modal" data-bs-target="#confirmDeleteReview" onclick="changeFormModalData(<?= $filme['id'] ?>)">
                        <i class="bi bi-camera-reels-fill"></i>
                      </button>
                    <?php else: ?>
                      <form action="marcar-assistido?rota=pesquisar?pesquisa=<?= $pesquisa ?>" " method="post" class="d-inline">
                        <button class="icon-button d-flex flex-column">
                          <i class="bi bi-camera-reels"></i>
                        </button>
                        <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                      </form>
                    <?php endif; ?>
                </div>
            
                  <!-- salvar/removerSalvoFilme -->
                  <div>
                    <form method="post" action='<?= (isset($filme['salvo']) && $filme['salvo'] ? "desmarcar-filme-salvo" : "salvar-filme") . "?rota=pesquisar?pesquisa={$pesquisa}" ?>'>
                      <button type="submit" class="icon-button d-flex flex-column">
                        <i class="<?= isset($filme['salvo']) && $filme['salvo'] ? 'bi bi-bookmark-star-fill' : 'bi bi-bookmark-star' ?>"></i>
                      </button>
                      <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                    </form>
                  </div>
                </div>
                <!-- Link para o filme -->
                <a class="fw-normal p-2" href="sobre-filme?id=<?= $filme['id'] ?>">
                  <div class="poster-bottom">
                    <h3 class="poster-title text-truncate"><?= $filme['nome'] ?></h3>
                    <span class="poster-rating">
                      <i class="bi bi-star-half"></i>
                      <?= $filme['nota_avaliacao'] ?>
                    </span>
                  </div>
                </a>
              </div>
            </article>
          </li>
          <?php endforeach; ?>

          <!-- Modal de confirmação -->
          <div class="modal fade" id="confirmDeleteReview">
            <div class="modal-dialog modal-dialog-centered pb-5">
              <div class="modal-content bg-transparent rounded pb-5">
                <div class="modal-body dark-box p-4  rounded">
                    <form action="desmarcar-assistido?rota=pesquisar?pesquisa=<?= $pesquisa ?>" method="post">
                      <h4 class="fw-bold mb-3 text-center">Atenção:</h4>
                      <p class="mb-0">Ao tirar um filme da lista de assistidos, a sua resenha será <strong>excluída permanentemente.</strong> Deseja prosseguir?</p>
                      <input type="hidden" id="input-movie-id" name="id">
                      <div class="row mt-4">
                        <div class="col"><button class="w-100 button-custom button-custom-azul" type="button" data-bs-dismiss="modal">Voltar</button></div>
                        <div class="col"><button class="w-100 button-custom" type="submit">Continuar</button></div>
                      </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </ul>
      </section>
      <hr class="divider mb-5">
      <?php endif;?>

    </main>
     

    <script src="./assets/js/form-modal.js"></script>
    <script src="./assets/js/scroller.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>