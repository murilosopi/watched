import { mapActions  } from 'vuex';

export default {
  methods: {
    ...mapActions('auth', {
      auth: 'doLogin'
    }),
  }
}