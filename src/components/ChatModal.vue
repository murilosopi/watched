<template>
  <Dialog
    id="modal-chat"
    size="lg"
    :scroll="true"
    :customHeader="titleChat.length > 0"
  >
    <template slot="header" v-if="id">
      <InteractiveIcon class="me-1" @click.native="id = null">
        <i class="bi bi-chevron-left fs-5"></i>
      </InteractiveIcon>
      <h1 class="modal-title fs-5">{{ id }}</h1>

      <InteractiveIcon class="ms-auto me-1">
        <i class="bi bi-flag text-danger fs-5"></i>
      </InteractiveIcon>
      <InteractiveIcon data-bs-dismiss="modal" aria-label="Close">
        <i class="bi bi-x-lg text-danger fs-5"></i>
      </InteractiveIcon>
    </template>
    <div slot="content" class="row align-items-strech">
      <div class="col d-flex flex-column" v-if="id">
        <ChatMessages :messages="messages" />
      </div>
      <div class="col" v-else>
        <ListGroup>
          <ListGroupItem
            @click.native="id = i"
            v-for="i in 10"
            :key="i"
          >
            <div class="chat-item-icon me-2">
              <UserAvatar />
            </div>
            <Title tag="span">Usuario {{ i }}</Title>
          </ListGroupItem>
        </ListGroup>
      </div>
    </div>
    <ChatForm
      v-if="id"
      :to="id"
      slot="footer"
      @newMessage="handlerNewMessage"
    />
  </Dialog>
</template>

<script>
import ChatForm from "./ChatForm.vue";
import ChatMessages from "./ChatMessages.vue";
import Dialog from "./Dialog.vue";
import InteractiveIcon from "./InteractiveIcon.vue";
import ListGroup from "./ListGroup.vue";
import ListGroupItem from "./ListGroupItem.vue";
import Title from "./Title.vue";
import UserAvatar from "./UserAvatar.vue";
export default {
  components: {
    Dialog,
    ChatMessages,
    UserAvatar,
    Title,
    ChatForm,
    InteractiveIcon,
    ListGroupItem,
    ListGroup,
},
  data() {
    return {
      id: null,
      connection: null,
      messages: [],
    };
  },

  computed: {
    titleChat() {
      return this.id ? `Esse chat aqui: ${this.id}` : "";
    },
  },

  methods: {
    handlerNewMessage(msg) {
      msg = {
        ...msg,
        to: this.id,
        from: this.loggedData.id
      }

      this.messages.push(msg);
      this.connection.send(JSON.stringify(msg));
    },

    onMessageReceived({ data }) {
      const message = JSON.parse(data);

      if(this.id == message.from) {
        this.messages.push(message);
      } else {
        alert('voce recebeu uma mensagem do usuario: ' + message.from);
      }
    }
  },

  updated() {
    this.dialogBody.scrollTop = this.dialogBody.scrollHeight;
  },

  mounted() {
    this.dialogBody = this.$el.querySelector('.modal-body');
  },

  created() {
    
    let wsUrl = `ws://localhost:8082?uid=${this.loggedData.id}`;
    this.connection = new WebSocket(wsUrl);
    
    this.connection.onopen = () => {
      console.log('Conectado');
    }

    this.connection.onmessage = this.onMessageReceived;
  }
};
</script>

<style scoped>
.chat-item-icon {
  width: 30px;
}
</style>
