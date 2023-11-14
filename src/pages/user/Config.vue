<template>
  <main id="config">
    <InteractiveIcon :inline="true" @click.native="$router.back()">
      <i class="bi bi-chevron-left me-2"></i>
      Voltar
    </InteractiveIcon>
    <Title tag="h2" class="h1 mt-3 mb-2">Configurações</Title>

    <div class="row row-gap-3">
      <div class="col-lg-4 col-sm-6 config-item">
        <DarkBox
          class="card text-light pointer"
          @click.native="showChangeAvatar"
        >
          <div class="card-body">
            <Title class="card-header" tag="h5">
              <i class="bi bi-person-circle me-2"></i>
              Alterar Avatar
            </Title>
            <p class="card-text small">
              Exiba-se com nossos elegantes avatares pré-definidos ou adicione uma
              foto personalizada!
            </p>
          </div>
        </DarkBox>
      </div>

      <div class="col-lg-4 col-sm-6 config-item">
        <DarkBox
          class="card text-light pointer"
        >
          <div class="card-body">
            <Title class="card-header" tag="h5">
              <i class="bi bi-incognito me-2"></i>
              Privar Perfil
            </Title>
            <p class="card-text small">
              Se você quer aproveitar nossos recursos com maior privacidade, experimente privar seu perfil.
            </p>
          </div>
        </DarkBox>
      </div>

      <div class="col-lg-4 col-sm-6 config-item">
        <DarkBox
          class="card text-light pointer"
        >
          <div class="card-body">
            <Title class="card-header" tag="h5">
              <i class="bi bi-award me-2"></i>
              Torne-se Assinante
            </Title>
            <p class="card-text small">
              Deseja apoiar o Watched e desfrutar de recursos únicos e exclusivos?
              Assine nosso plano mensal!
            </p>
          </div>
        </DarkBox>
      </div>
    </div>

    <Dialog class="modal-change-avatar">
      <div slot="content"></div>
    </Dialog>
  </main>
</template>
  
<script>
import InteractiveIcon from "@/components/InteractiveIcon.vue";
import Title from "@/components/Title.vue";
import Dialog from "@/components/Dialog.vue";
import { Modal } from "bootstrap";
import DarkBox from "@/components/DarkBox.vue";
export default {
  components: { Title, InteractiveIcon, Dialog, DarkBox },
  methods: {
    showChangeAvatar() {
      this.avatarDialog.show();
    },
  },
  mounted() {
    const modal = this.$el.querySelector(".modal-change-avatar");
    this.avatarDialog = new Modal(modal);
  },
  watch: {
    userLogged() {
      if(!this.userLogged) {
        this.notifyAuthRequired();
        this.$router.push('/');
      }
    }
  }
};
</script>
<style scoped>
.config-item:hover {
  transform: scale(1.05);
  transition: .1s transform;

}
</style>