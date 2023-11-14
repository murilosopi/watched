export default {
  namespaced: true,
  state: {
    chat: {
      id: '1234',
      lastId: '',
      participants: [],
      name: ''
    }
  },
  getters: {
    lastChatId(state) {
      return state.chat.lastId || false;
    },
    chatId(state) {
      return state.chat.id || false;
    }
  },
  mutation: {
    setId(state, newId) {
      state.chat.id = newId;
    },
    updateLastId(state) {
      state.chat.lastId = state.chat.id;
    }
  },
  actions: {
    getRecentChats() {
      if(!this.userLogged) return;

      
    }
  }
}