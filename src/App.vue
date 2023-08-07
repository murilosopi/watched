<template>
  <div id="app">
    <PageHeader />
  </div>
</template>

<script>

import PageHeader from '@/components/PageHeader.vue';

export default {
  name: 'App',
  components: {
    PageHeader
  }
}
</script>

<style>
  @import url(./assets/styles/base/colors.css);
  @import url(./assets/styles/base/fonts.css);
  @import url(./assets/styles/base/normalize.css);
</style>
