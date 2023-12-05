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
    },
    deletePost(state, index) {
      state.list.splice(index, 1);
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

    fetchNewPosts({ dispatch, state, commit }) {
      const [ lastPost ] = state.list;

      if(!lastPost) {
        dispatch('fetchPosts');
        return;
      }

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

    delete({ commit }, { id, index}) {
      return this._vm.$api.post("/remover-postagem", { id }).then((res) => {

        const response = res.data;

        if(response.sucesso) commit('deletePost', index);

        return res;
      });
    },

    
  },
};
