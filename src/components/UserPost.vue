<template>
  <article class="userpost">
    <div class="row align-items-center mb-2">
      <div class="col-sm-1 col-2 p-0 mb-0">
        <UserAvatar :username="userpost.username" />
      </div>
      <div class="col">
        <router-link
          :to="`/usuario/${userpost.username}`"
          class="text-white fw-bold"
        >
          <Title tag="h4">@{{ userpost.username }}</Title>
        </router-link>
      </div>
      <div class="col d-flex justify-content-end">
        <InteractiveIcon title="Denunciar">
          <i class="bi bi-flag text-danger fs-6" @click="report"></i>
        </InteractiveIcon>
      </div>
    </div>
    <div class="text-wrap text-break row">
      <p class="col-sm-11 col-10 ms-auto fs-6 mb-0 userpost-text">
        {{ userpost.texto }}
      </p>
    </div>
    <div class="row mt-2">
      <div class="col column-gap-3 d-flex justify-content-end">
        <InteractiveIcon title="Upvote">
          <i
            class="bi bi-chevron-compact-up text-primary fs-4"
            @click="addUpvote"
          ></i>
          <p class="text-center small text-white">{{ counterUp }}</p>
        </InteractiveIcon>
        <InteractiveIcon title="Downvote">
          <i
            class="bi bi-chevron-compact-down text-danger fs-4"
            @click="addDownvote"
          ></i>
          <p class="text-center small text-white">{{ counterDown }}</p>
        </InteractiveIcon>
      </div>
    </div>
  </article>
</template>
<script>
import Title from "./Title.vue";
import InteractiveIcon from "./InteractiveIcon.vue";
import UserAvatar from "./UserAvatar.vue";
import Swal from "sweetalert2";

export default {
  data() {
    return {
      counterUp: 0,
      counterDown: 0,
      counterComment: 0,
    };
  },
  components: {
    Title,
    InteractiveIcon,
    UserAvatar,
  },
  props: {
    userpost: Object,
  },
  methods: {
    async report() {
      let { value } = await Swal.fire({
        input: "textarea",
        inputLabel: "Denunciar",
        inputPlaceholder: "Descreva o motivo da sua denúncia...",
        inputAttributes: {
          "aria-label": "Descreva o motivo da sua denúncia"
        },
        showCancelButton: true,
        inputValidator(value) {
          if(value.length < 15) {
            return 'A sua denúncia deve conter, no mínimo, 15 caracteres.'
          }
        }
      });

      if(value) Swal.fire('Denúncia Registrada', 'Sua denúncia foi registrada e logo será analisada pela nossa equipe.', 'info')
    },
    addUpvote() {},
    addDownvote() {},
  },
};
</script>
<style scoped>
.userpost {
  border-bottom: 2px solid rgba(255, 255, 255, 0.086);
}
.userpost-text {
  white-space: pre-wrap;
}
</style>
