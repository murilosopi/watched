<template>
  <dl class="movie-details row">
    <div class="col-sm">
      <div class="d-flex gap-4" v-if="movie.tituloOriginal">
        <dt class="title h4">Original</dt>
        <dd>{{ movie.tituloOriginal }}</dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">Lançamento</dt>
        <dd>{{ movie.anoLancamento }}</dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">Elenco</dt>
        <dd>
          <ul class="list-unstyled">
            <li v-for="(ator, idx) in movie.elenco.split(';')" :key="idx">
              {{ ator }}
            </li>
          </ul>
        </dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">Direção</dt>
        <dd>{{ movie.direcao }}</dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">Roteiro</dt>
        <dd>{{ movie.roteiro }}</dd>
      </div>
    </div>

    <div class="col-sm">
      <div class="d-flex gap-4">
        <dt class="title h4">Distribuição</dt>
        <dd>{{ movie.distribuicao }}</dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">Idiomas</dt>
        <dd>{{ movie.idioma }}</dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">País</dt>
        <dd>{{ movie.pais }}</dd>
      </div>
    </div>
  </dl>
</template>

<script>
export default {
  props: {
    movie: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style>
</style>