<template>
  <form
      @submit.prevent="sendMessage"
      class="mt-auto col-12 input-group chat-input w-100"
      slot="footer"
    >
      <textarea
        rows="1"
        @keydown.enter.exact.prevent="sendMessage"
        @keydown.enter.shift.prevent="breakLine"
        v-model="message"
        @input="$emit('change', message)"
        type="text"
        placeholder="Escreva sua mensagem"
        class="form-control form-control-sm"
      ></textarea>
      <div class="input-group-text">
        <InteractiveIcon>
          <i class="bi bi-send chat-input-icon"></i>
        </InteractiveIcon>
      </div>
    </form>
</template>

<script>
import InteractiveIcon from "./InteractiveIcon.vue";

export default {
  data() {
    return {
      textarea: null,
      message: ''
    }
  },
  components: {
    InteractiveIcon
  },

  methods: {
    breakLine() {
      this.message += "\n";

      const rowCount = Number(this.textarea.getAttribute("rows"));

      if (rowCount < 3) {
        this.textarea.setAttribute("rows", rowCount + 1);
      }
    },

    sendMessage() {
      if (this.message.length) {
        const date = new Date();
        const time = date.toLocaleTimeString("pt-BR", {
          hour: "2-digit",
          minute: "2-digit",
        });

        this.$emit('newMessage', {
          paragraphs: this.message.trim().split("\n"),
          text: this.message,
          time,
        });

        this.message = "";

        this.textarea.setAttribute("rows", 1);
      }

      this.textarea.focus();
    },
  },

  mounted() {
    this.textarea = this.$el.querySelector(".chat-input textarea");
  },
}
</script>

<style scoped>
.chat-input :is(.input-group-text, .form-control) {
  background-color: rgb(33, 33, 33) !important;
  resize: none;
  height: auto !important;
  min-height: auto !important;
  border: none !important;
  outline: none !important;
  color: white;
}

.chat-input .form-control::placeholder {
  color: rgba(255, 255, 255, 0.6) !important;
}

.chat-input .form-control:focus {
  box-shadow: none !important;
}

.chat-input-icon {
  color: var(--cor-ciano);
}
</style>