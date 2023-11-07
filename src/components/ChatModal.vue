<template>
  <Dialog id="modal-chat" size="lg">
    <div slot="content" class="row align-items-strech">
      <aside class="col-4">
        <ul class="list-group chat-list">
          <li class="list-group-item chat-item" v-for="i in 10" :key="i">
            Usuario {{ i }}
          </li>
        </ul>
      </aside>
      <div class="col">
        <form @submit.prevent class="d-flex h-100 ">
          <InputCustom :icon="false" class="mt-auto mb-0">
            <input
              v-model="message"
              type="text"
              placeholder="Digite sua Mensagem..."
              slot="input"
              class="form-control rounded-pill border-bottom-0 px-4"
            />
          </InputCustom>
        </form>
      </div>
    </div>
  </Dialog>
</template>

<script>
import Dialog from './Dialog.vue';
import InputCustom from './InputCustom.vue';
export default {
  components: {
    Dialog,
    InputCustom
  },
  data() {
    return {
      message: '',
    }
  }
}
</script>

<style scoped>
.chat-item {
  background-color: #151515;
  color: gray;
  cursor: pointer;
  border-color: #202020;
  transition: .35s;
}

.chat-item:hover {
  background-color: #1e1e1e;
  color: white;
}
</style>