<template>
  <header class="py-4">
    <div class="navbar navbar-expand-lg navbar-dark">
      <div class="container-md justify-content-between">
        <MainBrand>
          <a class="fw-normal" href="/guia-filmes">Watched!</a>
        </MainBrand>

        <!-- Formulário de pesquisa -->
        <SearchBar />

        <!-- Navegação -->
        <Navigation />
      </div>
    </div>
    <Dividers />
  </header>
</template>

<script>
import SearchBar from "@/components/SearchBar.vue";
import MainBrand from "@/components/MainBrand.vue";
import Navigation from "@/components/Navigation.vue";
import Dividers from "@/components/Dividers.vue";
export default {
  components: {
    SearchBar,
    MainBrand,
    Navigation,
    Dividers,
  },
};
</script>

<style></style>
