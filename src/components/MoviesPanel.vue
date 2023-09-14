<template>
  <ul class="list-unstyled l-poster py-4 overflow-visible" :class="inline ? 'flex-nowrap' : 'flex-wrap' ">
    <li v-for="movie in movies" :key="movie.id">
      <div>
        <MovieCard :movie="movie"/>
      </div>
    </li>
  </ul>
</template>

<script>
import MovieCard from '@/components/MovieCard.vue'
export default {
  props: {
    movies: Array,
    inline: {
      default: false
    }
  },
  components: {
    MovieCard
  }
}
</script>

<style>
  @import url(../assets/styles/layout/l-poster.css);
</style>