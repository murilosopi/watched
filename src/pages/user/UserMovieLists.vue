<template>
  <div class="user-movie-lists">
    <template v-for="(list, idx) in interactionList">
      <MovieListSection
        :key="idx"
        :name="list.name"
        :movies="list.movies"
      >
        <i
          :class="{
            'bi-heart': idx == 'liked',
            'bi-camera-reels': idx == 'watched',
            'bi-bookmark-star': idx == 'saved',
          }"
          class="bi me-2 fs-2"
          slot="icon"
        ></i>
      </MovieListSection>
      <hr :key="`_${idx}`">
    </template>

    <template v-for="(list, idx) in lists">
      <MovieListSection
        :key="list.id"
        :name="list.name"
        :movies="list.movies"
        :class="idx + 1 == list.length ? 'mb-3' : ''"
      >return
        <i class="bi bi-heart me-2 fs-5" slot="icon"></i>
      </MovieListSection>
      <hr :key="list.id">
    </template>
  </div>
</template>

<script>
import MovieListSection from "@/components/MovieListSection.vue";

export default {
  props: ["uid", "lists"],
  data() {
    return {
      interactionList: {
        liked: {
          name: "Curtidos",
          movies: []
        },
        watched: {
          name: "Assistidos",
          movies: []
        },
        saved: {
          name: "Salvos",
          movies: []
        },
      },
    };
  },
  components: {
    MovieListSection,
  },
  methods: {
    getInteractionLists() {
      this.getLikedMovies();
      this.getWatchedMovies();
      this.getSavedMovies();
    },

    getLikedMovies() {
      const params = { uid: this.uid };

      this.$api
        .get("/lista/curtidos", { params })
        .then((res) => {
          let response = res.data;

          if (response.sucesso) {
            response.dados.forEach(async (id) => {
              const movieInfo = await this.getMovieInfo(id);

              if(movieInfo) this.interactionList.liked.movies.push(movieInfo);
            });
          }
        })
        .catch(() => {});
    },

    getWatchedMovies() {
      const params = { uid: this.uid };

      this.$api
        .get("/lista/assistidos", { params })
        .then((res) => {
          let response = res.data;

          if (response.sucesso) {
            response.dados.forEach(async (id) => {
              const movieInfo = await this.getMovieInfo(id);

              if(movieInfo) this.interactionList.watched.movies.push(movieInfo);
            });
          }
        })
        .catch(() => {});
    },

    getSavedMovies() {
      const params = { uid: this.uid };

      this.$api
        .get("/lista/salvos", { params })
        .then((res) => {
          let response = res.data;

          if (response.sucesso) {
            response.dados.forEach(async (id) => {
              const movieInfo = await this.getMovieInfo(id);

              if(movieInfo) this.interactionList.saved.movies.push(movieInfo);
            });
          }
        })
        .catch(() => {});
    },

    getMovieInfo(id) {
      const params = { id }
      return this.$api
        .get("/filme", { params })
        .then((res) => {
          let response = res.data;

          return response.sucesso ? response.dados : false;
        })
        .catch(() => {});
    },
  },
  watch: {
    uid() {
      this.getInteractionLists();
    }
  }
};
</script>

<style></style>
