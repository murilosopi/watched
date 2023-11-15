export default {
  namespaced: true,
  state: {
    activeChat: {
      id: null,
      participants: [],
      messages: [],
    },
    recentChats: [],
    followingChats: []
  },
  getters: {
    chatId(state) {
      return state.activeChat.id || false;
    },
    recentChats(state) {
      return state.recentChats || [];
    },
    followingChats(state) {
      return state.followingChats || [];
    },
    hasChat(state) {
      return state.activeChat.id !== null;
    },
    titleChat(state) {
      return state.activeChat.participants
        .map((p) => `@${p.username}`)
        .join(", ");
    },
    allParticipants(state) {
      return state.activeChat.participants.map((p) => p.id);
    },
    messages(state) {
      return state.activeChat.messages && state.activeChat.messages.length ? state.activeChat.messages : [];
    },
  },
  mutations: {
    setActiveChat(state, chat) {
      state.activeChat = chat;
    },
    removeActiveChat(state) {
      state.activeChat = {
        id: null,
        participants: [],
        messages: [],
      };
    },
    setRecentChats(state, payload) {
      state.recentChats = payload.map((chat) => {
        return {
          id: chat.id,
          participants: chat.participantes,
          messages: [],
        };
      });
    },
    setFollowingChats(state, payload) {
      state.followingChats = payload.map((chat) => {
        return {
          id: chat.id,
          participants: [{ entrada: chat.entrada, id: chat.id, nome: chat.nome, username: chat.username }],
          messages: [],
        };
      });
    },
    addMessage(state, msg) {
      state.activeChat.messages.push(msg);
    },
  },
  actions: {
    getRecentChats({ commit }) {
      this._vm.$api
        .get("/bate-papo/recentes")
        .then((res) => {
          commit("setRecentChats", res.data.dados);
        })
        .catch(() => {});
    },
    getFollowingChats({ commit }) {
      this._vm.$api
        .get("/bate-papo/seguindo")
        .then((res) => {
          commit("setFollowingChats", res.data.dados);
        })
        .catch(() => {});
    },

    
  },
};
