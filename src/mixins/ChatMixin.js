import { mapActions, mapGetters, mapMutations } from 'vuex';

export default {
  methods: {
    ...mapActions('chat', ['getRecentChats']),
    ...mapMutations('chat', ['setActiveChat', 'removeActiveChat'])
  },
  computed: {
    ...mapGetters('chat', ['lastChatId', 'chatId', 'recentChats', 'hasChat', 'titleChat'])
  },
  created() {
    this.getRecentChats();
  }
}