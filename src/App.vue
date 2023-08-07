<template>
  <div id="app">
    <PageHeader />
    <Slider />
    <main class="l-poster">
      <MovieCard
        :title="'Teste'"
        :rating="4.14"
        :liked="false"
        :watched="true"
        :saved="true"
      />
    </main>
  </div>
</template>

<script>
import PageHeader from "@/components/PageHeader.vue";
import Slider from "@/components/Slider.vue";
import MovieCard from "@/components/MovieCard.vue";
export default {
  name: "App",
  components: {
    PageHeader,
    Slider,
    MovieCard,
  },
};
</script>

<style>
@import url(./assets/styles/base/colors.css);
@import url(./assets/styles/base/fonts.css);
@import url(./assets/styles/base/normalize.css);

@import url(./assets/styles/layout/l-poster.css);
</style>
