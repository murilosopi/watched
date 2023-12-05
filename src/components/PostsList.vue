<template>
  <ul class="posts-list list-unstyled row gap-3 justify-content-center">
    <li v-for="(post, index) in posts" :key="post.id" class="col-11">
      <UserPost :post="post" @delete="deletePost({ id: post.id, index })"/>
    </li>
  </ul>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import UserPost from './UserPost.vue';
export default {
    computed: mapGetters('post', { posts: 'list' }),
    methods: mapActions('post', { deletePost: 'delete' }),
    components: { UserPost }
}
</script>

<style>

</style>