<template>
  <div class="user-profile">
    <DarkBox class="p-4">
      <div class="row">
        <div class="col-9 col-sm-8 col-md-6 col-lg-3 mb-4 mb-lg-0 mx-auto">
          <UserAvatar :username="username" />
        </div>

        <article class="col-lg-6 my-auto">
          <Title tag="h2"> @{{ username }} </Title>

          <p
            class="text-break w-100"
            :class="{ placeholder: !loadedInfo }"
            style="white-space: pre-wrap"
          >
            {{ about }}
          </p>
          <div
            class="col d-flex gap-3 small"
            :class="{ 'placeholder py-4': !loadedInfo }"
          >
            <template v-if="loadedInfo">

              <template v-if="loggedData.tag == username">
                
                <ButtonCustom v-if="about" data-bs-toggle="modal" data-bs-target="#about-user" @click.native="openAboutEdit" >
                  Alterar
                  <i class="bi bi-pencil-square fs-5"></i>
                </ButtonCustom>

                <ButtonCustom class="position-relative" variant="azul" v-else data-bs-toggle="modal" data-bs-target="#about-user">
                  Adicione um texto sobre você
                  <span
                    class="position-absolute top-0 start-100 translate-middle p-2 bg-danger rounded-circle"
                  ></span>
                </ButtonCustom>

                <ButtonCustom @click.native="goToConfig">
                  Configurações
                  <i class="bi bi-gear ms-2 fs-5"></i>
                </ButtonCustom>
              </template>

              <template v-else>
                <ButtonCustom>
                  <i class="bi bi-chat-left fs-5"></i>
                  Bate-Papo
                </ButtonCustom>

                <ButtonCustom variant="azul">
                  <i class="bi bi-plus-lg fs-5"></i>
                  Seguir
                </ButtonCustom>
              </template>
            </template>
          </div>
        </article>

        <UserStats :id="id" />
      </div>
    </DarkBox>

    <section class="mt-5" v-if="reviews.length">
      <Title tag="h3" class="h2 mb-3">
        Resenhas Recentes
        <i class="bi bi-clock-history ms-2"></i>
      </Title>
      <UserReviews :reviews="reviews" />
    </section>

    <UserMovieLists :lists="lists" />

    <Dialog id="about-user" v-if="loadedInfo">
      <InputCustom slot="content" :icon="false">
        <textarea slot="input" maxlength="240" class="form-control" id="message-text" rows="5" name="sobre" v-model="newAbout"></textarea>
      </InputCustom>

      <div slot="footer" class="container">
        <div class="row">
          <div class="col-6">
            <ButtonCustom data-bs-dismiss="modal" variant="azul">
              Fechar
            </ButtonCustom>
          </div>
          <div class="col-6">
            <ButtonCustom data-bs-dismiss="modal" @click="updateAbout">
              Salvar
            </ButtonCustom>
          </div>
        </div>
      </div>
    </Dialog>
  </div>
</template>

<script>
import PageMixin from "@/mixins/PageMixin";
import DarkBox from "@/components/DarkBox.vue";
import UserAvatar from "@/components/UserAvatar.vue";
import ButtonCustom from "@/components/ButtonCustom.vue";
import Title from "@/components/Title.vue";
import UserMovieLists from "./UserMovieLists.vue";
import UserStats from "./UserStats.vue";
import UserReviews from "./UserReviews.vue";
import Dialog from "@/components/Dialog.vue";
import InputCustom from "@/components/InputCustom.vue";

export default {
  mixins: [PageMixin],
  components: {
    DarkBox,
    UserAvatar,
    ButtonCustom,
    Title,
    UserStats,
    UserReviews,
    UserMovieLists,
    Dialog,
    InputCustom
  },

  data() {
    return {
      about: "",
      id: "",
      reviews: [],
      lists: [],
      stats: [],

      newAbout: '',
    };
  },

  props: ["username"],

  computed: {
    loadedInfo() {
      return this.id.length != 0;
    },
  },

  methods: {
    getReviews(offset = 0, limit = 0) {
      if (!this.loadedInfo) return;

      const params = { offset, limit, uid: this.id };
      this.$api
        .get("/obter-resenhas-usuario", { params })
        .then((res) => {
          let response = res.data;

          if (response.sucesso) {
            response.dados.forEach((review) => {
              this.reviews.push({
                id: review.id,
                reaction: {
                  icon: review.iconeReacao,
                  description: review.descricaoReacao,
                  id: review.idReacao,
                },
                movieId: review.filme,
                movieTitle: review.tituloFilme,
                text: review.descricao,
              });
            });
          }
        })
        .catch(() => {});
    },

    getLists() {},

    getInfo() {
      const params = { username: this.username };
      return this.$api
        .get("/obter-informacoes-perfil", { params })
        .then((res) => {
          let response = res.data;

          if (response.sucesso) {
            const data = response.dados;

            this.id = data.id;
            this.about = data.sobre;
            this.name = data.nome;
            this.subscriber = data.assinante;

            this.changePageTitle(`@${this.username}`);
            this.getReviews();
          } else {
            throw "Usuário não encontrado";
          }
        })
        .catch(() => {
          this.$router.push("/erro");
        });
    },

    openAboutEdit() {
      this.newAbout = this.loggedData.about;
    },

    updateAbout() {},

    goToConfig() {
      this.$router.push('/configuracoes')
    }
  },

  beforeRouteEnter(to, from, next) {
    next((page) => {
      page.changeFavicon("usuario", "svg");
    });
  },

  created() {
    this.getInfo();
  },
};
</script>

<style></style>
