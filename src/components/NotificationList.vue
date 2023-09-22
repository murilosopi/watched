<template>
  <div class="alert-container container">
    <div
      class="alert alert-dismissible fade show"
      :class="`alert-${n.class}`"
      role="alert"
      v-for="(n, index) in notifications"
      :key="index"
    >
    
    <i v-if="n.icon" class="me-2" :class="`bi bi-${n.icon}`"></i>
      <strong v-if="n.title">{{ n.title }}: </strong>

      <span>{{ n.text }}</span>
      <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
        aria-label="Close"
        @click="deleteNotification(index)"
      ></button>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";
export default {
  computed: mapGetters("notification", ["notifications"]),
  methods: mapMutations("notification", ["deleteNotification"])
};
</script>

<style>
.alert-container {
  position: fixed;
  width: 80%;
  left: 50%;
  transform: translateX(-50%);
  top: 10px;
  z-index: 1;
  opacity: .95;
}
</style>