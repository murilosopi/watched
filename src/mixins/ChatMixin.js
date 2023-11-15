import { mapActions, mapGetters, mapMutations } from "vuex";

export default {
  data() {
    return {
      wsConnection: null,
    };
  },
  methods: {
    ...mapActions("chat", ["getRecentChats", "registerMessage"]),
    ...mapMutations("chat", ["setActiveChat", "removeActiveChat"]),

    sendMessage(data) {
      data = {
        ...data,
        id: this.chatId,
        to: this.allParticipants,
        from: this.loggedData.id,
      };

      this.wsConnection.send(JSON.stringify(data));
      
      
      // this.registerMessage().then((res) => {
      // });

      return data;
    },

    onMessageReceived({ data }) {
      const message = JSON.parse(data);

      if (message.id == this.chatId) {
        this.messages.push(message);
      } else {
        alert("voce recebeu uma mensagem do usuario: " + message.from);
      }
    },
  },
  computed: {
    ...mapGetters("chat", [
      "lastChatId",
      "chatId",
      "recentChats",
      "hasChat",
      "titleChat",
      "allParticipants",
    ]),
  },
  created() {
    this.getRecentChats();

    let wsUrl = `ws://localhost:8082?uid=${this.loggedData.id}`;
    this.wsConnection = new WebSocket(wsUrl);

    this.wsConnection.onopen = () => {
      console.log("Conectado");
    };

    this.wsConnection.onmessage = this.onMessageReceived;
  },
};
