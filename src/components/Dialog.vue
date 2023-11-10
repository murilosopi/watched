<template>
  <div class="modal fade">
    <div class="modal-dialog modal-dialog-centered" :class="dialogClass">
      <DarkBox class="modal-content rounded">
        <div class="modal-header" v-if="customHeader">
          <slot name="header"></slot>
        </div>
        <template v-else>
          <div class="modal-header" v-if="title.length > 0">
            <h1 class="modal-title fs-5">{{ title }}</h1>
            <InteractiveIcon data-bs-dismiss="modal" aria-label="Close">
              <i class="bi bi-x-lg text-danger"></i>
            </InteractiveIcon>
          </div>
        </template>
        <div class="modal-body py-4 rounded">
          <slot name="content"></slot>
        </div>
        <div class="modal-footer">
          <slot name="footer"></slot>
        </div>
      </DarkBox>
    </div>
  </div>
</template>

<script>
import { Modal } from "bootstrap";
import DarkBox from "./DarkBox.vue";
import InteractiveIcon from "./InteractiveIcon.vue";

export default {
  components: {
    DarkBox,
    InteractiveIcon,
  },
  props: {
    title: {
      type: String,
      default: "",
    },
    size: {
      type: String,
      default: "",
    },
    scroll: Boolean,
    customHeader: Boolean,
  },
  data() {
    return {
      element: null,
    };
  },
  mounted() {
    this.element = new Modal(this.$el);
  },
  computed: {
    dialogClass() {
      const cls = {
        "modal-dialog-scrollable": this.scroll,
      };

      if (this.size.length) cls[`modal-${this.size}`] = true;

      return cls;
    },
  },
};
</script>

<style scoped>
.modal-footer,
.modal-header {
  border-color: rgb(98 98 98 / 21%);
}
</style>
