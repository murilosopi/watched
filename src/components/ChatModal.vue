<template>
  <Dialog id="modal-chat" size="lg" :scroll="true" >
    <div slot="content" class="row align-items-strech">
      <div class="col d-flex flex-column">
        <ChatMessages :messages="messages"/>
      </div>
    </div>
    <form @submit.prevent="sendMessage" class="mt-auto col-12 input-group chat-input w-100" slot="footer">
      <textarea
        rows="1"
        @keydown.enter.exact.prevent="sendMessage"
        @keydown.enter.shift.prevent="breakLine"
        v-model="message"
        type="text"
        placeholder="Escreva sua mensagem"
        class="form-control form-control-sm"
      ></textarea>
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
      textarea: null,
      message: "",
      messages: [
        { uid: 2, paragraphs: [ 'Lorem!', 'ipsum', 'dolar'], date: '20:10' },
        { uid: 2, paragraphs: [ 'sit amet' ], date: '20:10' },
      ],
    };
  },

  methods: {
    sendMessage() {
      if(this.message.length) {
        const date = new Date();
        const timeString = date.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });

        this.messages.push({
          uid: this.loggedData.id,
          paragraphs: this.message.trim().split('\n'),
          date: timeString
        })
  
        this.message = '';

        this.textarea.setAttribute('rows', 1);
      }
    },

    breakLine() {
      this.message += '\n';

      const rowCount = Number(this.textarea.getAttribute('rows'));

      if(rowCount < 3) {
        this.textarea.setAttribute('rows', rowCount+1);
      }
    }
  },

  mounted() {
    this.textarea = this.$el.querySelector('.chat-input textarea');
  }
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
  resize:none;
  height: auto!important;
  min-height: auto!important;
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
