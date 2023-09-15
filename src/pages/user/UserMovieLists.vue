<template>
  <div class="user-movie-lists">
    <MovieListSection
      v-for="(list, idx) in interactionList"
      :key="list.name"
      :name="idx"
      :movies="list.movies"
    >
      <i
        :class="{
          'bi-heart': idx == 'liked',
          'bi-camera-reels': idx == 'watched',
          'bi-bookmark-star': idx == 'saved',
        }"
        class="bi me-2 fs-5"
        slot="icon"
      ></i>
    </MovieListSection>

    <MovieListSection
      v-for="(list, idx) in lists"
      :key="list.id"
      :name="list.name"
      :movies="list.movies"
      :class="idx + 1 == list.length ? 'mb-3' : ''"
    >
      <i class="bi bi-heart me-2 fs-5" slot="icon"></i>
    </MovieListSection>
  </div>
</template>

<script>
import MovieListSection from "@/components/MovieListSection.vue";

export default {
  props: ["uid", "lists"],
  data() {
    return {
      interactionList: {},
    };
  },
  components: {
    MovieListSection,
  },
  methods: {
    getInteractionLists() {
      // request to api
      this.interactionList.liked = [];
      this.interactionList.watched = [];
      this.interactionList.saved = [];
    },
  },
  created() {},
};
</script>

<style></style>
