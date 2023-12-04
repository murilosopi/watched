<template>
  <DarkBox class="post px-4 py-3">
    <div class="row align-items-center mb-2">
      <div class="col-sm-1 col-2 p-0 mb-0">
        <UserAvatar :username="post.username" />
      </div>
      <div class="col">
        <router-link
          :to="`/usuario/${post.username}`"
          class="text-white fw-bold"
        >
          <Title tag="h4">@{{ post.username }}</Title>
        </router-link>
      </div>
      <div class="col d-flex justify-content-end">

        <InteractiveIcon
          title="Excluir"
          v-if="post.username == loggedData.tag"
          @click.native="deletePost"
        >
          <i class="bi bi-trash text-danger fs-6"></i>
        </InteractiveIcon>

        <InteractiveIcon title="Denunciar" v-else>
          <i class="bi bi-flag text-danger fs-6" @click="report"></i>
        </InteractiveIcon>
      </div>
    </div>
    <div class="text-wrap text-break row">
      <p class="col-sm-11 col-10 ms-auto fs-6 mb-0 post-text">
        {{ post.texto }}
      </p>
    </div>
    <div class="row mt-2">
      <div class="col column-gap-3 d-flex justify-content-end">
        <InteractiveIcon title="Upvote">
          <i
            class="bi bi-chevron-compact-up fs-4"
            :class="{ 'text-primary': userVote == 'U' }"
            @click="vote('U', post.id)"
          ></i>
          <p class="text-center small text-white">{{ counterUp }}</p>
        </InteractiveIcon>
        <InteractiveIcon title="Downvote">
          <i
            class="bi bi-chevron-compact-down fs-4"
            :class="{ 'text-danger': userVote == 'D' }"
            @click="vote('D', post.id)"
          ></i>
          <p class="text-center small text-white">{{ counterDown }}</p>
        </InteractiveIcon>
      </div>
    </div>
  </DarkBox>
</template>
<script>
import Title from "./Title.vue";
import InteractiveIcon from "./InteractiveIcon.vue";
import UserAvatar from "./UserAvatar.vue";
import Swal from "sweetalert2";
import DarkBox from "./DarkBox.vue";

export default {
  data() {
    return {
      userVote: "",
      counterUp: 0,
      counterDown: 0,
      counterComment: 0,
    };
  },
  components: {
    Title,
    InteractiveIcon,
    UserAvatar,
    DarkBox
},
  props: {
    post: Object,
  },
  methods: {
    async report() {
      let { value } = await Swal.fire({
        input: "textarea",
        inputLabel: "Denunciar",
        inputPlaceholder: "Descreva o motivo da sua denúncia...",
        inputAttributes: {
          "aria-label": "Descreva o motivo da sua denúncia",
        },
        showCancelButton: true,
        inputValidator(value) {
          if (value.length < 15) {
            return "A sua denúncia deve conter, no mínimo, 15 caracteres.";
          }
        },
      });

      if (value)
        Swal.fire(
          "Denúncia Registrada",
          "Sua denúncia foi registrada e logo será analisada pela nossa equipe.",
          "info"
        );
    },

    deletePost() {
      Swal.fire({
        title: '<i class="bi bi-trash"></i> Excluir',
        text: 'Tem certeza que deseja excluir esta postagem? Esta ação não poderá ser desfeita...',
        showCancelButton: true,
        cancelButtonText: 'Não',
        showConfirmButton: true,
        confirmButtonText: 'Sim'
      }).then(res => {
        if(res) this.$emit('delete')
      })
    },

    vote(value, id) {
      if (!this.userLogged) {
        this.notifyAuthRequired();
        return;
      }

      if (this.userVote == value) {
        this.removeVote(id);
        return;
      }

      let previous = this.userVote;
      this.userVote = value;

      if (previous == "D") this.counterDown--;
      if (previous == "U") this.counterUp--;

      if (value == "D") this.counterDown++;
      if (value == "U") this.counterUp++;


      const params = {
        voto: value,
        id,
      };

      this.$api.post("/postagem/votar", params).then((res) => {
        const response = res.data;

        if (!response.sucesso) {
          if (value == "D") this.counterDown--;
          if (value == "U") this.counterUp--;

          this.userVote = previous;
        }
      });
    },

    removeVote(id) {
      if (!this.userLogged) {
        this.notifyAuthRequired();
        return;
      }
      
      let previous = this.userVote;
      
      if (previous == "D") this.counterDown--;
      if (previous == "U") this.counterUp--;
      
      this.userVote = null;

      const params = { id };
      this.$api.post("/postagem/remover-voto", params).then((res) => {
        const response = res.data;

        if (!response.sucesso) {
          if (previous == "D") this.counterDown++;
          if (previous == "U") this.counterUp++;

          this.userVote = previous;
        }
      });
    },
  },
  created() {
    this.userVote = this.post.votoUsuario;
    this.counterDown = this.post.downvotes;
    this.counterUp = this.post.upvotes;
  },
};
</script>
<style scoped>
.post {
  border-bottom: 2px solid rgba(255, 255, 255, 0.086);
}
.post-text {
  white-space: pre-wrap;
}
</style>
