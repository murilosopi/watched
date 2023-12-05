<template>
  <article class="comment">
    <div class="row align-items-center mb-2">
      <div class="col-1 p-0 mb-0">
        <UserAvatar :username="comment.user" />
      </div>

      <div class="col">
        <router-link
          :to="`/usuario/${comment.user}`"
          class="text-white"
        >
          <Title tag="h4" class="fw-bold">@{{ comment.user }}</Title>
        </router-link>
      </div>

      <div class="col d-flex">
        <StarRating :value="comment.rating" class="ms-auto me-3" />

        <template v-if="userLogged">
          <InteractiveIcon
            title="Excluir"
            v-if="comment.user == loggedData.tag"
            @click.native="deleteComment"
          >
            <i class="bi bi-trash text-danger fs-6"></i>
          </InteractiveIcon>

          <InteractiveIcon title="Denunciar" v-else @click.native="report">
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
import UserAvatar from "./UserAvatar.vue";
export default {
  components: {
    Title,
    StarRating,
    InteractiveIcon,
    UserAvatar
},
  props: {
    comment: Object,
  },
  methods: {
    deleteComment() {
      this.$emit('delete');
    },
    report() {
      this.$emit('report');
    }
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
