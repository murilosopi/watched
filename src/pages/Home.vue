<template>
  <div id="home">
    <Slider />
    <MoviesPanel :movies="movies"/>
  </div>
</template>

<script>
import Slider from '@/components/Slider.vue'
import MoviesPanel from '@/components/MoviesPanel.vue';
import PageMixin from '@/mixins/PageMixin.js';
export default {
  components: {
    Slider,
    MoviesPanel
  },
  mixins: [PageMixin],
  data() {
    return {
      movies: []
    }
  },
  created() {
    this.alterarFavicon('home', 'svg');
    this.alterarTitle('Explorar');
    this.searchAllMovies();
  },
  methods: {
    searchAllMovies(offset = 0, limit = 0) {
      const params = {
        offset, limit
      };

      this.$api.get('/todos-filmes', { params })
      .then(response => {
        this.movies.push(...response.data);
      })
      .catch(error => {
        console.log(`${error.code}: ${error.message}`);
      })
    }
  }
}
</script>

<style>

</style>