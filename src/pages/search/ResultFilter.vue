<template>
  <nav class="navbar navbar-expand-lg">
    <button class="text-light navbar-toggler border-0" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <Title tag="span">
        <i class="bi bi-funnel me-2"></i>
        Filtros
      </Title>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav gap-4 mt-3">
        <li :class="cls" @click="clearFilters">Todos</li>
        <li :class="cls" class="dropdown" data-bs-theme="dark">
          <span class="dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">Filmes</span>
          <ul class="dropdown-menu">
            <template v-if="movies">
              <Title tag="li" class="dropdown-item" @click.native="() => {
                  genresActives = [];
                  movies = false;
                }
                ">
                <i class="bi bi-trash me-1"></i>
                Limpar
              </Title>
              <li>
                <hr class="dropdown-divider" />
              </li>
            </template>
            <li v-for="(genre, idx) in genres" :key="idx">
              <Title tag="label" class="dropdown-item pointer">
                {{ genre.name }}
                <input class="d-none" type="checkbox" :value="genre.id" v-model="genresActives" />
              </Title>
            </li>
          </ul>
        </li>
        <li :class="cls">Usuários</li>
        <li :class="cls">Publicações</li>
        <li :class="cls">Resenhas</li>
      </ul>
    </div>
  </nav>
</template>

<script>
import Title from '@/components/Title.vue';
export default {
  components: {
    Title
  },
  data() {
    return {
      cls: "pointer nav-item",

      genres: [
        { name: "Genero 1", id: 1 },
        { name: "Genero 2", id: 2 },
        { name: "Genero 3", id: 3 },
      ],

      genresActives: [],
      movies: false,
      users: false,
      posts: false,
      reviews: false,
    };
  },
  methods: {
    clearFilters() {
      this.genresActives = [];
    },
  },

  watch: {
    genresActives() {
      this.movies = this.genresActives.length > 0;
    },
  },
};
</script>

<style scoped>
.active,
.dropdown-item:has(input:checked) {
  color: black;
  background-color: white;
}

.dropdown-menu {
  background-color: var(--cor-dark);
}

.dropdown-menu .dropdown-item:is(:active) {
  background-color: transparent !important;
  color: white !important;
}
</style>