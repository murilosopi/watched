<template>
  <Dialog class="modal-change-avatar" size="lg" :customHeader="true">
    <template slot="header">
      <Title tag="h5" class="h2">
        <i class="bi bi-camera me-2"></i>
        Foto de Perfil
      </Title>
      <InteractiveIcon data-bs-dismiss="modal" aria-label="Close">
        <i class="bi bi-x-lg text-danger"></i>
      </InteractiveIcon>
    </template>
    <div slot="content">
      <div class="row mb-2">
        <div class="col-12">
          <p>Abaixo você pode enviar uma imagem válida de até <strong>4 MB</strong> e visualizar o resultado da alteração ao lado.</p>
        </div>
      </div>
      <div class="row">
        <div
          class="col-lg-3 col-md-5 col-sm-6 col-8 mx-auto m-sm-0 text-center"
        >
          <Title tag="p" class="opacity-75 h5 mb-2">Envie uma imagem: </Title>
          <div class="ratio ratio-1x1 m-auto">
            <UploadImage @newFile="uploadCustomAvatar" class="rounded-circle" />
          </div>
        </div>

        <div
          class="col-lg-3 col-md-5 col-sm-6 col-8 mx-auto m-sm-0 text-center"
          v-if="userHasAvatar"
        >
          <Title tag="p" class="opacity-75 h5 mb-2">Sua Foto</Title>
          <UserAvatar :key="updateCounter" :username="loggedData.tag" />
        </div>
      </div>
    </div>  
  </Dialog>
</template>

<script>
import Dialog from "@/components/Dialog.vue";
import InteractiveIcon from "@/components/InteractiveIcon.vue";
import Title from "@/components/Title.vue";
import UploadImage from "@/components/UploadImage.vue";
import UserAvatar from "@/components/UserAvatar.vue";
import Swal from "sweetalert2";

export default {
  components: { Dialog, UploadImage, UserAvatar, Title, InteractiveIcon },
  data() {
    return {
      userHasAvatar: false,
      updateCounter: 0,
    };
  },
  methods: {
    uploadCustomAvatar(file) {
      const maxSize = 1024 * 1024 * 4; // 4 MBs

      if (file.size > maxSize) {
        Swal.fire(
          "OPS!",
          "O tamanho máximo do arquivo deve ser de 4 MB.",
          "warning"
        );
      } else {
        const formData = new FormData();
        formData.append("avatar", file);
        const headers = { "Content-Type": "multipart/form-data" };

        this.$api
          .post("/usuario/avatar-personalizado", formData, { headers })
          .then((res) => {
            const response = res.data;

            if (response.sucesso) {
              this.userHasAvatar = true;

              this.updateCounter++;
            } else {
              Swal.fire(
                "OPS!",
                response.descricao ||
                  "Ocorreu um problema... Tente novamente mais tarde.",
                "error"
              );
            }
          })
          .catch((e) => console.log(e));
      }
    },
  },
};
</script>

<style scoped>
.user-photo {
  aspect-ratio: 1 / 1;
  object-fit: cover;
  border-radius: 50%;
  width: 100%;
  margin: auto;
  display: block;
}

@media (min-width: 768px) {
  .user-photo {
    width: 80%;
  }
}

@media (min-width: 992px) {
  .user-photo {
    width: 60%;
  }
}
</style>
