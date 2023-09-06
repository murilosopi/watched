<template>
  <ul class="user-stats col-lg-3 d-none d-lg-flex flex-column m-auto gap-2">
    <li class="d-flex align-items-center gap-2" :class="{ 'placeholder placeholder-sm': !alreadyLoaded }">
      <i class="bi bi-people-fill fs-5"></i>
      <strong>Seguidores:</strong> {{ 0 }}
    </li>
    <li class="d-flex align-items-center gap-2" :class="{ 'placeholder placeholder-sm': !alreadyLoaded }">
      <i class="bi bi-person-check-fill fs-5"></i>
      <strong>Seguindo:</strong> {{ 0 }}
    </li>
    <li class="d-flex align-items-center gap-2" :class="{ 'placeholder placeholder-sm': !alreadyLoaded }">
      <i class="bi bi-film fs-5"></i>
      <strong>Assistidos:</strong> {{ 0 }}
    </li>
    <li class="d-flex align-items-center gap-2" :class="{ 'placeholder placeholder-sm': !alreadyLoaded }">
      <i class="bi bi-chat-left-quote fs-5"></i>
      <strong>Resenhas:</strong> {{ 0 }}
    </li>
  </ul>
</template>

<script>
export default {
  props: {
    username: { required: true }
  },

  data() {
    return {
      stats: {}
    }
  },

  computed: {
    alreadyLoaded() {
      return Object.keys(this.stats).length > 0;
    }
  }
};
</script>

<style>
</style>