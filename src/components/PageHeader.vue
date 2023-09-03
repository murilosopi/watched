<template>
  <header class="py-4">
    <template v-if="!error">
      <Navigation>
        <Title>
          <router-link to="/">
            <a class="fw-normal" href="/">Watched!</a>
          </router-link>
        </Title>

        <SearchBar />

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
export default {
  props: {
    error: {
      type: Boolean,
      default: false,
    }
  },
  components: {
    SearchBar,
    Title,
    Navigation,
    Dividers,
  }
};
</script>

<style></style>
