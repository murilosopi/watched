<template>
  <ul class="d-flex gap-2 list-unstyled mb-4 flex-wrap">
    <CustomBadge tag="li" v-for="badge in badges" :key="badge.text">
      <router-link v-if="badge.to" :to="badge.to">
        {{ badge.text }}
      </router-link>
      <template v-else>
        {{ badge.text }}
      </template>
    </CustomBadge>
  </ul>
</template>

<script>
import CustomBadge from "@/components/CustomBadge.vue";
export default {
  props: {
    badges: {
      type: Array,
      default: () => [],
    },
  },
  components: {
    CustomBadge,
  },
};
</script>

<style>
</style>