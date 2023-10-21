<template>
  <dl class="movie-details row">
    <div class="col-sm">
      <div class="d-flex gap-4" v-if="details.originalTitle">
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
            <li v-for="(actor, idx) in details.cast" :key="idx">
              {{ actor.name }} <span class="fst-italic">({{ actor.character }})</span>
            </li>
          </ul>
        </dd>
      </div>
    </div>
  </dl>
</template>

<script>
export default {
  props: {
    id: {
      required: true
    },
    details: {
      default: () => ({}),
    }

  },

  computed: {
    loading() {
      return Object.values(this.details).every(value => !value);
    }
  },
};
</script>

<style>
</style>