<template>
  <ul class="user-stats col-lg-3 d-none d-lg-flex flex-column m-auto gap-2">
    <li class="d-flex align-items-center gap-2" :class="{ 'placeholder placeholder-sm': !alreadyLoaded }">
      <i class="bi bi-people-fill fs-5"></i>
      <strong>Seguidores:</strong> {{ stats.followers }}
    </li>
    <li class="d-flex align-items-center gap-2" :class="{ 'placeholder placeholder-sm': !alreadyLoaded }">
      <i class="bi bi-person-check-fill fs-5"></i>
      <strong>Seguindo:</strong> {{ stats.following }}
    </li>
    <li class="d-flex align-items-center gap-2" :class="{ 'placeholder placeholder-sm': !alreadyLoaded }">
      <i class="bi bi-film fs-5"></i>
      <strong>Assistidos:</strong> {{ stats.watched }}
    </li>
    <li class="d-flex align-items-center gap-2" :class="{ 'placeholder placeholder-sm': !alreadyLoaded }">
      <i class="bi bi-chat-left-quote fs-5"></i>
      <strong>Resenhas:</strong> {{ stats.reviews }}
    </li>
  </ul>
</template>

<script>
export default {
  props: {
    id: { required: true }
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
  },
  
  methods: {
    getStats() {
        const params = { uid: this.id };
        this.$api
          .get("/obter-estatiscas-perfil", { params })
          .then((res) => {
            let response = res.data;

            
            if (response.sucesso) {
              const data = response.dados;
              
              this.stats = {
                watched: data.assistidos,
                following: data.seguindo,
                followers: data.seguidores,
                reviews: data.resenhas,
              }
            } else {
              throw 'Usuário não encontrado';
            }

          })
          .catch(() => {});
    }
  },

  watch: {
    id(value) {
      if(value) {
        this.getStats();
      }
    }
  },

  created() {
    if(this.id) {
      this.getStats();
    }
  }
};
</script>

<style>
</style>