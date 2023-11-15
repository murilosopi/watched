export default {
  namespaced: true,
  state: {
    activeChat: {
      id: '1234',
      participants: [],
      name: '',
    },
    recentChats: [],
  },
  getters: {
    lastChatId(state) {
      return state.chat.lastId || false;
    },
    chatId(state) {
      return state.chat.id || false;
    }
  },
  mutations: {
    setId(state, newId) {
      state.chat.id = newId;
    },
    updateLastId(state) {
      state.chat.lastId = state.chat.id;
    },
    setRecentChats(state, payload) {
      state.recentChats = payload;
    }
  },
  actions: {
    getRecentChats({ commit }) {
      this._vm.$api.get('/bate-papo/recentes')
        .then(res => {
          commit('setRecentChats'), res.data.dados;
        }).catch(() => {});
      
    }
  }
}