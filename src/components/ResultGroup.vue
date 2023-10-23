<template>
  <div class="result-group row gx-0">
    <div class="col-1 result-group-title-wrapper" v-if="title">
      <Title class="result-group-title display-4 px-3" tag="h2">{{ title }}</Title>
    </div>
    <Scroller class="mt-md-5 col-md">
      <slot></slot>
    </Scroller>
  </div>
</template>

<script>
import Scroller from '@/components/Scroller.vue';
import Title from '@/components/Title.vue';
export default {
  components: {
    Scroller,
    Title
  },
  props: {
    title: String
  }
}
</script>

<style scoped>
.result-group-title-wrapper {
  display: flex;
  align-items: center;
}

.result-group-title {
  opacity: 0.5;
}

@media (min-width: 768px) {
  .result-group-title {
    writing-mode: vertical-rl;
    text-orientation: sideways;
    rotate: 180deg;
    margin: 0 auto !important;
  }
}
</style>