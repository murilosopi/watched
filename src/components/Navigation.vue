<template>
  <div class="navbar navbar-expand-lg navbar-dark">
    <div class="container-md justify-content-between">
      <slot></slot>

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
          <router-link to="/">
            <a class="nav-link fw-bold">
              <i class="bi bi-house"></i>
              Home
            </a>
          </router-link>
          <a
            href="pesquisa-mobile?rota=/guia-filmes"
            class="nav-link fw-bold d-sm-none"
          >
            <i class="bi bi-search"></i>
            Pesquisar
          </a>
          <template v-if="userLogged">
            <router-link :to="`/usuario/${loggedData.tag}`">
              <a class="nav-link fw-bold">
                <i class="bi bi-person-circle"></i>
                Meu perfil
              </a>
            </router-link>
            <a class="nav-link fw-bold" href="/logout" @click.prevent="logout">
              <i class="bi bi-box-arrow-left"></i>
              Sair
            </a>
          </template>
          <template v-else>
            <router-link to="/login">
              <a class="nav-link fw-bold">
                <i class="bi bi-box-arrow-in-right"></i>
                Entre na sua conta!
              </a>
            </router-link>
          </template>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style></style>
