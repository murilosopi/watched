<template>
  <div id="app">
    <router-view name="header"/>
    <NotificationList />
    <router-view name="page" class="container my-auto px-4 placeholder-glow"/>
    <ButtonPost v-if="userLogged" />
  </div>
</template>

<script>
import ButtonPost from './components/ButtonPost.vue';
import NotificationList from './components/NotificationList.vue';
export default {
  name: "App",
  components: {
    NotificationList,
    ButtonPost
},
  created() {
    this.checkAuth();
  }
};
</script>

<style>
@import url(./assets/styles/base/colors.css);
@import url(./assets/styles/base/fonts.css);
@import url(./assets/styles/base/normalize.css);
@import url(./assets/styles/custom/utilities.css);
@import '~@sweetalert2/theme-dark/dark.css';
</style>
