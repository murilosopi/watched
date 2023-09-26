import { mapGetters, mapActions } from 'vuex';


export default {
  methods: {
    ...mapActions('auth', {
      auth: 'doLogin',
      checkAuth: 'doCheck',
      doLogout: 'doLogout'
    }),
  },
  computed: {
    ...mapGetters('auth', {
      userLogged: 'isLogged'
    })
  },
}