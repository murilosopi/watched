<template>
  <section class="col" v-if="reviewsList.length || userLogged && !existsUserReview">
    <Title tag="h3" class="text-center">
      Opinião do Público
      <i class="bi bi-chat-left-text"></i>&nbsp;
    </Title>
    <hr class="w-25 mx-auto" />
    <Transition leave-active-class="animate__animated animate__fadeOut animate__faster">
      <ReviewForm :movie="movie" v-if="!existsUserReview" @newReview="newReview" />
    </Transition>

    <div class="row justify-content-evenly mt-4">
      <div class="col-md-6 mb-3 mb-md-0 ps-md-0">
        <RatingChart :movie="movie" />
      </div>
      <div class="col-md-6 pe-md-0">
        <ReactionChart :movie="movie" />
      </div>
    </div>


    <ReviewsList class="mt-5" />
  </section>
</template>

<script>
import Title from "@/components/Title.vue";
import ReviewsList from "./ReviewsList.vue";
import ReviewForm from "./ReviewForm.vue";
import RatingChart from "./RatingChart.vue";
import ReactionChart from "./ReactionChart.vue";
import ReviewMixin from "@/mixins/ReviewMixin";

export default {
  components: {
    Title,
    ReviewsList,
    ReviewForm,
    RatingChart,
    ReactionChart
  },

  mixins: [ReviewMixin],

  props: ["movie"],

  methods: {

    newReview() {
      this.fetchReviews(this.movie);
      this.checkUserReview();
    },
  },

  created() {
    this.fetchReviews(this.movie);

    this.checkUserReview();
    this.fetchMovieStats();
  },

  watch: {
    userLogged() {
      this.checkUserReview();
    }
  }
};
</script>

<style></style>