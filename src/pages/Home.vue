<template>
  <div id="home">
    <Slider />
    <MoviesPanel :movies="movies"/>
  </div>
</template>

<script>
import Slider from '@/components/Slider.vue'
import MoviesPanel from '@/components/MoviesPanel.vue';
export default {
  components: {
    Slider,
    MoviesPanel
  },
  data() {
    return {
      movies: []
    }
  },
  created() {
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