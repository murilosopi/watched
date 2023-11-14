import { mapActions, mapGetters } from 'vuex';

export default {
  methods: {
    ...mapActions('chat', {}),
  },
  computed: {
    ...mapGetters('chat', ['lastChatId', 'chatId'])
  }
}