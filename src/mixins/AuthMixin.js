import { mapActions, mapGetters } from 'vuex';

export default {
  methods: {
    ...mapActions('auth', {
      auth: 'doLogin',
      checkAuth: 'doCheck',
      logout: 'doLogout',
      checkToken: 'doLoginToken'
    }),
  },
  computed: {
    ...mapGetters('auth', {
      userLogged: 'isLogged',
      loggedData: 'getData'
    })
  }
}