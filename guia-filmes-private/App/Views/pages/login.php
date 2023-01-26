<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="icon" href="assets/img/favicons/login-sign-up.svg" type="image/svg+xml">
    
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
  </head>
  <body class="d-flex flex-column">

    <header class="py-4 px-md-3">
        <!-- Navegação -->
      <div class="navbar navbar-expand-sm navbar-dark">
        <div class="container justify-content-between">
          <h1 class="title fw-bold mb-0"><a class="fw-normal" href="/guia-filmes">Watched!</a></h1>

          <button class="navbar-toggler border-0 ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse flex-grow-0" id="navbar">      
            <nav class="navbar-nav text-end py-3 px-4 gap-3">
              <a href="/guia-filmes" class="nav-link fw-bold">
                <i class="bi bi-house"></i>
                Home
              </a>
              <a href="cadastro" class="nav-link fw-bold">
                <i class="bi bi-box-arrow-in-right"></i>
                Crie sua conta!
              </a>
            </nav>
          </div>
        </div>
      </div>
    </header>

    <div class="line-box w-25">
      <div class="line mb-3 w-50"></div>
      <div class="line mb-3 w-100"></div>
      <div class="line mb-3 w-75"></div>
    </div>

    <?php if(isset($_GET['erro'])): ?>
        <div class="alert alert-warning alert-dismissible fade show position-fixed w-75 top-0 start-50 translate-middle-x mt-4 z-index" role="alert">
            <?php
                switch ($_GET['erro']) {                        
                    case 'vazio':
                      echo "Existem campos não preenchidos...";
                      break;

                    case 'autenticacao':
                      echo "As credenciais de acesso estão incorretas";
                      break;
                    
                    default:
                      echo "Algo deu errado, tente novamente mais tarde";
                      break;
                }
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <main class="container my-auto">

      <div class="text-center">
        <h2 class="title display-3">Entre na sua conta</h2>
        <p>Se você ainda não tiver uma conta, <a href="cadastro">cadastre-se aqui.</a></p>
      </div>

      <form action="autenticar-login" method="post" class="container d-flex flex-column">
        <div class="row justify-content-center">
          <div class="col-md-10 col-lg-7 col-xl-5">
            <div class="input-group input-custom mb-3">
              <div class="input-group-text">
                <i class="bi bi-person-circle"></i>
              </div>
              <input type="text" class="form-control" name="usuario" placeholder="Usuário" value="<?= $dados['usuario'] ?>">
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-md-10 col-lg-7 col-xl-5">
            <div class="input-group input-custom mb-3">
              <div class="input-group-text">
                <i class="bi bi-lock-fill"></i>
              </div>
              <input type="password" class="form-control" name="senha" placeholder="Senha">
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-md-10 col-lg-7 col-xl-5">
            <div class="d-flex">
              <button type="reset" class="button-custom w-100 me-2">Limpar</button>
              <button type="submit" class="button-custom w-100 ms-2 button-custom-azul ml-3">Entrar</button>
            </div>
          </div>
        </div>


      </form>
    </main> 

    <script src="assets/js/reset-form.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>