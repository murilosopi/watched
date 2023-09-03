<template>
  <article class="comment">
    <div class="row align-items-center">
      <figure class="col-1 p-0 mb-0">
        <img class="user-photo w-100" src="/assets/img/users/default.svg" :alt="`Foto de perfil de @${review.user}`">
      </figure>

      <div class="col">
        <router-link :to="`/usuario/${review.user}`" class="text-white fw-bold">
          <Title tag="h4">@{{ review.user }}</Title>
        </router-link>
      </div>

      <div class="col d-flex">
        <StarRating v-if="Number(review.rating)" :value="review.rating" class="ms-auto me-3" />

        <InteractiveIcon title="Denunciar">
          <i class="bi bi-flag text-danger small"></i>
        </InteractiveIcon>
      </div>
    </div>
    <div class="col-11 ms-auto">      
      <p class="fs-6 mb-0 pre comment-text">
        {{ review.text }}
      </p>
    </div>
    <div class="d-flex mt-2">
      <p class="ms-auto small text-white-50">Última modificação em {{ review.date }}</p>
    </div>

  </article>
</template>

<script>
import Title from './Title.vue';
import StarRating from './StarRating.vue';
import InteractiveIcon from './InteractiveIcon.vue';
export default {
  components: {
    Title,
    StarRating,
    InteractiveIcon
  },
  props: {
    review: Object
  },
}
</script>

<style>
.comment .comment-text {
  white-space: pre-wrap;
}

.comment .comment-photo {
  aspect-ratio: 1 / 1;
  object-fit: cover;
  border-radius: 50%;
}
</style>