export default {
  namespaced: true,
  state: {
    user: {
      id: '',
      name: '',
      tag: '',
    }
  },
  getters: {
    isLogged(state) {
      return Object.values(state.user).every(value => value);
    }
  },
  mutations: {
    setUser(state, payload) {
      state.user = payload;
    }
  },
  actions: {
    setUser({ commit }, payload) {
      const user = {
        id: payload.id,
        name: payload.nome,
        tag: payload.username
      }

      commit('setUser', user);
    },

    doLogout({ dispatch }) {

      this._vm.$api.post('/usuario/logout')
        .then(res => {
          const response = res.data;
          
          if(response.sucesso) dispatch('setUser', { id: '', name: '', tag: '' });
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

        return response.sucesso || false;
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
    }
  }
  
}