<template>
  <li class="list-group-item bg-transparent d-flex align-items-center fw-bold">
    <slot></slot>
  </li>
</template>

<script>
export default {

}
</script>

<style scoped>
.list-group-item {
  color: gray;
  cursor: pointer;
  border-color: #202020;
  transition: 0.35s;
}

.list-group-item:hover {
  background-color: #1e1e1e;
  color: white;
}
</style>