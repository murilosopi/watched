export default {
  namespaced: true,
  state: {
    movie: null,
    userHasReview: false,
    list: [],
    stats: {
      rating: [],
      reaction: [],
    },
  },
  getters: {
    getList(state) {
      return state.list;
    },

    userHasReview(state) {
      return state.userHasReview;
    },

    getRatingStats(state) {
      return state.stats.rating;
    },

    getReactionStats(state) {
      return state.stats.reaction;
    },
  },
  mutations: {
    setList(state, payload) {
      state.list = payload.map((review) => {
        return {
          user: review.username,
          rating: Number(review.nota),
          text: review.descricao,
          date: review.data,
        };
      });
    },

    clearList(state) {
      state.list = [];
    },

    setMovie(state, payload) {
      state.movie = payload;
    },

    deleteReview(state, review) {
      const position = state.list.indexOf(review);

      if (position != -1) {
        state.list.splice(position, 1);
      }
    },

    setUserHasReview(state, exists) {
      state.userHasReview = exists;
    },

    setStats(state, payload) {
      state.stats = payload;
    },

    clearStats(state) {
      state.stats = {
        rating: [],
        reaction: [],
      }
    }
  },
  actions: {
    fetchReviews({ state, commit }) {
      const params = { filme: state.movie };
      commit('clearList');
      this._vm.$api.get("/obter-resenhas-filme", { params }).then((res) => {
        const response = res.data;
        if (response.sucesso) {
          commit("setList", res.data.dados);
        }
      });
    },

    deleteReview({ commit, state, dispatch }, review) {
      return this._vm.$api
        .post("/excluir-resenha", { movie: state.movie })
        .then((res) => {
          const response = res.data;

          if (response.sucesso) {
            commit("deleteReview", review);
            commit("setUserHasReview", false);

            dispatch('fetchMovieStats');
            dispatch('fetchReviews');
          }

          return response.sucesso;
        });
    },

    fetchMovieStats({ state, commit }) {
      commit('clearStats');
      const params = { id: state.movie };
      this._vm.$api
        .get("/obter-estatisticas-filme", { params })
        .then((res) => {
          const response = res.data;

          let { avaliacao, reacao } = response.dados;
          const rating = avaliacao.map((r) => ({
            total: r.total,
            percentage: r.porcentagem,
          }));
          const reaction = reacao.map((r) => ({
            total: r.total,
            percentage: r.porcentagem,
            icon: r.icone,
            name: r.descricao,
          }));

          commit("setStats", { rating, reaction });
        })
        .catch(() => {});
    },
  },
};
