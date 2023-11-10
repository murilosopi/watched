<template>
  <Dialog
    id="modal-chat"
    size="lg"
    :scroll="true"
    :customHeader="titleChat.length > 0"
  >
    <template slot="header" v-if="id">
      <h1 class="modal-title fs-5">{{ id }}</h1>
      <InteractiveIcon class="ms-auto">
        <i class="bi bi-flag text-danger"></i>
      </InteractiveIcon>
      <InteractiveIcon data-bs-dismiss="modal" aria-label="Close">
        <i class="bi bi-x-lg text-danger"></i>
      </InteractiveIcon>
    </template>
    <div slot="content" class="row align-items-strech">
      <div class="col d-flex flex-column" v-if="id">
        <ChatMessages :messages="messages" />
      </div>
      <div class="col" v-else>
        <ul class="list-group chat-list list-unstyled">
          <li
            @click="id = i"
            class="list-group-item chat-item bg-transparent d-flex align-items-center fw-bold"
            v-for="i in 10"
            :key="i"
          >
            <div class="chat-item-icon me-2">
              <UserAvatar />
            </div>
            <Title tag="span">Usuario {{ i }}</Title>
          </li>
        </ul>
      </div>
    </div>
    <ChatForm
      slot="footer"
      v-if="id"
      @newMessage="(msg) => messages.push(msg)"
    />
  </Dialog>
</template>

<script>
import ChatForm from "./ChatForm.vue";
import ChatMessages from "./ChatMessages.vue";
import Dialog from "./Dialog.vue";
import InteractiveIcon from "./InteractiveIcon.vue";
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
  },
  data() {
    return {
      id: null,
      messages: [],
    };
  },

  computed: {
    titleChat() {
      return this.id ? `Esse chat aqui: ${this.id}` : "";
    },
  },
};
</script>

<style scoped>
.chat-item-icon {
  width: 30px;
}

.chat-item {
  color: gray;
  cursor: pointer;
  border-color: #202020;
  transition: 0.35s;
}

.chat-item:hover {
  background-color: #1e1e1e;
  color: white;
}
</style>
