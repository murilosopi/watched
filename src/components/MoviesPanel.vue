<template>
  <ul class="list-unstyled l-poster py-4 overflow-visible" :class="inline ? 'flex-nowrap overflow-x-scroll' : 'flex-wrap' ">
    <li v-for="(movie, index) in movies" :key="`${movie.id}-${index}`">
      <MovieCard :movie="movie"/>
    </li>

    <template v-if="!movies.length">
      <li v-for="i in 10" :key="i">
        <MoviePoster class="placeholder" tag="figure"></MoviePoster>
      </li>
    </template>
  </ul>
</template>

<script>
import MovieCard from '@/components/MovieCard.vue'
import MoviePoster from './MoviePoster.vue';
export default {
  props: {
    movies: Array,
    inline: {
      default: false
    }
  },
  components: {
    MovieCard,
    MoviePoster
  }
}
</script>

<style>
  @import url(../assets/styles/layout/l-poster.css);
</style>