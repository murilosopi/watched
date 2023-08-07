<template>
  <header class="py-4 px-md-3">
    <div class="navbar navbar-expand-lg navbar-dark">
      <div class="container-md justify-content-between">
        <MainTitle>
          <a class="fw-normal" href="/guia-filmes">Watched!</a>
        </MainTitle>

        <!-- Formulário de pesquisa -->
        <SearchBar/>

        <!-- Navegação -->
        <Navigation/>
        
      </div>
    </div>
  </header>
</template>

<script>
import SearchBar from '@/components/SearchBar.vue';
import MainTitle from '@/components/MainTitle.vue';
import Navigation from '@/components/Navigation.vue';
export default {
  components: {
    SearchBar, MainTitle, Navigation
  }
};
</script>

<style>

</style>
