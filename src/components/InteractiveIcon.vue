<template>
  <component
    :is="tag"
    class="interactive-icon d-flex align-items-center justify-content-center"
    :class="{
      'flex-column': !inline,
    }"
  >
    <slot></slot>
  </component>
</template>

<script>
export default {
  props: {
    tag: {
      default: "button",
    },
    inline: {
      default: false,
      type: Boolean,
    },
  },
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

.interactive-icon:hover i {
  transform: scale(1.05);
}
</style>
