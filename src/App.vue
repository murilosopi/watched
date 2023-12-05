<template>
  <div id="app">
    <router-view name="header" />
    <NotificationList />
    <router-view name="page" class="container my-auto px-4 placeholder-glow" />
    <PostModal id="post-modal" />
    <ButtonPost
      v-if="userLogged"
      data-bs-toggle="modal"
      data-bs-target="#post-modal"
    />
  </div>
</template>

<script>
import ButtonPost from "./components/ButtonPost.vue";
import NotificationList from "./components/NotificationList.vue";
import PostModal from "./components/PostModal.vue";
import { mapActions } from "vuex";
export default {
  name: "App",
  components: {
    NotificationList,
    ButtonPost,
    PostModal,
  },
  methods: {
    ...mapActions('post', ['fetchPosts'])
  },
  created() {
    this.checkAuth();
    this.fetchPosts();
  },
};
</script>

<style>
@import url(./assets/styles/base/colors.css);
@import url(./assets/styles/base/fonts.css);
@import url(./assets/styles/base/normalize.css);
@import url(./assets/styles/custom/utilities.css);
@import "~@sweetalert2/theme-dark/dark.css";
</style>
