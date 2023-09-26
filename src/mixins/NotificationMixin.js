import { mapActions } from 'vuex';

export default {
  methods: {
    ...mapActions('notification', {
      notifyUser: 'addNotification'
    }),
  }
}