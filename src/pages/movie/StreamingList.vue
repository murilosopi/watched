<template>
  <DarkBox
    class="streaming-list ms-lg-5 p-4 h-100 w-100"
    :class="{ placeholder: loading }"
  >
    <Title class="h4 text-center mb-4 fw-bold">
      Onde Assistir
      <i class="bi bi-play"></i>
    </Title>

    <nav :class="{ placeholder: loading }">
      <template v-if="platforms.buy && platforms.buy.length">
        <Title tag="h4" class="h5 mb-1">Comprar</Title>
        <ul class="list-unstyled">
          <li
            class="mb-3 row align-items-center"
            v-for="platform in platforms.buy"
            :key="platform.id"
          >
            <a
              :href="platform.url"
              class="text-light fw-normal d-flex align-items-center"
              target="_blank"
            >
              <img
                v-if="platform.icon"
                :src="platform.icon"
                :alt="`Logo da plataforma de streaming ${platform.name}`"
                class="plattform-icon rounded col-2 me-2"
              />
              <span>{{ platform.name }}</span>
            </a>
          </li>
        </ul>
      </template>

      <template v-if="platforms.rent && platforms.rent.length">
        <Title tag="h4" class="h5 mb-1">Alugar</Title>
        <ul class="list-unstyled">
          <li
            class="mb-3 row align-items-center"
            v-for="platform in platforms.rent"
            :key="platform.id"
          >
            <a
              :href="platform.url"
              class="text-light fw-normal d-flex align-items-center"
              target="_blank"
            >
              <img
                v-if="platform.icon"
                :src="platform.icon"
                :alt="`Logo da plataforma de streaming ${platform.name}`"
                class="plattform-icon rounded col-2 me-2"
              />
              <span>{{ platform.name }}</span>
            </a>
          </li>
        </ul>
      </template>

      <template v-if="platforms.flatrate && platforms.flatrate.length">
        <Title tag="h4" class="h5 mb-1">Assinatura</Title>
        <ul class="list-unstyled">
          <li
            class="mb-3 row align-items-center"
            v-for="platform in platforms.flatrate"
            :key="platform.id"
          >
            <a
              :href="platform.url"
              class="text-light fw-normal d-flex align-items-center"
              target="_blank"
            >
              <img
                v-if="platform.icon"
                :src="platform.icon"
                :alt="`Logo da plataforma de streaming ${platform.name}`"
                class="plattform-icon rounded col-2 me-2"
              />
              <span>{{ platform.name }}</span>
            </a>
          </li>
        </ul>
      </template>
    </nav>
  </DarkBox>
</template>

<script>
import Title from "@/components/Title.vue";
import DarkBox from "@/components/DarkBox.vue";
export default {
  components: {
    Title,
    DarkBox,
  },

  props: {
    id: {
      required: true,
    },
  },

  data() {
    return {
      platforms: [],
    };
  },

  methods: {
    getPlatformsAvaible() {
      const params = { id: this.id };

      this.$api
        .get("/obter-plataformas-filme", { params })
        .then((res) => {
          const response = res.data.dados;
          const success = res.data.sucesso;

          if (success) {
            this.platforms = response;

            console.log(response);
          }
        })
        .catch(() => {});
    },
  },

  computed: {
    loading() {
      const { buy, flatrate, rent } = this.platforms;

      return [buy, flatrate, rent].every((type) => !type || !type.length);
    },
  },

  created() {
    this.getPlatformsAvaible();
  },
};
</script>

<style scoded>
.plattform-icon {
  filter: grayscale(1) contrast(1.4);
  transition: .2s;
}

li:hover .plattform-icon {
  filter: grayscale(0) contrast(1);
}
</style>