<?php
  $usuario = $dados['usuario'];
  $filmes = $dados['filmes'];
  $numPaginas = $dados['num_paginas'];
  $paginaAtual = $dados['pagina_atual'];
?>

<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link rel="icon" href="assets/img/favicons/home.svg" type="image/svg+xml">
    
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

    <!-- Estilos de layout -->
    <link rel="stylesheet" href="assets/styles/layout/l-fit.css">
    <link rel="stylesheet" href="assets/styles/layout/l-poster.css">
    <link rel="stylesheet" href="assets/styles/layout/z-index.css">
  </head>
  
  <body class="position-relative">
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

              <a href="pesquisa-mobile?rota=/guia-filmes" class="nav-link fw-bold d-sm-none">
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

    <!-- Listagem de filmes -->
    <main>
      <?php if($paginaAtual == 1): ?>
      <div id="intro-carousel" class="carousel slide py-5 px-1" data-bs-ride="carousel">
        
        <div class="carousel-inner w-75 mx-auto text-center">
          <div class="carousel-item active" data-bs-interval="10000">
            <h4><i class="bi bi-share-fill"></i></h4>
            <p class="px-5 fs-3">Compartilhe com seus amigos a sua resenha!</p>
          </div>
          <div class="carousel-item" data-bs-interval="2000">
            <h4><i class="bi bi-calendar-heart"></i></h4>
            <p class="px-5 fs-3">Registre os seus filmes favoritos!</p>
          </div>
          <div class="carousel-item">
            <h4><i class="bi bi-clock-history"></i></h4>
            <p class="px-5 fs-3">Adicione seus últimos assistidos!</p>
          </div>
          <div class="carousel-item">
            <h4><i class="bi bi-fire"></i></h4>
            <p class="px-5 fs-3">Fique por dentro do que está em alta!</p>
          </div>
        </div>

        <button class="carousel-control-prev ps-5" type="button" data-bs-target="#intro-carousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next pe-5" type="button" data-bs-target="#intro-carousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>

        <div class="carousel-indicators">
          <button type="button" data-bs-target="#intro-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#intro-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#intro-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
          <button type="button" data-bs-target="#intro-carousel" data-bs-slide-to="3" aria-label="Slide 3"></button>
        </div>

      </div>
      <?php endif; ?>

      <ul class="list-unstyled l-poster flex-wrap my-5">
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
                          "desmarcar-curtida?rota=/guia-filmes?pag=$paginaAtual"
                          :
                          "marcar-curtida?rota=/guia-filmes?pag=$paginaAtual"
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
                    <form action="marcar-assistido?rota=/guia-filmes?pag=<?= $paginaAtual ?>" method="post">
                      <button class="icon-button d-flex flex-column">
                        <i class="bi bi-camera-reels"></i>
                      </button>
                      <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                    </form>
                  <?php endif; ?>
                </div>
          
                <!-- salvar/removerSalvoFilme -->
                <div>
                  <form method="post" action='<?= (isset($filme['salvo']) && $filme['salvo'] ? "desmarcar-filme-salvo" : "salvar-filme") . "?rota=/guia-filmes?pag=$paginaAtual" ?>'>
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
              <div class="modal-body dark-box p-4 rounded">
                  <form action="desmarcar-assistido?rota=/guia-filmes?pag=<?= $paginaAtual ?>" method="post">
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
    </main>
     
    <!-- Paginação -->
    <footer class="d-flex justify-content-center py-3">
      <nav>
        <ul class="pagination pagination-dark">
          <li class="page-item <?= $paginaAtual == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?pag=<?= $paginaAtual - 1 ?>">Anterior</a>
          </li>
          
          <?php for($pagina = 1; $pagina <= $numPaginas; $pagina++): ?>
          <li class="page-item <?= $pagina == $paginaAtual ? 'active' : '' ?>">
            <a class="page-link" href="?pag=<?= $pagina ?>">
              <?= $pagina ?>
            </a>
          </li>
          <?php endfor?>

          <li class="page-item <?= $paginaAtual == $numPaginas ? 'disabled' : '' ?>">
            <a class="page-link" href="?pag=<?= $paginaAtual + 1 ?>">Próximo</a>
          </li>
        </ul>
      </nav>
    </footer>

    <script src="./assets/js/form-modal.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>