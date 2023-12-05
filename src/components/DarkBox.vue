<template>
  <component :is="tag" class="dark-box rounded" :class="`${variant}`">
    <slot></slot>
  </component>
</template>

<script>
export default {
  props: {
    variant: {
      type: String,
      default: ''
    },
    tag: {
      default: 'div'
    }
  }
}
</script>

<style>
.dark-box {
  background-color: rgba(23, 23, 23, 0.90)!important;
}

.dark-box.gray {
  background-color: rgba(217, 217, 217, 0.05)!important;
}
</style>