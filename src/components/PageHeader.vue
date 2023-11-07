<template>
  <header class="py-4">
    <template v-if="!error">
      <Navigation>
        <Title>
          <router-link to="/">
            <a class="fw-normal" href="/">Watched!</a>
          </router-link>
        </Title>

        <SearchBar :value="search" />

        <template v-if="userLogged">
          <ChatIcon class="ms-auto me-2" data-bs-toggle="modal" data-bs-target="#modal-chat" />
          <ChatModal />
        </template>

      </Navigation>
      <Dividers />
    </template>
    <Dividers v-else variant="error"/>
  </header>
</template>

<script>
import SearchBar from "@/components/SearchBar.vue";
import Title from "@/components/Title.vue";
import Navigation from "@/components/Navigation.vue";
import Dividers from "@/components/Dividers.vue";
import ChatIcon from "./ChatIcon.vue";
import ChatModal from "./ChatModal.vue";

export default {
  props: {
    error: {
      type: Boolean,
      default: false,
    },
    search: {
      type: String,
      default: ''
    }
  },
  components: {
    SearchBar,
    Title,
    Navigation,
    Dividers,
    ChatIcon,
    ChatModal
  }
};
</script>

<style></style>
