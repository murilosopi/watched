<template>
  <component :is="tag" class="poster-card">
    <img
      class="poster-img w-100"
      :src="url"
      :alt="`Cartaz do filme ${title}`"
      v-if="url"
    />
    <div
      class="poster-img w-100"
      v-else>
    </div>

    <slot></slot>
  </component>
</template>

<script>
export default {
  props: {
    title: String,
    url: String,
    tag: {
      type:String,
      default: 'article'
    }
  }
};
</script>

<style>
.poster-card {
  aspect-ratio: 4 / 6;
  border-bottom: 2px solid white;
  transition: 200ms cubic-bezier(0.445, 0.05, 0.55, 0.95);
}

.poster-card:hover {
  transform: scale(1.08);
}

.poster-card .poster-inner {
  visibility: hidden;
  opacity: 0;
  transition: 250ms;
  padding: 0.8rem;
}

.poster-card:hover .poster-inner {
  box-shadow: inset 0 0 5rem 3rem rgba(0, 0, 0, 0.5);
  visibility: visible;
  opacity: 1;
}

.poster-card .poster-title {
  font-size: 1.1rem;
}

.poster-card .poster-rating {
  font-size: 1rem;
}
</style>