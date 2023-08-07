<template>
  <div>
    <button
      class="ms-auto navbar-toggler border-0"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbar"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse flex-grow-0" id="navbar">
      <nav class="navbar-nav text-end py-3 px-4 gap-3">
        <a href="/guia-filmes" class="nav-link fw-bold">
          <i class="bi bi-house"></i>
          Home
        </a>

        <a
          href="pesquisa-mobile?rota=/guia-filmes"
          class="nav-link fw-bold d-sm-none"
        >
          <i class="bi bi-search"></i>
          Pesquisar
        </a>

        <template v-if="usuarioLogado">
            <a href="meu-perfil" class="nav-link fw-bold">
              <i class="bi bi-person-circle"></i>
              Meu perfil
            </a>
            <a href="logout" class="nav-link fw-bold">
              <i class="bi bi-box-arrow-left"></i>
              Sair
            </a>
        </template>
        <template v-else>
            <a href="login" class="nav-link fw-bold">
              <i class="bi bi-box-arrow-in-right"></i>
              Entre na sua conta!
            </a>
        </template>
      </nav>
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            usuarioLogado: false
        }
    }
};
</script>

<style></style>
