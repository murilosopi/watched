export default {
  namespaced: true,
  state: {
    activeChat: {
      id: null,
      participants: [],
      messages: [],
    },
    recentChats: [],
  },
  getters: {
    chatId(state) {
      return state.activeChat.id || false;
    },
    recentChats(state) {
      return state.recentChats || [];
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
  },
};
