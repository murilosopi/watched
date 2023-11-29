<template>
  <div class="progress-bar rounded-pill" :class="variant">
    <div class="progress-line" :style="{ width: `${progress}%` }"></div>
  </div>
</template>

<script>
export default {
  props: {
    progress: Number,
    variant: {
      type: String,
      default: 'light'
    }
  },
};
</script>

<style scoped>
.progress-bar {
  height: 10px;
  background-color: #383737;
}

.progress-line {
  height: 100%;
}

.progress-bar.light .progress-line {
  background-color: white;
}

.progress-bar:is(.cyan,.cyan-muted) .progress-line {
  background-color: var(--cor-ciano);
}

.progress-bar:is(.yellow,.yellow-muted) .progress-line {
  background-color: var(--cor-amarelo);
}

.progress-bar.red .progress-line {
  background-color: var(--cor-vermelho);
}

.progress-bar:is(.cyan-muted, .yellow-muted) .progress-line{
  filter: contrast(0.5) brightness(1.2);
}
</style>