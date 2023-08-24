<template>
  <ul class="list-unstyled l-poster flex-wrap my-5">
    <li v-for="movie in movies" :key="movie.id">
      <MovieCard :movie="movie"/>
    </li>
  </ul>
</template>

<script>
import MovieCard from '@/components/MovieCard.vue'
export default {
  props: {
    movies: Array
  },
  components: {
    MovieCard
  }
}
</script>

<style>
  @import url(../assets/styles/layout/l-poster.css);
</style>