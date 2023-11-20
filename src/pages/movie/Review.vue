<template>
  <section class="col" v-if="list.length || userLogged && !existsUserReview">
    <Title tag="h3" class="text-center">
      Opinião do Público
      <i class="bi bi-chat-left-text"></i>&nbsp;
    </Title>
    <hr class="w-25 mx-auto" />
    <Transition
      leave-active-class="animate__animated animate__fadeOut animate__faster"
    >
      <ReviewForm
        :movie="movie"
        v-if="!existsUserReview"
        @newReview="newReview"
      />
    </Transition>

    <div class="row justify-content-evenly mt-4">
      <div class="col-md-6 mb-3 mb-md-0 ps-md-0">
        <RatingChart :movie="movie" />
      </div>
      <div class="col-md-6 pe-md-0">
        <ReactionChart :movie="movie" />
      </div>
    </div>


    <ReviewsList class="mt-5" :reviews="list" />
  </section>
</template>

<script>
import Title from "@/components/Title.vue";
import ReviewsList from "./ReviewsList.vue";
import ReviewForm from "./ReviewForm.vue";
import RatingChart from "./RatingChart.vue";
import ReactionChart from "./ReactionChart.vue";

export default {
  components: {
    Title,
    ReviewsList,
    ReviewForm,
    RatingChart,
    ReactionChart
},

  props: ["movie"],

  data() {
    return {
      list: [],
      existsUserReview: false,
    };
  },

  methods: {
    getReviews() {
      const params = { filme: this.movie };
      this.$api.get("/obter-resenhas-filme", { params }).then((res) => {
        const response = res.data;

        if (response.sucesso) {
          this.list = response.dados.map((review) => {
            return {
              user: review.username,
              rating: Number(review.nota),
              text: review.descricao,
              date: review.data,
            };
          });
        }
      });
    },

    checkUserReview() {
      if (this.userLogged) {
        const params = { filme: this.movie, usuario: this.loggedData.id };

        this.$api
          .get("/existe-resenha-filme-usuario", { params })
          .then((res) => {
            const response = res.data;

            this.existsUserReview = response.sucesso;
          });
      }
    },

    newReview() {
      this.getReviews();
      this.checkUserReview();
    },
  },

  created() {
    this.getReviews();
    this.checkUserReview();
  },
};
</script>

<style>
</style>