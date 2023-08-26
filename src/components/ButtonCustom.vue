<template>
  <button
    class="button-custom w-100"
    :class="{ 'button-custom-azul': variant == 'azul' }"
  >
    <slot></slot>
  </button>
</template>

<script>
export default {
  props: ["variant"],
};
</script>

<style>
.button-custom {
  cursor: pointer;
  border: 0;
  outline: 0;
  border-radius: 0;
  padding-top: 0.3rem;
  padding-bottom: 0.3rem;
  text-align: center;
  background-color: var(--cor-azul-opaco);
  color: white;
  transition: 100ms;
}

.button-custom:hover {
  transform: scale(1.005) translateY(-1px);
}

.button-custom-azul {
  background-color: var(--cor-azul);
  color: white;
}
</style>