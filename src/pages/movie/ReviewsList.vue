<template>
  <ul class="list-unstyled row">
    <li
      v-for="(review, index) in reviews"
      :key="review.id"
      class="col-lg-6 mb-4 px-0 px-lg-3"
      :class="index%2 == 0 ? 'ps-lg-0' : 'pe-lg-0'"
    >
      <DarkBox class="ps-4 p-3">
        <Comment :comment="review" />
      </DarkBox>
    </li>
  </ul>
</template>

<script>
import Comment from "@/components/Comment";
import DarkBox from '@/components/DarkBox.vue';
export default {
  components: {
    Comment,
    DarkBox
  },
  props: {
    reviews: Array,
  },
};
</script>

<style></style>
