<template>
  <dl class="movie-details row">
    <div class="col-sm">
      <div class="d-flex gap-4" v-if="movie.originalTitle">
        <dt class="title h4">Original</dt>
        <dd>{{ movie.originalTitle }}</dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">Lançamento</dt>
        <dd>{{ movie.release }}</dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">Elenco</dt>
        <dd>
          <ul class="list-unstyled">
            <li v-for="(actor, idx) in movie.cast.split(';')" :key="idx">
              {{ actor }}
            </li>
          </ul>
        </dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">Direção</dt>
        <dd>{{ movie.director }}</dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">Roteiro</dt>
        <dd>{{ movie.screenwriter }}</dd>
      </div>
    </div>

    <div class="col-sm">
      <div class="d-flex gap-4">
        <dt class="title h4">Distribuição</dt>
        <dd>{{ movie.distribution }}</dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">Idiomas</dt>
        <dd>{{ movie.language }}</dd>
      </div>

      <div class="d-flex gap-4">
        <dt class="title h4">País</dt>
        <dd>{{ movie.country }}</dd>
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