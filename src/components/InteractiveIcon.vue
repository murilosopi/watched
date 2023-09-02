<template>
  <component :is="tag" class="interactive-icon d-flex flex-column align-items-center">
    <slot></slot>
  </component>
</template>

<script>
export default {
  props: {
    tag: {
      default: 'button'
    }
  }
};
</script>

<style>
.interactive-icon {
  background: none;
  border: none;
  outline: none;
  color: white;
  transition: 100ms ease-in-out;
  cursor: pointer;
}

.interactive-icon i {
  font-size: 1.5rem;
}

.interactive-icon:hover i {
  transform: scale(1.05);
}
</style>
