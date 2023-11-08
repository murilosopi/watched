<template>
  <Dialog id="modal-chat" size="lg" :scroll="true">
    <div slot="content" class="row align-items-strech">
      <div class="col d-flex flex-column">
        <ChatMessages :messages="messages"/>
      </div>
    </div>
    <form @submit.prevent="sendMessage" class="mt-auto col-12 input-group chat-input w-100" slot="footer">
      <input
        v-model="message"
        type="text"
        placeholder="Escreva sua mensagem"
        class="form-control form-control-sm"
      />
      <div class="input-group-text">
        <InteractiveIcon >
          <i class="bi bi-send chat-input-icon"></i>
        </InteractiveIcon>
      </div>
    </form>
  </Dialog>
</template>

<script>
import ChatMessages from './ChatMessages.vue';
import Dialog from "./Dialog.vue";
import InteractiveIcon from "./InteractiveIcon.vue";
export default {
  components: {
    Dialog,
    InteractiveIcon,
    ChatMessages
  },
  data() {
    return {
      dialog: null,
      message: "",
      messages: [
        { uid: 2, paragraphs: [ 'Lorem!', 'ipsum', 'dolar'], date: '10/10/2023 20:10' },
        { uid: 2, paragraphs: [ 'sit amet' ], date: '10/10/2023 20:10' },
        
      ],
    };
  },

  methods: {
    sendMessage() {
      this.messages.push({
        uid: this.loggedData.id,
        paragraphs: this.message.split('\n'),
      })

      this.message = '';
    }
  },
};
</script>

<style scoped>
.chat-item {
  background-color: #151515;
  color: gray;
  cursor: pointer;
  border-color: #202020;
  transition: 0.35s;
}

.chat-item:hover {
  background-color: #1e1e1e;
  color: white;
}

.chat-input :is(.input-group-text, .form-control){
  background-color: rgb(33, 33, 33) !important;
  border: none!important;
  outline: none!important;
  color: white;
}

.chat-input .form-control::placeholder {
  color: rgba(255, 255, 255, 0.6)!important;
}

.chat-input .form-control:focus {
  box-shadow: none!important;
}

.chat-input-icon {
  color: var(--cor-ciano);
}
</style>
