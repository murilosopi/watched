<template>
  <div
    id="intro-carousel"
    class="carousel slide py-5 px-1"
    data-bs-ride="carousel"
  >
    <div class="carousel-inner w-75 mx-auto text-center">

      <div v-for="(slide, index) in slides" :key="index" class="carousel-item" :class="{active: index === 0}" data-bs-interval="5000">
        <h4><i :class="slide.icon"></i></h4>
        <p class="px-5 fs-3">{{ slide.text }}</p>
      </div>
    </div>

    <button
      class="carousel-control-prev ps-5"
      type="button"
      data-bs-target="#intro-carousel"
      data-bs-slide="prev"
    >
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
    </button>
    
    <button
      class="carousel-control-next pe-5"
      type="button"
      data-bs-target="#intro-carousel"
      data-bs-slide="next"
    >
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Próximo</span>
    </button>

    <div class="carousel-indicators">
      <button v-for="(item, idx) in slides" :key="idx"
        type="button"
        data-bs-target="#intro-carousel"
        :data-bs-slide-to="idx"
        :class="{active: idx === 0}"
        :aria-current="idx === 0"
        :aria-label="`Slide ${idx+1}`"
      ></button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      slides: [
        {
          icon: 'bi bi-share-fill',
          text: 'Compartilhe com seus amigos a sua resenha!'
        },
        {
          icon: 'bi bi-calendar-heart',
          text: 'Registre os seus filmes favoritos!'
        },
        {
          icon: 'bi bi-clock-history',
          text: 'Adicione seus últimos assistidos!'
        },
        {
          icon: 'bi bi-fire',
          text: 'Fique por dentro do que está em alta!'
        }
      ]
    }
  }
};
</script>

<style></style>
