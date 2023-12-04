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
              Exiba-se com nossos elegantes avatares pré-definidos ou adicione
              uma foto personalizada!
            </p>
          </div>
        </DarkBox>
      </div>

      <div class="col-lg-4 col-sm-6 config-item" v-if="!loggedData.private">
        <DarkBox class="card text-light pointer" @click.native="changePrivacy">
          <div class="card-body">
            <Title class="card-header" tag="h5">
              <i class="bi bi-incognito me-2"></i>
              Privar Perfil
            </Title>
            <p class="card-text small">
              Se você quer aproveitar nossos recursos com maior privacidade,
              experimente privar seu perfil.
            </p>
          </div>
        </DarkBox>
      </div>

      <div class="col-lg-4 col-sm-6 config-item" v-else>
        <DarkBox
          class="card text-light pointer"
          @click.native="changePrivacy"
        >
          <div class="card-body">
            <Title class="card-header" tag="h5">
              <i class="bi bi-incognito me-2"></i>
              Tornar Perfil Público
            </Title>
            <p class="card-text small">
              Deixe seu perfil público e disponível para todos da comunidade Watched vislumbrarem o que você tem para compartilhar.
            </p>
          </div>
        </DarkBox>
      </div>

      <div class="col-lg-4 col-sm-6 config-item">
        <DarkBox class="card text-light pointer" @click.native="showPremiumAd">
          <div class="card-body">
            <Title class="card-header" tag="h5">
              <i class="bi bi-award me-2"></i>
              Torne-se Assinante
            </Title>
            <p class="card-text small">
              Deseja apoiar o Watched e desfrutar de recursos únicos e
              exclusivos? Assine nosso plano mensal!
            </p>
          </div>
        </DarkBox>
      </div>
    </div>
    <AvatarDialog class="modal-change-avatar" />
    <PremiumAd class="modal-premium-ad" />
  </main>
</template>

<script>
import InteractiveIcon from "@/components/InteractiveIcon.vue";
import Title from "@/components/Title.vue";
import { Modal } from "bootstrap";
import DarkBox from "@/components/DarkBox.vue";
import AvatarDialog from "./AvatarDialog.vue";
import PageMixin from "@/mixins/PageMixin";
import PremiumAd from "./PremiumAd.vue";
import { mapMutations } from "vuex";
import Swal from 'sweetalert2';
export default {
  components: { Title, InteractiveIcon, DarkBox, AvatarDialog, PremiumAd },
  mixins: [PageMixin],
  methods: {
    ...mapMutations("auth", ["setPrivacy"]),

    showChangeAvatar() {
      this.avatarDialog.show();
    },

    showPremiumAd() {
      this.premiumAd.show();
    },

    async changePrivacy() {

      const { isConfirmed } = await Swal.fire({
        icon: 'warning',
        title: '<i class="bi bi-lock"></i> Atenção',
        text: 'A exibição de seu perfil e respectivas postagens e resenhas estão prestes a serem alteradas. Está ciente e deseja continuar?',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não',
        showCancelButton: true,
      })
      
      if(!isConfirmed) return;

      const newPrivacy = !this.loggedData.private;

      this.$api.post("/usuario/alterar-privacidade").then((res) => {
        const response = res.data;

        if (response.sucesso) {
          this.setPrivacy(newPrivacy);
        } else {
          this.notifyUser({
            icon: "x-circle",
            title: "Ops",
            text: `não foi possível ${
              newPrivacy ? "privar seu perfil" : "tornar seu perfil público"
            }... Tente novamente mais tarde.`,
            class: "warning",
          });
        }
      });
    },
  },
  mounted() {
    this.avatarDialog = new Modal(
      this.$el.querySelector(".modal-change-avatar")
    );
    this.premiumAd = new Modal(this.$el.querySelector(".modal-premium-ad"));
  },
  watch: {
    userLogged() {
      if (!this.userLogged) {
        this.notifyAuthRequired();
        this.$router.push("/");
      }
    },
  },
  created() {
    this.changeFavicon("config", "svg");
    this.changePageTitle("Configurações");
  },
};
</script>
<style scoped>
.config-item:hover {
  transform: scale(1.05);
  transition: 0.1s transform;
}
</style>
