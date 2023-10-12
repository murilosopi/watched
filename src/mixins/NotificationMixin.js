import { mapActions } from 'vuex';

export default {
  methods: {
    ...mapActions('notification', {
      notifyUser: 'addNotification'
    }),
    notifyAuthRequired() {
      this.notifyUser({
        icon: "x-circle",
        title: "Ops",
        text: "você não está logado...",
        class: "danger",
      });
    }
  }
}