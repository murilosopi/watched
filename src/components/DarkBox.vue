<template>
  <div class="dark-box" :class="`${variant}`">
    <slot></slot>
  </div>
</template>

<script>
export default {
  props: {
    variant: String
  }
}
</script>

<style>
.dark-box {
  background: rgba(23, 23, 23, 0.90);
}

.dark-box.gray {
  background-color: rgba(217, 217, 217, 0.05);
}
</style>