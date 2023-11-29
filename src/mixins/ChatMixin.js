import { mapActions, mapGetters, mapMutations } from "vuex";

export default {
  data() {
    return {
      wsConnection: null,
    };
  },
  methods: {
    ...mapActions("chat", [
      "getRecentChats",
      "getFollowingChats",
      "registerMessage",
      "newChat"
    ]),
    ...mapMutations("chat", [
      "setActiveChat",
      "removeActiveChat",
      "addMessage",
    ]),

    sendMessage(data) {
      const msg = {
        ...data,
        chat: this.chatId,
        to: this.allParticipants,
        from: this.loggedData.id,
      };

      this.wsConnection.send(JSON.stringify(msg));

      this.addMessage(msg);

      // this.registerMessage().then((res) => {
      // });
    },

    onMessageReceived({ data }) {
      const message = JSON.parse(data);

      if (message.chat == this.chatId) {
        this.messages.push(message);
      } else {
        alert("voce recebeu uma mensagem do usuario: " + message.from);
      }
    },
  },
  computed: {
    ...mapGetters("chat", [
      "chatId",
      "recentChats",
      "followingChats",
      "hasChat",
      "titleChat",
      "allParticipants",
    ]),
  },
  created() {
    this.getRecentChats();
    this.getFollowingChats();

    let wsUrl = `ws://localhost:8082?uid=${this.loggedData.id}`;
    this.wsConnection = new WebSocket(wsUrl);

    this.wsConnection.onopen = () => {
      console.log("Conectado");
    };

    this.wsConnection.onmessage = this.onMessageReceived;
  },
};
