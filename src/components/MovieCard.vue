<template>
  <MoviePoster :url="urlImage" :title="title">
    <div class="poster-inner">
      <!-- Formulários de controle -->
      <div class="poster-top d-flex justify-content-between">
        <div class="d-flex flex-column gap-2">
          <!-- Curtir/descurtir -->
          <InteractiveIcon>
            <i @click="captureLiked"
              class="bi fs-4"
              :class="{ 'bi-heart': !liked, 'bi-heart-fill': liked }"
            ></i>
          </InteractiveIcon>
          <!-- <button class="icon-button d-flex flex-column">
            </button> -->

          <!-- Marcar/desmarcar como assistido -->
          <InteractiveIcon>
            <i @click="captureWatched"
              class="bi fs-4"
              :class="{
                'bi-camera-reels': !watched,
                'bi-camera-reels-fill': watched,
              }"
            ></i>
          </InteractiveIcon>
        </div>

        <!-- salvar/removerSalvoFilme -->
        <div>
          <InteractiveIcon>
            <i @click="captureSaved"
              class="bi fs-4"
              :class="{
                ' bi-bookmark-star': !saved,
                ' bi-bookmark-star-fill': saved,
              }"
            ></i>
          </InteractiveIcon>
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
import InteractiveIcon from "@/components/InteractiveIcon.vue";
import MoviePoster from "@/components/MoviePoster.vue";
import AuthMixin from "@/mixins/AuthMixin";
import NotificationMixin from "@/mixins/NotificationMixin";
export default {
  mixins: [AuthMixin, NotificationMixin],
  components: {
    InteractiveIcon,
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
  methods: {
    captureLiked: function() {
      if(this.userLogged){
        this.liked = true
      }
      else{
        this.notifyUser({
                icon: 'x-circle',
                title: 'Ops!',
                text: "Você não está logado...",
                class: 'danger'
              })
      }
    },
    captureWatched: function() {
      if(this.userLogged){
        this.watched = true
      }
      else{
        this.notifyUser({
                icon: 'x-circle',
                title: 'Ops!',
                text: "Você não está logado...",
                class: 'danger'
              })
      }
    },
    captureSaved: function() {
      if(this.userLogged){
        this.saved = true
      }
      else{
        this.notifyUser({
                icon: 'x-circle',
                title: 'Ops!',
                text: "Você não está logado...",
                class: 'danger'
              })
      }
    }
  }
};
</script>

<style></style>
