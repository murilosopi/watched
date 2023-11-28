export default {
    namespaced: true,
    state: {
        movie: null,
        list: []
    },
    getters: {
        getList(state) {
            return state.list;
        }
    },
    mutations: {
        setList(state, payload) {
            state.list = payload.map((review) => {
                return {
                    user: review.username,
                    rating: Number(review.nota),
                    text: review.descricao,
                    date: review.data
                };
            });
        },

        setMovie(state, payload) {
            state.movie = payload;
        },

        deleteReview(state, review) {
            const position = state.list.indexOf(review);

            if(position != -1) {
                state.list.splice(position, 1);
            }
        }
    },
    actions: {
        fetchReviews({ commit }, movie) {
            const params = { filme: movie };
            this._vm.$api.get("/obter-resenhas-filme", { params }).then((res) => {
                const response = res.data;
                if (response.sucesso) {
                    commit("setList", res.data.dados);
                    commit("setMovie", movie);
                }
            });
        },

        deleteReview({ commit, state }, review) {
            return this._vm.$api.post("/excluir-resenha", { movie: state.movie }).then((res) => {
                const response = res.data;

                if (response.sucesso) commit('deleteReview', review); 

                return response.sucesso;
            })
        }
    },
};
