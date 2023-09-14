<template>
  <section class="movie-list">
    <Title tag="h3">
      <slot name="icon"></slot>
      {{ name }}
    </Title>

    <Scroller>
      <div>
        <MoviesPanel :movies="movies" :inline="true" />
      </div>
    </Scroller>
  </section>
</template>

<script>
import Title from "@/components//Title.vue";
import Scroller from "@/components/Scroller.vue";
import MoviesPanel from "@/components/MoviesPanel.vue";
export default {
  components: {
    Scroller,
    MoviesPanel,
    Title,
  },

  props: {
    movies: {
        type: Array,
        default: () => []
    },
    name: {
        type: String,
        required: true
    }
  },
};
</script>

<style></style>
