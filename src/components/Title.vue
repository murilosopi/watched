<template>
  <component :is="tag" class="title mb-0">
    <slot></slot>
  </component>
</template>

<script>
export default {
  props: {
    tag: {
      default: 'h1'
    }
  }
};
</script>

<style>
.title {
  font-family: "Unica One";
}

.title a {
  color: white!important;
}
</style>
