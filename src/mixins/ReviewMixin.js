import { mapActions, mapGetters, mapMutations } from 'vuex';

export default {
  props: ['movie'],
  methods: {
    ...mapActions('review', ['fetchReviews', 'deleteReview', 'fetchMovieStats']),
    ...mapMutations('review', ['setMovie','setUserHasReview']),

    checkUserReview() {
      if (this.userLogged) {
        const params = { filme: this.movie, usuario: this.loggedData.id };

        this.$api
          .get("/existe-resenha-filme-usuario", { params })
          .then((res) => {
            const response = res.data;

            this.setUserHasReview(response.sucesso);
          });
      }
    },
  },
  computed: {
    ...mapGetters('review', {
      reviewsList: 'getList',
      existsUserReview: 'userHasReview',
      starRating: 'getRatingStats'
    })
  },

  created() {
    this.setMovie(this.movie);
  },
}