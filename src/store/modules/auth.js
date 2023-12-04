export default {
  namespaced: true,
  state: {
    user: {
      id: '',
      name: '',
      tag: '',
      private: null
    }
  },
  getters: {
    isLogged(state) {
      return state.user && state.user.id && state.user.name && state.user.tag;
    },
    getData(state) {
      return state.user;
    }
  },
  mutations: {
    setUser(state, payload) {
      state.user = payload;
    },

    setPrivacy(state, payload) {
      state.user.private = payload;
    }
  },
  actions: {
    setUser({ commit }, payload) {
      const user = {
        id: payload.id,
        name: payload.nome,
        tag: payload.username,
        private: payload.privado ? true : false
      }

      commit('setUser', user);
    },

    doLogout({ dispatch }) {

      this._vm.$api.post('/usuario/logout')
        .then(res => {
          const response = res.data;
          
          if(response.sucesso) dispatch('setUser', { id: '', name: '', tag: '', privado: null });
        });
    },

    doLogin({ dispatch }, payload) {

      const params = {
        usuario: payload.username,
        senha: payload.password
      };

      return this._vm.$api.post('/usuario/login', params).then(res => {
        const response = res.data;

        if(response.sucesso) {
          dispatch('setUser', response.dados)
        }

        return response;
      });
    },

    doLoginToken({ dispatch }, payload) {

      const params = {
        usuario: payload.username,
        senha: payload.password,
        token: payload.token
      };

      return this._vm.$api.post('/usuario/token', params).then(res => {
        const response = res.data;

        if(response.sucesso) {
          dispatch('setUser', response.dados)
        }

        return response;
      });
    },

    doCheck({ dispatch }) {
      return this._vm.$api.post('/usuario/checar-acesso').then(res => {
        const response = res.data;

        if(response.sucesso) {
          dispatch('setUser', response.dados)
        }

        return response.sucesso || false;
      });
    },
  }
  
}