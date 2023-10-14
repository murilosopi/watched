<template>
  <div id="search">
    <div class="row border-bottom border-dark">

      <ResultFilter class="col-11"/>
      <SortingMenu class="col" />
      
    </div>
  </div>
</template>

<script>
import ResultFilter from './ResultFilter.vue';
import SortingMenu from '@/components/SortingMenu.vue';

export default {
  components: {
    ResultFilter,
    SortingMenu
  },
  props: {
    search: String
  },
}
</script>

<style>

</style>