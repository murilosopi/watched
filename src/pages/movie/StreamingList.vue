<template>
  <DarkBox class="streaming-list ms-lg-5 p-4 h-100 w-100" :class="{placeholder: !platforms.length}">
    <Title class="h4 text-center mb-4">
      Onde Assistir
      <i class="bi bi-play"></i>
    </Title>

    <nav :class="{placeholder: !platforms.length}">
      <ul class="list-unstyled">
        <li class="mb-3 row align-items-center" v-for="platform in platforms" :key="platform.id">
          <a :href="platform.url" class="text-light fw-normal d-flex align-items-center" target="_blank">
            <img :src="platform.icon" :alt="`Logo da plataform de streaming ${platform.name}`" class="col-1 me-3">
            <span>{{ platform.name }}</span>
          </a>
        </li>
      </ul>
    </nav>
  </DarkBox>
</template>

<script>
import Title from "@/components/Title.vue";
import DarkBox from "@/components/DarkBox.vue";
export default {
  components: {
    Title,
    DarkBox
  },

  props: {
    id: {
      required: true
    }
  },

  data() {
    return {
      platforms: [],
    }
  },

  methods: {
    getPlatformsAvaible() {
      const params = { id: this.id };

      this.$api.get('/obter-plataformas-filme', { params})
        .then(res => {
          const response = res.data.dados;
          const success = res.data.sucesso;

          if(success) {
            this.platforms = response.map(original => ({
              id: original.id,
              name: original.nome,
              url: original.url,
              icon: original.icone,
            }));
          }
        })
        .catch(() => {});
    }
  },

  created() {
    this.getPlatformsAvaible();
  }
};
</script>

<style>
</style>