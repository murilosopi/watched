<template>
  <div class="user-profile">
    <DarkBox class="p-4">
      <div class="row">
        <div class="col-9 col-sm-8 col-md-6 col-lg-3 mb-4 mb-lg-0 mx-auto">
          <UserAvatar :username="username" />
        </div>

        <article class="col-lg-6 my-auto">
          <Title tag="h2"> @{{ username }} </Title>

          <div class="col-5" v-if="false">
            <ButtonCustom class="position-relative">
              Adicione um texto sobre você
              <span
                class="position-absolute top-0 start-100 translate-middle p-2 bg-danger rounded-circle"
              ></span>
            </ButtonCustom>
          </div>
          <template v-else>
            <p
              class="text-break w-100"
              :class="{ placeholder: !alreadyLoaded }"
              style="white-space: pre-wrap"
            >
              {{ biography }}
            </p>
            <div class="col-7">
              <ButtonCustom>
                Alterar
                <i class="bi bi-pencil-square fs-5"></i>
              </ButtonCustom>
            </div>
          </template>
        </article>

        <UserStats :username="username" />
      </div>
    </DarkBox>

    <section class="mt-5" v-if="reviews.length">
      <Title tag="h3" class="h2">
        Resenhas Recentes
        <i class="bi bi-clock-history ms-2"></i>
      </Title>
      <UserReviews :reviews="reviews"/>
    </section>
  </div>
</template>

<script>
import PageMixin from "@/mixins/PageMixin";
import DarkBox from "@/components/DarkBox.vue";
import UserAvatar from "@/components/UserAvatar.vue";
import ButtonCustom from "@/components/ButtonCustom.vue";
import Title from "@/components/Title.vue";
import UserStats from "./UserStats.vue";
import UserReviews from "./UserReviews.vue";

export default {
  mixins: [PageMixin],
  components: {
    DarkBox,
    UserAvatar,
    ButtonCustom,
    Title,
    UserStats,
    UserReviews,
  },

  data() {
    return {
      biography: "",
      reviews: [],
    };
  },

  props: ["username"],

  computed: {
    alreadyLoaded() {
      return false;
    },
  },

  methods: {
    getReviews(offset = 0, limit = 0) {
      const params = { offset, limit };
      this.$api
        .get("/obter-resenhas-usuario", { params })
        .then((res) => {
          let response = res.data;

          if (response.sucesso) {
            response.dados.forEach((review) => {
              this.reviews.push({
                id: review.id,
                reaction: review.reacao,
                movieId: review.filme,
                movieTitle: review.tituloFilme,
                text: review.descricao,
              });
            });
          }
        })
        .catch(() => {});
    },
  },

  beforeRouteEnter(to, from, next) {
    next((page) => {
      page.changeFavicon("usuario", "svg");
    });
  },
};
</script>

<style></style>
