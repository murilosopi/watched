<template>
  <div id="app">
    <router-view name="header"/>
    <router-view name="page" class="container my-auto px-4"/>
  </div>
</template>

<script>
export default {
  name: "App",
};
</script>

<style>
@import url(./assets/styles/base/colors.css);
@import url(./assets/styles/base/fonts.css);
@import url(./assets/styles/base/normalize.css);
</style>
