<template>
  <main id="search-results">

    <div class="row">
      <ResultFilter class="col-10" />
      <SortingMenu class="col d-flex align-items-end justify-content-end" @change="sortBy"/>
    </div>
    <div class="row">
      <hr />

      <template v-if="!usersFetched || users.length">
        <ResultGroup title="Perfis">
          <ul class="list-unstyled">
            <li class="col-md-3 col-sm-4 col-5" v-for="user in users" :key="user.id">
              <router-link :to="`/usuario/${user.tag}`" class="text-light text-center">
                <UserAvatar :username="user.tag" />
                <Title class="h5 mt-2">@{{ user.tag }}</Title>
              </router-link>
            </li>
            <template v-if="!users.length">
              <li class="col-md-3 col-sm-4 col-5" v-for="i in 10" :key="i">
                <UserAvatar username=""/>
                <div class="row">
                  <div class="placeholder mt-3 py-3 rounded px-3 col-8 mx-auto"></div>
                </div>
              </li>
            </template>
          </ul>
        </ResultGroup>
        <hr>
      </template>
      
      
      <ResultGroup title="Filmes" v-if="!moviesFetched || movies.length">
        <MoviesPanel :movies="movies" :inline="true"/>
      </ResultGroup>

    </div>
  </main>
</template>

<script>
import ResultFilter from "./ResultFilter.vue";
import SortingMenu from "@/components/SortingMenu.vue";
import UserAvatar from "@/components/UserAvatar.vue";
import ResultGroup from "@/components/ResultGroup.vue";
import MoviesPanel from "@/components/MoviesPanel.vue";
import Title from "@/components/Title.vue";

import PageMixin from "@/mixins/PageMixin";

export default {
  mixins: [PageMixin],

  components: {
    ResultFilter,
    SortingMenu,
    UserAvatar,
    ResultGroup,
    MoviesPanel,
    Title
  },
  props: {
    query: String,
  },
  data() {
    return {
      users: [],
      movies: [],
      usersFetched: false,
      moviesFetched: false,
    };
  },
  methods: {
    searchMovies(page = 1) {
      const params = { pesquisa: this.query, pagina: page };
      this.$api.get('/pesquisar-filmes', { params }).then(res => {
        const response = res.data;

        const { dados: data } = response;

        if(data && data.filmes.length) {
          this.movies = [
            ...this.movies,
            ...data.filmes
          ];

          if(data.proximaPagina) {
            this.searchMovies(data.proximaPagina);
          }
        }

        this.moviesFetched = true;

      }).then(this.validateFetched);
    },

    searchUsers() {
      const params = { pesquisa: this.query };
      this.$api.get('/pesquisar-usuarios', { params }).then(res => {
        const response = res.data;

        if(response.dados && response.dados.length) {
          this.users = response.dados.map(u => ({
            tag: u.username,
            id: u.id
          }));

          this.sortBy(this.factorSort);
        }

        this.usersFetched = true;
      }).then(this.validateFetched);
    },

    validateFetched() {
      if(this.usersFetched && this.moviesFetched && !this.users.length && !this.movies.length) {
        this.notifyUser({
          icon: "emoji-astonished-fill",
          title: "Ops",
          text: "não foram encontrado resultados...",
          class: "warning",
        });
        this.$router.back();
      }
    },

    clear() {
      this.movies = [];
      this.users = [];
      this.usersFetched = false;
      this.moviesFetched = false;
    },

    sortBy( factor = 'relevance' ) {
      this.factorSort = factor;

      switch(factor) {
        case 'recent': 
          this.movies.sort(this.sortRecent);
          break;
        case 'old': 
          this.movies.sort(this.sortOld);
          break;
        default:
          this.movies.sort(this.sortRelevance);
          break;
      } 
    },

    sortRelevance(a, b) { return a.relevancia > b.relevancia ? -1 : 1 },
    sortRecent(a, b) { return new Date(a.data).getTime() > new Date(b.data).getTime() ? -1 : 1 },
    sortOld(a, b) { return new Date(a.data).getTime() < new Date(b.data).getTime() ? -1 : 1 },

  },
  created() {
    this.changeFavicon("pesquisa", "svg");
    this.changePageTitle(`Pesquisa - ${this.query}`);
    this.searchMovies();
    this.searchUsers();
  },

  watch: {
    query() {
      this.clear();
      this.searchMovies();
      this.searchUsers();
    }
  },
};
</script>