<template>
  <div class="navbar navbar-dark">
    <div class="container-md justify-content-between">
      <slot></slot>

      <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <DarkBox class="offcanvas offcanvas-end" id="navbar" data-bs-backdrop="static">
        <div class="offcanvas-header justify-content-end">
          <InteractiveIcon class="opacity-50" type="button" data-bs-dismiss="offcanvas" aria-label="Fechar">
            <i class="bi bi-x-lg fs-4"></i>
          </InteractiveIcon>
        </div>
        <div class="offcanvas-body">
          <nav class="navbar-nav text-end gap-3">
            <router-link @click.native="closeMenu" class="nav-link fw-bold" to="/">
              <i class="bi bi-house"></i>
              Home
            </router-link>
            <router-link to="/pesquisa" @click.native="closeMenu" class="nav-link fw-bold d-sm-none">
              <i class="bi bi-search"></i>
              Pesquisar
            </router-link>
            <template v-if="userLogged">
              <router-link :to="`/usuario/${loggedData.tag}`" @click.native="closeMenu" class="nav-link fw-bold">
                <i class="bi bi-person-circle"></i>
                Meu perfil
              </router-link>
              <a class="nav-link fw-bold" href="/logout" @click.prevent="() => {
                logout();
                closeMenu();
              }">
                <i class="bi bi-box-arrow-left"></i>
                Sair
              </a>
            </template>
            <template v-else>
              <router-link to="/login" @click.native="closeMenu" class="nav-link fw-bold">
                <i class="bi bi-box-arrow-in-right"></i>
                Entre na sua conta!
              </router-link>
            </template>
          </nav>
        </div>
      </DarkBox>
    </div>
  </div>
</template>

<script>
import DarkBox from "./DarkBox.vue";
import InteractiveIcon from "./InteractiveIcon.vue";
export default {
  components: {
    DarkBox,
    InteractiveIcon
  },
  methods: {
    closeMenu() {
      this.$el.querySelector('[data-bs-dismiss="offcanvas"]').click();
    }
  }
};
</script>

<style></style>
