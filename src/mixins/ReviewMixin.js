import { mapActions, mapGetters, mapMutations } from 'vuex';

export default {
  props: ['movie'],
  methods: {
    ...mapActions('review', ['fetchReviews', 'deleteReview']),
    ...mapMutations('review', ['setMovie'])
  },
  computed: {
    ...mapGetters('review', {
      reviewsList: 'getList'
    })
  },
  created() {
    this.setMovie(this.movie);
  }
}