<template>
  <button class="icon-button d-flex flex-column align-items-center">
    <slot></slot>
  </button>
</template>

<script>
export default {};
</script>

<style>
.icon-button {
  background: none;
  border: none;
  outline: none;
  color: white;
  transition: 100ms ease-in-out;
}

.icon-button i {
  font-size: 1.5rem;
}

.icon-button:hover {
  transform: scale(1.05);
}
</style>
