<template>
  <ul class="list-unstyled row gy-4">
    <li v-for="(review, index) in reviews" :key="review.id" class="col-lg-6 pe-lg-5 mb-4">
      <Comment :review="review" />

      <hr class="w-75" :class="{ 'ms-auto':  index%2}">
    </li>
  </ul>
</template>

<script>
import Comment from '@/components/Comment'
export default {
  components: {
    Comment
  },
  data() {
    return {
      reviews: []
    }
  }
}
</script>

<style>

</style>