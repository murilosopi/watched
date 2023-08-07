<template>
  <article class="poster-card">
    <img
      class="poster-img w-100"
      src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRcYujNBQq53Q8zvISFhnguM42cFndgo-8UQso2ZMZREnEhhMQW"
      alt="Cartaz do filme [ NOME FILME ]"
    />

    <div class="poster-inner">
      <!-- Formulários de controle -->
      <div class="poster-top d-flex justify-content-between">
        <div class="d-flex flex-column gap-2">
          <!-- Curtir/descurtir -->
          <IconButton>
            <i class="bi" :class="{'bi-heart': !liked, 'bi-heart-fill': liked}"></i>
          </IconButton>
          <!-- <button class="icon-button d-flex flex-column">
          </button> -->

          <!-- Marcar/desmarcar como assistido -->
          <IconButton>
            <i class="bi" :class="{'bi-camera-reels': !watched, 'bi-camera-reels-fill': watched}"></i>
          </IconButton>
        </div>

        <!-- salvar/removerSalvoFilme -->
        <div>
          <IconButton>
            <i class="bi" :class="{' bi-bookmark-star': !watched, ' bi-bookmark-star-fill': watched}"></i>
          </IconButton>
        </div>
      </div>
      <!-- Link para o filme -->
      <a class="fw-normal p-2" href="sobre-filme?id=<?= $filme['id'] ?>">
        <div class="poster-bottom">
          <h3 class="poster-title text-truncate">{{ title }}</h3>
          <span class="poster-rating">
            <i class="bi bi-star-half"></i>
            {{ rating.toFixed(1) }}
          </span>
        </div>
      </a>
    </div>
  </article>
</template>

<script>
import IconButton from "@/components/IconButton.vue";
export default {
  components: {
    IconButton,
  },
  props: {
    title: String,
    rating: Number,
    liked: Boolean,
    saved: Boolean,
    watched: Boolean,
  },
};
</script>

<style>
.poster-card {
  aspect-ratio: 4 / 6;
  border-bottom: 2px solid white;
  transition: 200ms cubic-bezier(0.445, 0.05, 0.55, 0.95);
}

.poster-card:hover {
  transform: scale(1.08);
}

.poster-card .poster-inner {
  visibility: hidden;
  opacity: 0;
  transition: 250ms;
  padding: 0.8rem;
}

.poster-card:hover .poster-inner {
  box-shadow: inset 0 0 5rem 3rem rgba(0, 0, 0, 0.5);
  visibility: visible;
  opacity: 1;
}

.poster-card .poster-title {
  font-size: 1.1rem;
}

.poster-card .poster-rating {
  font-size: 1rem;
}
</style>
