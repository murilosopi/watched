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
  }
}
</script>

<style>

</style>