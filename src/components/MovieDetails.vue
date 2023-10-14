<template>
  <dl class="movie-details row">
    <div class="col-sm">
      <div class="d-flex gap-4" v-if="details.originalTitle.length">
        <dt class="title h4">Original</dt>
        <dd :class="{placeholder:loading, 'w-100':loading}">{{ details.originalTitle || '' }}</dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">Lançamento</dt>
        <dd :class="{placeholder:loading, 'w-100':loading}">{{ details.release || '' }}</dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">Elenco</dt>
        <dd :class="{placeholder:loading, 'w-100':loading}">
          <ul class="list-unstyled">
            <li v-for="(actor, idx) in details.cast.split(';')" :key="idx">
              {{ details.actor || '' }}
            </li>
          </ul>
        </dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">Direção</dt>
        <dd :class="{placeholder:loading, 'w-100':loading}">{{ details.director || '' }}</dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">Roteiro</dt>
        <dd :class="{placeholder:loading, 'w-100':loading}">{{ details.screenwriter || '' }}</dd>
      </div>
    </div>

    <div class="col-sm">
      <div class="d-flex gap-4">
        <dt class="title h4">Distribuição</dt>
        <dd :class="{placeholder:loading, 'w-100':loading}">{{ details.distribution || '' }}</dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">Idiomas</dt>
        <dd :class="{placeholder:loading, 'w-100':loading}">{{ details.language || '' }}</dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">País</dt>
        <dd :class="{placeholder:loading, 'w-100':loading}">{{ details.country || '' }}</dd>
      </div>
    </div>
  </dl>
</template>

<script>
export default {
  props: ['id'],

  data() {
    return {
      details: {
        originalTitle: '',
        release: '',
        cast: '',
        director: '',
        screenwriter: '',
        distribution: '',
        language: '',
        country: ''
      },
    }
  },

  methods: {
    getMovieDetails() {
      const params = { id: this.id };
      this.$api
        .get("/detalhes-filme", { params })
        .then((res) => {
          const response = res.data.dados;
          const success = res.data.sucesso;

          if (success) {
            this.details = {
              originalTitle: response.tituloOriginal,
              release: response.anoLancamento,
              cast: response.elenco,
              director: response.direcao,
              screenwriter: response.roteiro,
              distribution: response.distribuicao,
              language: response.idioma,
              country: response.pais,
            }

          } else {
            // to do: lançar erros p/ exibir feedback visual
          }
        })
        .catch(() => {});
    },
  },

  computed: {
    loading() {
      return Object.values(this.details).every(value => !value);
    }
  },

  created() {
    this.getMovieDetails();
  }
};
</script>

<style>
</style>