<template>
  <MoviePoster :url="urlImage" :title="title">
    <div class="poster-inner">
      <!-- Formulários de controle -->
      <div class="poster-top d-flex justify-content-between">
        <div class="d-flex flex-column gap-2">
          <!-- Curtir/descurtir -->
          <IconButton>
            <i
              class="bi"
              :class="{ 'bi-heart': !liked, 'bi-heart-fill': liked }"
            ></i>
          </IconButton>
          <!-- <button class="icon-button d-flex flex-column">
            </button> -->

          <!-- Marcar/desmarcar como assistido -->
          <IconButton>
            <i
              class="bi"
              :class="{
                'bi-camera-reels': !watched,
                'bi-camera-reels-fill': watched,
              }"
            ></i>
          </IconButton>
        </div>

        <!-- salvar/removerSalvoFilme -->
        <div>
          <IconButton>
            <i
              class="bi"
              :class="{
                ' bi-bookmark-star': !saved,
                ' bi-bookmark-star-fill': saved,
              }"
            ></i>
          </IconButton>
        </div>
      </div>
      <!-- Link para o filme -->
      <router-link :to="`/filme/${id}`">
        <a class="fw-normal p-2 text-light">
          <div class="poster-bottom">
            <h3 class="poster-title text-truncate">{{ title }}</h3>
            <span class="poster-rating">
              <i class="bi bi-star-half"></i>
              {{ rating.toFixed(1) }}
            </span>
          </div>
        </a>
      </router-link>
    </div>
  </MoviePoster>
</template>

<script>
import IconButton from "@/components/IconButton.vue";
import MoviePoster from "@/components/MoviePoster.vue";
export default {
  components: {
    IconButton,
    MoviePoster,
  },
  props: {
    movie: Object,
  },
  data() {
    return {
      title: this.movie.titulo,
      rating: Number(this.movie.nota),
      urlImage: this.movie.cartaz,
      liked: this.movie.liked,
      saved: this.movie.saved,
      watched: this.movie.watched,
      id: this.movie.id,
    };
  },
};
</script>

<style></style>
