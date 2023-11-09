<template>
  <main id="search" class="text-center pb-5">
    <SearchBar :value="query" placeholder="Pesquisar por perfis e filmes" />

    <div class="py-5">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="170"
        height="170"
        fill="#FFFFFF15"
        class="bi bi-search"
        viewBox="0 0 16 16"
      >
        <path
          d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"
        />
      </svg>
    </div>
    <div>
      <p class="mb-0 opacity-50 h5 px-3">
        Encontre <strong>filmes</strong> e <strong>usuários</strong> da plataforma buscando por <span class="fst-italic">palavras chaves</span>.
      </p>
    </div>
  </main>
</template>

<script>
import SearchBar from "@/components/SearchBar.vue";
export default {
  data() {
    return {
      query: "",
    };
  },
  components: {
    SearchBar,
  },
};
</script>

<style>
</style>