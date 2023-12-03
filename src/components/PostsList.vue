<template>
  <ul class="posts-list list-unstyled row gap-3 justify-content-center">
    <li v-for="post in posts" :key="post.id" class="col-11">
      <UserPost :userpost="post"/>
    </li>
  </ul>
</template>

<script>
import { mapGetters } from 'vuex';
import UserPost from './UserPost.vue';
export default {
    computed: mapGetters('post', { posts: 'list' }),
    components: { UserPost }
}
</script>

<style>

</style>