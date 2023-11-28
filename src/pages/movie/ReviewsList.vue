<template>
  <ul class="list-unstyled row">
    <li v-for="(review, index) in reviewsList" :key="review.id" class="col-lg-6 mb-4 px-0 px-lg-3"
      :class="index % 2 == 0 ? 'ps-lg-0' : 'pe-lg-0'">
      <DarkBox class="ps-4 p-3">
        <Comment :comment="review" @delete="deleteReview(review)" />
      </DarkBox>
    </li>
  </ul>
</template>

<script>
import Comment from "@/components/Comment";
import DarkBox from '@/components/DarkBox.vue';
import ReviewMixin from "@/mixins/ReviewMixin";
export default {
  components: {
    Comment,
    DarkBox
  },
  mixins: [ReviewMixin],
  props: {
    reviews: Array,
  }
};
</script>

<style></style>
