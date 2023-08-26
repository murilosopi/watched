<template>
  <header class="py-4">
    <div class="navbar navbar-expand-lg navbar-dark">
      <div class="container-md justify-content-between">
        <Title>
          <router-link to="/">
            <a class="fw-normal" href="/">Watched!</a>
          </router-link>
        </Title>

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
import Title from "@/components/Title.vue";
import Navigation from "@/components/Navigation.vue";
import Dividers from "@/components/Dividers.vue";
export default {
  components: {
    SearchBar,
    Title,
    Navigation,
    Dividers,
  },
};
</script>

<style></style>
