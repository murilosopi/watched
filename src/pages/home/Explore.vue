<template>
  <main class="explorar">
    <div class="container text-center">
      <Title class="display-2 me-5">
        <i class="bi bi-stars"></i>
        Explorar
      </Title>
      <p class="col-lg-8 mx-auto">
        Fique por dentro de tudo que está acontecendo no universo cinematográfico. <span class="d-none d-md-inline">Acompanhe os filmes em alta, postagens, resenhas e muito mais!</span>
      </p>
    </div>
    <Scroller>
      <MoviesPanel :movies="movies" :inline="true"/>
    </Scroller>
    <PostsList />
  </main>
</template>

<script>
import Title from "@/components/Title.vue";
import MoviesPanel from "@/components/MoviesPanel.vue";
import Scroller from "@/components/Scroller.vue";
import PageMixin from "@/mixins/PageMixin.js";
import PostsList from "@/components/PostsList.vue";
import { mapActions } from 'vuex';
export default {
  components: {
    Title,
    MoviesPanel,
    Scroller,
    PostsList
},
  mixins: [PageMixin],
  data() {
    return {
      movies: [],
    };
  },
  created() {
    this.changeFavicon("home", "svg");
    this.changePageTitle("Explorar");
    this.searchAllMovies();
    

    // busca novos posts a cada 3min
    setInterval(this.fetchNewPosts, 3 * 1000 * 60);
  },
  methods: {
    ...mapActions('post', ['fetchNewPosts']),
    searchAllMovies(offset = 0, limit = 0) {
      const params = {
        offset,
        limit,
      };

      this.$api
        .get("/todos-filmes", { params })
        .then((response) => {
          this.movies.push(...response.data.dados);
        })
        .catch((error) => {
          console.log(`${error.code}: ${error.message}`);
        });
    },
  },
};
</script>

<style></style>
