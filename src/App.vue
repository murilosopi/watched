<template>
  <div id="app">
    <PageHeader />
    <Slider/>
  </div>
</template>

<script>

import PageHeader from '@/components/PageHeader.vue';
import Slider from '@/components/Slider.vue';
export default {
  name: 'App',
  components: {
    PageHeader, Slider
  }
}
</script>

<style>
  @import url(./assets/styles/base/colors.css);
  @import url(./assets/styles/base/fonts.css);
  @import url(./assets/styles/base/normalize.css);
</style>
