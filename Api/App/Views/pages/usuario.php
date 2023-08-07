<?php
  $perfil = $dados['perfil'];
  $usuario = $dados['usuario'];
  $editavel = $dados['editavel'];
  $listasFilmes = $dados['filmes'];
?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $perfil['nome'] ?> - Perfil </title>
    <link rel="icon" href="assets/img/favicons/usuario.svg" type="image/svg+xml">
    
    <!-- Bootstrap e ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <!-- Estilos básicos -->
    <link rel="stylesheet" href="assets/styles/base/normalize.css">
    <link rel="stylesheet" href="assets/styles/base/colors.css">
    <link rel="stylesheet" href="assets/styles/base/fonts.css">

    <!-- Estilos de componentes -->
    <link rel="stylesheet" href="assets/styles/components/title.css">
    <link rel="stylesheet" href="assets/styles/components/line-box.css">
    <link rel="stylesheet" href="assets/styles/components/search-box.css">
    <link rel="stylesheet" href="assets/styles/components/poster-card.css">
    <link rel="stylesheet" href="assets/styles/components/divider.css">
    <link rel="stylesheet" href="assets/styles/components/scroller.css">
    <link rel="stylesheet" href="assets/styles/components/icon-button.css">
    <link rel="stylesheet" href="assets/styles/components/dark-box.css">
    <link rel="stylesheet" href="assets/styles/components/button-custom.css">
    <link rel="stylesheet" href="assets/styles/components/input-custom.css">
    <link rel="stylesheet" href="assets/styles/components/user-photo.css">
    
    <!-- Estilos de layouts -->
    <link rel="stylesheet" href="assets/styles/layout/l-header-user.css">
    <link rel="stylesheet" href="assets/styles/layout/l-poster.css">
    <link rel="stylesheet" href="assets/styles/layout/z-index.css">

  </head>
  <body>
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

              <a href="pesquisa-mobile?rota=usuario?u=<?= $perfil['username'] ?>" class="nav-link fw-bold d-sm-none">
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

    <?php if(isset($_GET['erro'])): ?>
        <div class="alert alert-warning alert-dismissible fade show position-fixed w-75 top-0 start-50 translate-middle-x mt-4 z-index" role="alert">
            <?php
                switch ($_GET['erro']) {                        
                    case 'vazio':
                      echo "Preencha corretamente o campo...";
                      break;

                    case 'login':
                      echo '<a href="cadastro">Cadastre-se</a> ou <a href="login">faça login</a> para aproveitar este recurso';
                      break;

                    case 'upload':
                      echo 'Algo deu errado ao enviar arquivo, tente novamente mais tarde';
                      break;

                    case 'tamanho':
                      echo 'O arquivo é muito grande. Escolha uma imagem de até 5 mb.';
                      break;

                    case 'tipo':
                      echo 'O tipo de arquivo enviado é inválido!';
                      break;

                    default:
                      echo "Algo deu errado, tente novamente mais tarde";
                      break;

                }
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <main class="container py-4">
      <header class="l-header-user dark-box p-5 mb-4">
        <div class="row">
          <div class="col-9 col-sm-8 col-md-6 col-lg-3 mb-4 mb-lg-0 mx-auto position-relative">
            <!-- Foto de perfil -->
            <figure class="m-auto">
              <img class="user-photo w-100" src="<?= $perfil['foto_perfil'] ?>" alt="Imagem de perfil do <?= $perfil['username'] ?>">
            </figure>

            <!-- Alterar foto de perfil -->
            <?php if($editavel): ?>
            <form action="alterar-foto-perfil" method="post" class="photo-change-form auto-submit" enctype="multipart/form-data">
              <label for="img-user" class="icon-button">
                <span class="badge rounded-circle p-3 d-flex btn btn-light text-black border-0">
                  <i class="bi bi-pencil-fill fs-5"></i>
                </span>
              </label>
              <input type="file" name="img" id="img-user" class="d-none toggler" accept="image/*">
            </form>
            <?php endif; ?>
          </div>

          <article class="col-lg-6 my-auto">
            <h2 class="title">@<?= $perfil['username'] ?></h2>

            <?php if($editavel && is_null($perfil['sobre'])): ?>
              <button class="btn btn-sm btn-outline-light px-4 mb-3 position-relative" data-bs-toggle="modal" data-bs-target="#addAboutUser">
                Adicione um texto sobre você
                <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle"></span>
              </button>

              <div class="modal fade" id="addAboutUser">
                <div class="modal-dialog modal-dialog-centered pb-5">
                  <div class="modal-content bg-transparent rounded pb-5">
                    <div class="modal-body dark-box py-4 rounded">
                      <form action="alterar-sobre" method="post">
                        <div class="mb-3">
                          <label for="message-text" class="col-form-label">Conte mais sobre você</label>
                          <div class="input-custom">
                            <textarea maxlength="240" class="form-control" id="message-text" rows="5" name="sobre"></textarea>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col"><button type="button" class="button-custom w-100" data-bs-dismiss="modal">Voltar</button></div>
                          <div class="col"><button type="submit" class="button-custom button-custom-azul w-100">Salvar</button></div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

            <?php elseif(!is_null($perfil['sobre'])): ?>
              <p class="text-break">
                <?= str_replace("\n", "<br>", $perfil['sobre']) ?>

                <?php if($editavel): ?>
                  <button class="d-flex gap-2 align-items-center icon-button fw-bold p-0 mt-1" data-bs-toggle="modal" data-bs-target="#addAboutUser">
                    Alterar
                    <i class="bi bi-pencil-square fs-5"></i>
                  </button>
                  
                  <div class="modal fade" id="addAboutUser">
                    <div class="modal-dialog modal-dialog-centered pb-5">
                      <div class="modal-content bg-transparent rounded pb-5">
                        <div class="modal-body dark-box py-4 rounded">
                          <form action="alterar-sobre" method="post">
                            <div class="mb-3">
                              <label for="message-text" class="col-form-label">Conte mais sobre você</label>
                              <div class="input-custom">
                                <textarea maxlength="240" class="form-control" id="message-text" rows="5" name="sobre"><?= str_replace('<br>', "\n", $perfil['sobre']) ?></textarea>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col"><button type="button" class="button-custom w-100" data-bs-dismiss="modal">Voltar</button></div>
                              <div class="col"><button type="submit" class="button-custom button-custom-azul w-100">Salvar</button></div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
              </p>              
            <?php endif; ?>
                      
            <div class="d-lg-none">
              <ul class="user-stats ps-0 d-flex flex-column gap-2 mb-4">
                <li class="d-flex align-items-center gap-2">
                  <i class="bi bi-people-fill fs-5"></i>
                  <strong>Seguidores:</strong> <?= $perfil['num_seguidores'] ?>
                </li>
                <li class="d-flex align-items-center gap-2">
                  <i class="bi bi-person-check-fill fs-5"></i>
                  <strong>Seguindo:</strong> <?= $perfil['num_seguindo'] ?>
                </li>
                <li class="d-flex align-items-center gap-2">
                  <i class="bi bi-film fs-5"></i>
                  <strong>Assistidos:</strong> <?= $dados['num_assistidos'] ?>
                </li>
                <li class="d-flex align-items-center gap-2">
                  <i class="bi bi-chat-left-quote fs-5"></i>
                  <strong>Resenhas:</strong> <?= $dados['num_resenhas'] ?>
                </li>
              </ul>
            </div>

            <?php if(!$editavel && !$perfil['seguido']): ?>
              <form action="seguir-perfil?rota=usuario?u=<?= $perfil['username'] ?>" method="post" class="container-fluid">
                <div class="row">
                  <div class="col-md-7 ps-0">
                    <button class="button-custom button-custom-azul w-100">Seguir</button>
                  </div>
                </div>
                <input type="hidden" name="id" value="<?= $perfil['id'] ?>">
              </form>

            <?php elseif(!$editavel): ?>
              <form action="parar-seguir-perfil?rota=usuario?u=<?= $perfil['username'] ?>" method="post" class="container-fluid">
                <div class="row">
                  <div class="col-md-7 ps-0">
                    <button class="button-custom button-custom-azul w-100">Deixar de seguir</button>
                  </div>
                </div>
                <input type="hidden" name="id" value="<?= $perfil['id'] ?>">
              </form>
            <?php endif; ?>
          </article>
  
          <ul class="user-stats col-lg-3 d-none d-lg-flex flex-column m-auto gap-2">
              <li class="d-flex align-items-center gap-2">
                <i class="bi bi-people-fill fs-5"></i>
                <strong>Seguidores:</strong> <?= $perfil['num_seguidores'] ?>
              </li>
              <li class="d-flex align-items-center gap-2">
                <i class="bi bi-person-check-fill fs-5"></i>
                <strong>Seguindo:</strong> <?= $perfil['num_seguindo'] ?>
              </li>
              <li class="d-flex align-items-center gap-2">
                <i class="bi bi-film fs-5"></i>
                <strong>Assistidos:</strong> <?= $dados['num_assistidos'] ?>
              </li>
              <li class="d-flex align-items-center gap-2">
                <i class="bi bi-chat-left-quote fs-5"></i>
                <strong>Resenhas:</strong> <?= $dados['num_resenhas'] ?>
              </li>
          </ul>
        </div>
      </header>

      <hr class="divider">

      <?php foreach($listasFilmes as $titulo => $lista): ?>
        <?php if(count($lista) != 0): ?>
          <section class="mt-4 position-relative">
            <h3 class="title h1 px-3 d-flex align-items-center gap-3">
              <?php 
                $icone = '';
                switch($titulo) {
                  case 'salvos':
                    $icone = '<i class="bi bi-bookmark-star fs-3 mt-1"></i>';
                    break;
                  case 'curtidos':
                      $icone = '<i class="bi bi-heart fs-3 mt-1"></i>';
                    break;
                  case 'assistidos':
                    $icone = '<i class="bi bi-camera-reels fs-3 mt-1"></i>';
                    break;
                }
              ?>
              <?= $icone ?>
              <?= ucfirst($titulo) ?>:
            </h3>
            <ul class="l-poster w-100 justify-content-start list-unstyled" id="<?= $titulo ?>-movies-list">
              <?php foreach($lista as $filme): ?>
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
                                  "desmarcar-curtida?rota=usuario?u={$perfil['username']}"
                                  :
                                  "marcar-curtida?rota=usuario?u={$perfil['username']}"
                          ?>'>
                            <button class="icon-button d-flex flex-column">
                              <i class="<?= isset($filme['curtido']) && $filme['curtido'] ? 'bi bi-heart-fill' : 'bi bi-heart' ?>"></i>
                            </button>
                            <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                          </form>
                          <!-- Marcar/desmarcar como assistido -->
                          <?php if(isset($filme['assistido']) && !$filme['assistido'] || is_null($usuario)): ?>
                          <form action="marcar-assistido?rota=usuario?u=<?= $perfil['username'] ?>" " method="post" class="d-inline">
                            <button class="icon-button d-flex flex-column">
                              <i class="bi bi-camera-reels"></i>
                            </button>
                            <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                          </form>
                          <!-- Toggler do modal de confirmação -->
                          <?php else: ?>
                          <button class="icon-button d-flex flex-column"
                                  data-bs-toggle="modal" data-bs-target="#confirmDeleteReview"
                                  onclick="changeFormModalData(<?= $filme['id'] ?>)"
                          >
                            <i class="bi bi-camera-reels-fill"></i>
                          </button>
                          <?php endif; ?>
                        </div>
        
                        <!-- salvar/removerSalvoFilme -->
                        <div>
                          <form method="post" action='<?= (isset($filme['salvo']) && $filme['salvo'] ? "desmarcar-filme-salvo" : "salvar-filme") . "?rota=usuario?u={$perfil['username']}" ?>'>
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
            </ul>
        
            <div class="scroller d-flex px-2">
              <button class="scroller-prev me-auto" type="button" onclick="prevScroll('<?= $titulo ?>-movies-list')">
                <i class="bi bi-arrow-bar-left"></i>
              </button>
              <button class="scroller-next ms-auto" type="button" onclick="nextScroll('<?= $titulo ?>-movies-list')">
                <i class="bi bi-arrow-bar-right"></i>
              </button>
            </div>
            <div class="modal fade" id="confirmDeleteReview">
              <div class="modal-dialog modal-dialog-centered pb-5">
                <div class="modal-content bg-transparent rounded pb-5">
                  <div class="modal-body dark-box py-4 rounded">
                      <form action="desmarcar-assistido?rota=usuario?u=<?= $perfil['username'] ?>" method="post">
                        <h4 class="fw-bold mb-3 text-center">Atenção:</h4>
                        <p class="mb-0">Ao tirar um filme da lista de assistidos, a sua resenha será <strong>excluída permanentemente</strong>. Deseja continuar?</p>
        
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
          </section>
          <hr class="divider">
        <?php endif; ?>
      <?php endforeach ?>
    </main> 

    <script src="assets/js/form-modal.js"></script>
    <script src="assets/js/scroller.js"></script>
    <script src="assets/js/auto-submit.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>