<template>
  <Dialog class="modal-change-avatar">
    <div slot="content">
      <UploadImage @newFile="uploadCustomAvatar" />
    </div>
  </Dialog>
</template>

<script>
import Dialog from "@/components/Dialog.vue";
import UploadImage from "@/components/UploadImage.vue";
import Swal from "sweetalert2";

export default {
  components: { Dialog, UploadImage },
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
          console.log(res)
        })
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
