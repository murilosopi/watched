<?php
  $nome = $dados['nome'];
  $email = $dados['email'];
  $usuario = $dados['usuario'];
?>

<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign-up</title>
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
    
    
    <link rel="stylesheet" href="assets/styles/layout/vertical-center.css">
  </head>
  <body class="d-flex flex-column position-relative">

    <header class="py-4 px-md-3">
      <!-- Navegação -->
      <div class="navbar navbar-expand-sm navbar-dark">
        <div class="container justify-content-between align-items-center">
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
              <a href="login" class="nav-link fw-bold">
                <i class="bi bi-box-arrow-in-right"></i>
                Entre na sua conta!
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
                    case 'senha':
                        echo "As senhas não são correspondentes";
                        break;

                    case 'email':
                        echo "O e-mail informado é inválido";
                        break;
                        
                    case 'username':
                        echo "O username informado é inválido";
                        break;
                        
                    case 'vazio':
                        echo "Existem campos não preenchidos...";
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
      <div>
        <div class="text-center">
          <h2 class="title display-3">Crie sua conta</h2>
          <p>Se você já tiver uma conta, <a href="login">entre aqui.</a></p>
        </div>
  
        <form class="container" action="autenticar-cadastro" method="post">
            <div class="row">
                <div class="col-md-7 mb-3 mb-md-4">
                    <div class="input-group input-custom">
                        <div class="input-group-text">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <input type="text" class="form-control" name="nome" placeholder="Nome" maxlength="100" value="<?= $nome ?>">
                    </div>
                </div>

                <div class="col-md-5 mb-3 mb-md-4">
                    <div class="input-group input-custom">
                        <div class="input-group-text">
                            <i class="bi bi-person-badge-fill"></i>
                        </div>
                        <input type="text" class="form-control" name="username" placeholder="Usuário" maxlength="20" value="<?= $usuario ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col mb-3 mb-md-4">
                    <div class="input-group input-custom">
                        <div class="input-group-text">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <input type="email" class="form-control" name="email" placeholder="E-mail" maxlength="75" value="<?= $email ?>">
                      </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3 mb-md-4">
                    <div class="input-group input-custom">
                        <div class="input-group-text">
                          <i class="bi bi-lock-fill"></i>
                        </div>
                        <input type="password" class="form-control" name="senha" placeholder="Senha">
                    </div>
                </div>

                <div class="col-md-6 mb-3 mb-md-4">
                    <div class="input-group input-custom">
                        <div class="input-group-text">
                          <i class="bi bi-lock-fill"></i>
                        </div>
                        <input type="password" class="form-control" name="confirme_senha" placeholder="Confirme sua senha">
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-6 col-lg-4 col-xl-3">
                    <button type="reset" class="w-100 button-custom">Limpar</button>
                </div>

                <div class="col-6 col-lg-4 col-xl-3">
                    <button type="submit" class="w-100 button-custom button-custom-azul">Cadastrar</button>
                </div>
            </div>
        </form>
    </main> 

    <script src="assets/js/reset-form.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>