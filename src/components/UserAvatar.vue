<template>
  <figure class="m-auto">
    <img :src="path" :alt="alt" class="user-photo" :class="{ 'placeholder': !alreadyLoaded }">
  </figure>
</template>

<script>
export default {
  props: {
    username: {
      required: true
    }
  },

  data() {
    return {
      path: false,
      alt: `Foto de perfil do usuário @${this.username}`
    }
  },

  computed: {
    alreadyLoaded() {
      return this.path;
    }
  },

  methods: {
    getAvatarImage() {
      setTimeout(() => {
        this.path = '';
      }, 2000 );
    }
  },

  created() {
    this.getAvatarImage();
  }
}
</script>

<style scoped>
.user-photo {
  aspect-ratio: 1 / 1;
  object-fit: cover;
  border-radius: 50%;
  width: 100%;
}
</style>