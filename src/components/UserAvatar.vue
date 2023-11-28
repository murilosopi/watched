<template>
  <figure class="ratio ratio-1x1 m-auto">
    <img :src="path" :alt="alt" class="user-photo rounded-circle">
  </figure>
</template>

<script>
export default {
  props: ['username'],

  data() {
    return {
      path: '',
      alt: `Foto de perfil do usuário @${this.username}`
    }
  },

  mounted() {
    this.path = `${this.$api.getUri()}/usuario/avatar?username=${this.username}&time=${Date.now()}`;
  }
}
</script>

<style scoped>
.user-photo {
  object-fit: cover;
  margin: auto;
  display: block;
}
</style>