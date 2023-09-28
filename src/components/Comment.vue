<template>
  <article class="comment">
    <div class="row align-items-center mb-2">
      <figure class="col-1 p-0 mb-0">
        <img
          class="user-photo w-100"
          src="/assets/img/users/default.svg"
          :alt="`Foto de perfil de @${comment.user}`"
        />
      </figure>

      <div class="col">
        <router-link
          :to="`/usuario/${comment.user}`"
          class="text-white fw-bold"
        >
          <Title tag="h4">@{{ comment.user }}</Title>
        </router-link>
      </div>

      <div class="col d-flex">
        <StarRating :value="comment.rating" class="ms-auto me-3" />

        <template v-if="userLogged">
          <InteractiveIcon
            title="Excluir"
            v-if="comment.user == loggedData.tag"
            @click.native="deleteReview"
          >
            <i class="bi bi-trash text-danger fs-6"></i>
          </InteractiveIcon>

          <InteractiveIcon title="Denunciar" v-else>
            <i class="bi bi-flag text-danger fs-6"></i>
          </InteractiveIcon>
        </template>
      </div>
    </div>
    <div class="col-11 ms-auto">
      <p class="fs-6 mb-0 pre comment-text">
        {{ comment.text }}
      </p>
    </div>
    <div class="d-flex mt-2">
      <p class="ms-auto small text-white-50">
        Última modificação em {{ comment.date }}
      </p>
    </div>
  </article>
</template>

<script>
import Title from "./Title.vue";
import StarRating from "./StarRating.vue";
import InteractiveIcon from "./InteractiveIcon.vue";
export default {
  components: {
    Title,
    StarRating,
    InteractiveIcon,
  },
  props: {
    comment: Object,
  },
  methods: {
    deleteReview() {
      const params = {
        id: this.comment.id,
      };

      this.$api.post("excluir-resenha", params).then((res) => {
        const response = res.data;

        if (response.sucesso) {
          this.notifyUser({
            icon: "check",
            title: "Sucesso",
            text: "a resenha foi excluída.",
            class: "success",
          });
        } else {
          throw response;
        }
      }).catch(() => {
        this.notifyUser({
          icon: "x-octagon",
          title: "Erro",
          text: "não foi possível excluir a resenha.",
          class: "danger",
        });
      });
    },
  },
};
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
