export default {
  namespaced: true,
  state: {
    list: [],
  },
  getters: {
    list(state) {
      return state.list;
    },
  },
  mutations: {
    appendPosts(state, posts) {
      state.list.push(...posts);
    },
    prependPosts(state, posts) {
      state.list.unshift(...posts);
    }
  },
  actions: {
    fetchPosts({ dispatch, commit }, page = 1) {
      const params = { pagina: page };

      this._vm.$api.get("/buscar-postagens", { params }).then((res) => {
        const data = res.data.dados;

        if (data) {
          if (data.postagens && data.postagens.length) {
            commit("appendPosts", data.postagens);
          }

          if (data.pagina < data.totalPaginas) {
            dispatch("fetchPosts", data.pagina + 1);
          }
        }
      });
    },

    fetchNewPosts({ state, commit }) {
      const [ lastPost ] = state.list;

      const params = { id: lastPost.id || 0 };

      this._vm.$api.get('/buscar-postagens-recentes', { params })
        .then(res => {
          const posts = res.data.dados;
          if (posts) {
            commit("prependPosts", posts);
          }
        });
    },

    send({ dispatch}, payload) {
      return this._vm.$api.post("/registrar-postagem", {
        postagem: payload.text,
      }).then((res) => {
        dispatch('fetchNewPosts');

        return res;
      });
    },
  },
};
