<template>
  <component :is="tag" class="badge rounded-pill border px-3 py-2">
    <slot></slot>
  </component>
</template>

<script>
export default {
  props: {
    tag: {
      type: String,
      default: 'span'
    }
  }
}
</script>

<style>

</style>