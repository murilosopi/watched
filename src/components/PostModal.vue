<template>
  <Dialog>
    <form @submit.prevent="sendPost" slot="content">
      <InputCustom :icon="false">
        <textarea
          type="text"
          placeholder="Compartilhe com a comunidade Watched..."
          rows="10"
          slot="input"
          class="form-control border-bottom-0"
          :maxlength="800"
          v-model="text"
          @keypress.ctrl.enter="registerPost({ text })"
          @input="verifyTextSize"
        ></textarea>
      </InputCustom>
      <p class="small text-white-50 text-end">
        {{ text.length }}/800
      </p>
    </form>

    <template slot="footer">
      <div class="col">
        <ButtonCustom variant="azul" data-bs-dismiss="modal">
          Fechar
        </ButtonCustom>
      </div>
      <div class="col">
        <ButtonCustom>
          Postar
        </ButtonCustom>
      </div>
    </template>
  </Dialog>
</template>

<script>
import ButtonCustom from "./ButtonCustom.vue";
import Dialog from "./Dialog.vue";
import InputCustom from "./InputCustom.vue";
import { mapActions } from "vuex";

export default {
  components: { Dialog, InputCustom, ButtonCustom },
  data() {
    return {
      text: "",
    };
  },
  methods: {
    ...mapActions('post', {
      registerPost: 'send'
    }),

    verifyTextSize() {
      if (this.text.length >= 800) {
        this.text = this.text.slice(0, 800);
      }
    },

    clear() {
      this.text = '';
    }
  },

  mounted() {
    this.$el.addEventListener('hidden.bs.modal', this.clear);
  }
};
</script>

<style></style>
