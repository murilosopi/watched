export default {
  namespaced: true,
  state: {
    list: [],
    lastPage: 0,
  },
  mutations: {
    appendPosts(state, posts) {
      posts.forEach((post) => {
        state.list[post.id] = post;
      });
    }
  },
  actions: {
    fetchPosts({ dispatch, commit }, page = 1) {
      const params = { pagina: page };

      this._vm.$api.get('/buscar-postagens', { params })
        .then(res => {
          const data = res.data.dados;

          if(data) {

            if (data.postagens && data.postagens.length) {
              commit('appendPosts', data.postagens);
            }

            if(data.pagina != data.totalPaginas) {
              dispatch('fetchPosts', data.pagina + 1);
            }

          } 

        })
    },

    send(store, payload) {
      this._vm.$api.post('/registrar-postagem', { postagem: payload.text })
    },
  }
}