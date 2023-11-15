<template>
  <Dialog
    id="modal-chat"
    size="lg"
    :scroll="true"
    :customHeader="true"
  >
    <template  v-if="hasChat">
      <template slot="header">
        <InteractiveIcon class="me-1" @click.native="removeActiveChat">
          <i class="bi bi-chevron-left fs-5"></i>
        </InteractiveIcon>
        <h1 class="modal-title fs-5">{{ titleChat }}</h1>
        <InteractiveIcon class="ms-auto me-1">
          <i class="bi bi-flag text-danger fs-5"></i>
        </InteractiveIcon>
        <InteractiveIcon data-bs-dismiss="modal" aria-label="Close">
          <i class="bi bi-x-lg text-danger fs-5"></i>
        </InteractiveIcon>
      </template>

      <ChatForm
        :to="chatId"
        slot="footer"
        @newMessage="handlerNewMessage"
      />

      <div slot="content" class="row align-items-strech">
        <div class="col d-flex flex-column" v-if="hasChat">
          <ChatMessages :messages="messages" />
        </div>
      </div>
    </template>

    <template v-else>
      <template slot="header">
        <Title tag="h2">Bate-Papo</Title>
        <InteractiveIcon data-bs-dismiss="modal" aria-label="Close">
          <i class="bi bi-x-lg fs-5"></i>
        </InteractiveIcon>
      </template>
      
      <div slot="content" class="row align-items-strech">
        <div class="col" v-if="recentChats.length">
          <Title tag="h3" class="opacity-50 fs-4 mb-2">Recentes</Title>
          <ListGroup class="mb-4">
            <ListGroupItem v-for="chat in recentChats" :key="chat.id" @click.native="setActiveChat(chat)">
              <div class="chat-item-icon me-2">
                <UserAvatar :username="chat.participants[0].username"/>
              </div>
              <Title tag="span">{{ chat.participants.map(p => p.username).join(', ') }}</Title>
            </ListGroupItem>
          </ListGroup>
        </div>
      </div>
    </template>
  </Dialog>
</template>

<script>
import ChatMixin from "@/mixins/ChatMixin";
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
  mixins: [ChatMixin],
  data() {
    return {
      messages: [],

      chatSuggestions: [],
      chatSuggestionsFetched: false,
    };
  },

  methods: {
    handlerNewMessage(msg) {

      const sendedMessage = this.sendMessage(msg);
      this.messages.push(sendedMessage);
    },
  },

  updated() {
    this.dialogBody.scrollTop = this.dialogBody.scrollHeight;
  },

  mounted() {
    this.dialogBody = this.$el.querySelector(".modal-body");
  },
};
</script>

<style scoped>
.chat-item-icon {
  width: 30px;
}
</style>
