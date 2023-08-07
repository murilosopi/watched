<?php 
  $usuario = $dados['usuario'];
  $filme = $dados['filme'];
  $resenhas = $dados['resenhas'];
  $plataformas = $dados['plataformas'];
  $generos = $dados['generos'];
?>

<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $filme['nome'] ?></title>
    <link rel="icon" href="assets/img/favicons/filme.svg" type="image/svg+xml">

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
    <link rel="stylesheet" href="assets/styles/components/icon-button.css">
    <link rel="stylesheet" href="assets/styles/components/dark-box.css">
    <link rel="stylesheet" href="assets/styles/components/divider.css">
    <link rel="stylesheet" href="assets/styles/components/input-custom.css">
    <link rel="stylesheet" href="assets/styles/components/button-custom.css">
    <link rel="stylesheet" href="assets/styles/components/user-photo.css">
    
    <!-- Estilos de layouts -->
    <link rel="stylesheet" href="assets/styles/layout/l-movie.css">
    <link rel="stylesheet" href="assets/styles/layout/l-fit.css">
    <link rel="stylesheet" href="assets/styles/layout/z-index.css">

  </head>
  <body class="pb-5 position-relative">
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

              <a href="pesquisa-mobile?rota=sobre-filme?id=<?= $filme['id'] ?>" class="nav-link fw-bold d-sm-none">
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

    <div class="line-box mb-5">
      <div class="line mb-3 w-50"></div>
      <div class="line mb-3 w-100"></div>
      <div class="line mb-3 w-75"></div>
    </div>

    <!-- Alerta de erro -->
    <?php if(isset($_GET['erro'])): ?>
    <p class="alert alert-warning alert-dismissible fade show position-fixed w-75 top-0 start-50 translate-middle-x mt-4 z-index" role="alert">
      <?php
        switch ($_GET['erro']) {
            case 'vazio':
                echo "O campo de descrição é obrigatório!";
                break;

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

    <!-- Início do conteúdo principal -->
    <main class="l-movie container px-4">
      <article class="row dark-box px-4 py-5 mb-5" id="article-movie">
        <!-- Cartaz do filme -->
        <div class="col-3 d-none d-md-block">
          <figure class="poster-card m-auto">
            <img class="poster-img w-100 h-100" src="<?= $filme['url_cartaz'] ?>" alt="Cartaz do filme <?= $filme['nome'] ?>">
          </figure>
        </div>

        <!-- Principais informações do filme -->
        <div class="col order-1 order-md-0">
          <div class="col p-0">
            <h2 class="h1 title"><?= $filme['nome'] ?></h2>
            <p><?= $filme['sinopse'] ?></p>
  
            <!-- Listagem de gêneros -->
            <ul class="d-flex gap-2 list-unstyled mb-4 flex-wrap">
              <?php foreach($generos as $g): ?>
              <li class="badge rounded-pill border px-3 py-2"><?= $g['nome'] ?></li>
              <?php endforeach; ?>
            </ul>

            <div class="d-flex">
              <!-- Contagem de estrelas pela avaliação média -->
              <ul class="list-unstyled d-inline-flex gap-1 me-2">
                <?php 
                  $notaFilme = $filme['nota_avaliacao'];
                  $estrelaVazia = '<li><i class="bi bi-star"></i></li>';
                  $estrela = '<li><i class="bi bi-star-fill"></i></li>';
                  $meiaEstrela = '<li><i class="bi bi-star-half"></i></li>';
                  
                  
                  for($c = 0; $c < 5; $c++) {
                    if($notaFilme - $c >= 1) {
                      echo $estrela;
                    } else if($notaFilme - floor($notaFilme) != 0) {
                      echo $meiaEstrela;
                      $notaFilme =- floor($notaFilme);
                    } else {
                      echo $estrelaVazia;
                    }
                  }
                ?>
              </ul>

              <!-- Avaliação média -->
              <p class="me-auto me-sm-4">
                <?= $filme['nota_avaliacao'] ?>
              </p>

              <!-- Duração -->
              <p>
                <i class="bi bi-clock"></i>
                <?php 
                  $total = $filme['duracao_min'];
                  $minutos = $total % 60;
                  $horas = floor($total/60);
                  echo "{$horas}h{$minutos}min"
                ?>
              </p> 
            </div>
          </div>
        </div>

        <!-- Formulários de controle -->
        <div class="order-sm-0 order-1 col-sm-2 ps-5 p-md-0 mt-2 mt-sm-0">
          <div class="d-flex flex-wrap justify-content-end gap-3">
            <!-- Curtir/descurtir -->
            <form action="<?= $filme['curtido'] ? 'desmarcar-curtida' : 'marcar-curtida' ?>" method="post">
              <button class="icon-button d-flex flex-column align-items-center">
                <i class="bi bi-heart<?= $filme['curtido'] ? '-fill' : ''?>"></i>
                <?=$filme['num_curtidas']?>
              </button>
              <input type="hidden" name="id" value="<?= $filme['id'] ?>">
            </form>
            
            <!-- Marcar/desmarcar assistido -->
            <?php if($filme['assistido']): ?>
              <button class="icon-button d-flex flex-column align-items-center" data-bs-toggle="modal" data-bs-target="#confirmRemoveWatched">
                <i class="bi bi-camera-reels-fill"></i>
                <?= $filme['num_assistidos'] ?>
              </button>
              
              <!-- Modal de confirmação -->
              <div class="modal fade" id="confirmRemoveWatched">
                <div class="modal-dialog modal-dialog-centered pb-5">
                  <div class="modal-content bg-transparent rounded pb-5">
                    <div class="modal-body dark-box p-4 rounded">
                        <form action="desmarcar-assistido" method="post">
                          <h4 class="fw-bold mb-3 text-center">Atenção:</h4>

                          <p class="mb-0">Ao tirar um filme da lista de assistidos, a sua resenha será <strong>excluída permanentemente.</strong> Deseja prosseguir?</p>
                          
                          <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                          <div class="row mt-4">
                            <div class="col"><button class="w-100 button-custom button-custom-azul" type="button" data-bs-dismiss="modal">Voltar</button></div>
                            <div class="col"><button class="w-100 button-custom" type="submit">Continuar</button></div>
                          </div>
                        </form>
                    </div>
                  </div>
                </div>
              </div>
            <?php else: ?>
              <form action="marcar-assistido" " method="post">
                <button class="icon-button d-flex flex-column align-items-center">
                  <i class="bi bi-camera-reels"></i>
                  <span><?= $filme['num_assistidos'] ?></span>
                </button>
                <input type="hidden" name="id" value="<?= $filme['id'] ?>">
              </form>
            <?php endif; ?>

            <!-- salvar/removerSalvoFilme -->
            <form action="<?= $filme['salvo'] ? 'desmarcar-filme-salvo' : 'salvar-filme' ?>" method="post">
              <button class="icon-button d-flex flex-column align-items-center">
                <i class="<?= $filme['salvo'] ? 'bi bi-bookmark-star-fill' : 'bi bi-bookmark-star' ?>"></i>
                <span><?= $filme['num_salvos'] ?></span>
              </button>
              <input type="hidden" name="id" value="<?= $filme['id'] ?>">
            </form>
          </div>
        </div>
      </article>

      <div class="row">
        <section class="col py-3 px-4" id="section-info">
          <h3 class="title h2 ms-5 mb-4">Quer saber mais? :)</h3>
          <dl class="row">
            <div class="col-sm">
              <?php if($filme['nome_original']): ?>
              <div class="d-flex gap-4">
                <dt class="title h4">Original</dt>
                <dd><?= $filme['nome_original'] ?></dd>
              </div>
              <?php endif; ?>

              <div class="d-flex gap-4">
                <dt class="title h4">Lançamento</dt>
                <dd><?= $filme['ano_lancamento'] ?></dd>
              </div>
    
              <div class="d-flex gap-4">
                <dt class="title h4">Elenco</dt>
                <dd>
                  <ul class="list-unstyled">
                    <?php foreach($filme['elenco'] as $nomeAtor): ?>
                      <li><?= $nomeAtor ?></li>
                    <?php endforeach; ?>
                  </ul>
                </dd>
              </div>
    
              <div class="d-flex gap-4">
                <dt class="title h4">Direção</dt>
                <dd><?= $filme['direcao'] ?></dd>
              </div>
    
              <div class="d-flex gap-4">
                <dt class="title h4">Roteiro</dt>
                <dd><?= $filme['roteiro'] ?></dd>
              </div>
            </div>

            <div class="col-sm">
              <div class="d-flex gap-4">
                <dt class="title h4">Distribuição</dt>
                <dd><?= $filme['distribuicao'] ?></dd>
              </div>
    
              <div class="d-flex gap-4">
                <dt class="title h4">Idioma</dt>
                <dd><?= $filme['idioma'] ?></dd>
              </div>
    
              <div class="d-flex gap-4">
                <dt class="title h4">País</dt>
                <dd><?= $filme['pais'] ?></dd>
              </div>
            </div>
          </dl>
        </section>

        <aside class="col-4 d-md-flex flex-column d-none" id="aside-streaming">
            <div class="dark-box p-4">
              <h3 class="title h4 text-center mb-4">
                Onde Assistir
                <i class="bi bi-play"></i>
              </h3>
              <!-- Listagem de plataformas disponíveis -->
              <?php if(count($plataformas) != 0): ?>
              <nav>
                <ul class="list-unstyled">
                  <?php foreach($plataformas as $plataforma): ?>
                  <li class="mb-3 row align-items-center">
                    <div class="col-2 px-md-2 px-xl-3">
                      <img src="<?= $plataforma['url_icone'] ?>" alt="" class="w-100">
                    </div>
                    <div class="col">
                      <a href="<?= $plataforma['url_link'] ?>" class="fw-normal" target="_blank"><?= $plataforma['nome'] ?></a>
                    </div>
                  </li>
                  <?php endforeach; ?>
                </ul>
              </nav>
              <?php else: ?>
              <div class="d-flex h-100 pb-4 opacity-75">
                <p class="text-white-50 my-auto">Nenhuma plataforma encontrada...</p>
              </div>
              <?php endif; ?>
            </div>
          </aside>
      </div>

      <hr class="divider p-0">

      <!-- Área do formulário de resenha -->
      <?php if($usuario && !$filme['avaliado']): ?>
      <section class="py-5 px-2" id="section-form-review">
        <h3 class="h2 title text-center">
          Assistiu? Conte achou :D
        </h3>

        <form action="registrar-resenha" method="post" class="row py-3" id="form-review">
          <!-- Caixas de texto -->
          <div class="col-lg-9">
            <label for="review-title" class="input-custom d-block mb-3">
              Título <small>(opcional)</small>
              <input class="form-control" type="text" name="titulo" id="review-title" placeholder="">
            </label>
    
            <label for="review-description" class="input-custom d-block mb-3">
              Descreve sua experiência
              <textarea name="descricao" id="review-description" class="form-control" rows="8"></textarea>
            </label>
          </div>

          <!-- Nota e curtida -->
          <div class="col-lg-3 d-flex flex-lg-column gap-lg-3 gap-5 mb-3">
            <div>
              <label for="rating">Avaliação</label>
              <ul class="list-unstyled fs-4 d-flex gap-2 mb-0" id="rating-list">
                <li data-rating="1" class="icon-button"><i class="bi bi-star"></i></li>
                <li data-rating="2" class="icon-button"><i class="bi bi-star"></i></li>
                <li data-rating="3" class="icon-button"><i class="bi bi-star"></i></li>
                <li data-rating="4" class="icon-button"><i class="bi bi-star"></i></li>
                <li data-rating="5" class="icon-button"><i class="bi bi-star"></i></li>
              </ul>
              <input type="hidden" name="avaliacao" value="0" id="rating">
            </div>
            
            <div>
              <label for="like">Curtir</label>
              <button class="icon-button d-block m-lg-0 m-auto" type="button" id="like-toggler">
                <i class="<?= $filme['curtido'] ? 'bi bi-heart-fill' : 'bi bi-heart' ?>"></i>
              </button>
              <input type="hidden" name="curtiu" id="like" value="<?= $filme['curtido'] ?>">
            </div>
          </div>
          <input type="hidden" name="id-filme" value="<?= $filme['id'] ?>">
          
          <div class="col-lg-9">
            <button type="submit" class="button-custom w-100 py-2">Salvar</button>
          </div>
        </form>

        <!-- Modal de confirmação -->
        <div class="modal fade" id="confirmRating">
          <div class="modal-dialog modal-dialog-centered pb-5">
            <div class="modal-content bg-transparent rounded pb-5">
              <div class="modal-body dark-box p-4 rounded">
                  <form>
                    <h4 class="fw-bold mb-3 text-center">Atenção:</h4>
                    <p class="mb-0">Você colocou uma nota vazia. Tem certeza que deseja dar essa nota?</p>

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
      <hr class="divider p-0">
      <?php endif; ?>

      <!-- Área das resenhas -->
      <?php if(count($resenhas) != 0): ?>
      <section class="py-5 px-2">
        <h3 class="title h2 text-center mb-5">
          <i class="bi bi-chat-left-text"></i>
          Veja o que estão comentando
        </h3> 

        <!-- Listagem de resenhas por usuário -->
        <ul class="list-unstyled row gy-4">
          <?php foreach($resenhas as $resenha): ?>
          <li class="col-lg-6 pe-lg-5 mb-4">
            <div class="h-100 dark-box p-4 rounded">
              <div class="row align-items-center mb-3">

                <!-- Foto de perfil -->
                <figure class="col-1 pe-0 mb-0">
                  <img class="user-photo w-100" src="<?= $resenha['foto_perfil'] ?>" alt="Foto de perfil de @user245">
                </figure>
                
                <!-- Nome de usuário e nota-->
                <div class="col d-flex justify-content-between align-items-center">
                  <h4 class="title mb-0">
                    <a href="usuario?u=<?= $resenha['username'] ?>">
                      <?= $resenha['username'] ?>
                    </a>
                  </h4>

                  <!-- Listagem de estrelas -->
                  <div class="d-flex align-items-center ms-auto gap-2">
                    <p class="mb-0">
                        <?= $resenha['nota_avaliacao'] ?>
                    </p>
                    <ul class="list-unstyled d-inline-flex gap-1">
                      <?php
                          $notaFilme = $resenha['nota_avaliacao'];
                          $estrelaVazia = '<li><i class="bi bi-star"></i></li>';
                          $estrela = '<li><i class="bi bi-star-fill"></i></li>';
                          $meiaEstrela = '<li><i class="bi bi-star-half"></i></li>';
              
                          for($c = 0; $c < 5; $c++) {
                            if($notaFilme - $c >= 1) {
                              echo $estrela;
                            } else if($notaFilme - floor($notaFilme) != 0) {
                              echo $meiaEstrela;
                              $notaFilme =- floor($notaFilme);
                            } else {
                              echo $estrelaVazia;
                            }
                          }
                        ?>
                    </ul>

                    <?php if($usuario && $resenha['id_usuario'] == $usuario['id']): ?>


                    <button class="icon-button" data-bs-toggle="modal" data-bs-target="#confirmDeleteReview">
                      <i class="bi bi-trash"></i>
                    </button>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              
              <div class="col-11 ms-auto">
              <!-- Título -->
                <?php if(!is_null($resenha['titulo'])): ?>
                <h5 class='fs-6 fw-bold fst-italic'><?= $resenha['titulo'] ?></h5>
                <?php endif; ?>
                <p class="fs-6 mb-0">
                  <?= str_replace("\n", "<br>", $resenha['descricao']) ?>
                </p>
              </div>
            </div>
          </li>
          <?php endforeach; ?>
        </ul>

        <!-- Modal de confirmação -->
        <div class="modal fade" id="confirmDeleteReview">
          <div class="modal-dialog modal-dialog-centered pb-5">
            <div class="modal-content bg-transparent rounded pb-5">
              <div class="modal-body dark-box p-4 rounded">
                  <form action="desmarcar-assistido" method="post">
                    <h4 class="fw-bold mb-3 text-center">Atenção:</h4>

                    <p class="mb-0">Essa ação é irreversível. Tem certeza que deseja <strong>excluir permanentemente</strong> sua resenha?</p>
                    
                    <input type="hidden" name="id" value="<?= $filme['id'] ?>">
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
      <?php endif; ?>
         
    </main> 
    
    <script src="assets/js/form-review.js"></script>
    <script src="assets/js/rating.js"></script>
    <script src="assets/js/like.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>