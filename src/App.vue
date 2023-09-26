<template>
  <div id="app">
    <router-view name="header"/>
    <NotificationList />
    <router-view name="page" class="container my-auto px-4 placeholder-glow"/>
  </div>
</template>

<script>
import NotificationList from './components/NotificationList.vue';
import AuthMixin from './mixins/AuthMixin';
export default {
  name: "App",
  components: {
    NotificationList
  },
  mixins: [AuthMixin],
  created() {
    this.checkAuth();
  }
};
</script>

<style>
@import url(./assets/styles/base/colors.css);
@import url(./assets/styles/base/fonts.css);
@import url(./assets/styles/base/normalize.css);
</style>
