<template>
  <Dialog class="modal-change-avatar" size="lg">
    <div slot="content">
      <div class="row">
        <div class="col-lg-3 col-md-5 col-sm-6 col-8 mx-auto m-sm-0">
          <UserAvatar v-if="userHasAvatar" :username="loggedData.tag"/>

          <div class="ratio ratio-1x1 m-auto" v-else>
            <UploadImage @newFile="uploadCustomAvatar" class="rounded-circle"/>
          </div>
        </div>
      </div>
    </div>
  </Dialog>
</template>

<script>
import Dialog from "@/components/Dialog.vue";
import UploadImage from "@/components/UploadImage.vue";
import UserAvatar from "@/components/UserAvatar.vue";
import Swal from "sweetalert2";

export default {
  components: { Dialog, UploadImage, UserAvatar },
  data() { 
    return {
      userHasAvatar: false
    }
  },
  methods: {
    uploadCustomAvatar(file) {
      const maxSize = 1024 * 1024 * 4; // 4 MBs
      
      if (file.size > maxSize) {
        Swal.fire('OPS!', 'O tamanho máximo do arquivo deve ser de 4 MB.', 'warning');
      } else {

        const formData = new FormData();
        formData.append('avatar', file);
        const headers = { 'Content-Type': 'multipart/form-data' };

        this.$api.post('/usuario/avatar-personalizado', formData, { headers }).then((res) => {

          const response = res.data;

          if(response.sucesso) {
            this.userHasAvatar = true;
          } else {
            Swal.fire('OPS!', response.descricao || 'Ocorreu um problema... Tente novamente mais tarde.', 'error');
          }
        }).catch(e => console.log(e));
      }
    }
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
