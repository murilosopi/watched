export default {
  namespaced: true,
  state: {
    notifications: []
  },
  mutations: {
    addNotification(state, payload) {
      state.notifications.push(payload);
    },
    deleteNotification(state, id) {
      state.notifications = state.notifications.filter(n => n.id != id);
    }
  },
  actions: {
    addNotification({ commit, state }, payload) {
      payload.id = state.notifications.length + 1;

      commit('addNotification', payload);

      setTimeout(() => {
        commit('deleteNotification', payload.id);
      }, 5000);
    }
  },
  getters: {
    notifications(state) {
      return state.notifications;
    }
  }
}