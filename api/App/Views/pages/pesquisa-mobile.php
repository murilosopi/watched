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

    <!-- Estilos de layout -->
    <link rel="stylesheet" href="assets/styles/layout/l-fit.css">
    <link rel="stylesheet" href="assets/styles/layout/l-poster.css">
    <link rel="stylesheet" href="assets/styles/layout/z-index.css">
  </head>
  
  <body class="position-relative">
    <header class="py-4 px-md-3">
      <div class="navbar navbar-expand-lg navbar-dark">
        <div class="container justify-content-between">

          <!-- Formulário de pesquisa -->
          <form action="pesquisar" id="form-search" class="row input-group search-box mx-auto px-3">
            <input type="search" autocomplete="off"  name="pesquisa" placeholder="Busque por filmes e usuários..." class="col">
            <button type="submit" class="col-2">
              <i class="bi bi-search"></i>
            </button>
          </form>
    </header>

    <div class="line-box">
      <div class="line mb-3 w-50"></div>
      <div class="line mb-3 w-100"></div>
      <div class="line mb-3 w-75"></div>
    </div>

    <main class="container text-white-50 py-5 mt-5">
      <svg class="d-block mx-auto" xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
      </svg>
      <p class="fs-4 py-5 text-center mt-2">Pesquise por filmes e usuários ou <a href="<?= $dados['rota'] ?>">retorne para página anterior.</a></p>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>