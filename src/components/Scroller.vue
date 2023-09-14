<template>
  <div class="scroller">
    
    <div class="scroller-target">
      <slot></slot>
    </div>

    <button
      class="scroller-prev me-auto"
      type="button"
      @click="prevScroll"
    >
      <i class="bi bi-chevron-compact-left"></i>
    </button>
    <button
      class="scroller-next ms-auto"
      type="button"
      @click="nextScroll"
    >
      <i class="bi bi-chevron-compact-right"></i>
    </button>
  </div>
</template>

<script>
export default {
  methods: {
    nextScroll() {
      this.container.scrollLeft += 250;
    },

    prevScroll() {
      this.container.scrollLeft -= 250;
    }
  },

  mounted() {
    this.container = this.$el.querySelector('.scroller-target > *');
  }
};
</script>

<style scoped>
.scroller {
  position: relative;
  overflow-x: hidden;
}

.scroller .scroller-target > * {
  flex-wrap: nowrap !important;
  display: flex;
  width: 100%;
  padding: 0 1rem;
  justify-content: start;
  gap: 3rem 2rem;

  overflow-x: scroll;
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
  scroll-behavior: smooth;
}

.scroller .scroller-target > *::-webkit-scrollbar {
  display: none; /* Chrome */
}


.scroller :is(.scroller-prev, .scroller-next) {
  position: absolute;
  top: 0;
  height: 100%;
  font-size: 3rem;
  background: none;
  border: none;
  color: rgba(255, 255, 255, 0.6);
  transition: 150ms;
}

.scroller .scroller-prev {
  left: 0;
}

.scroller .scroller-next {
  right: 0;
}
.scroller :is(.scroller-prev:not(.disabled), .scroller-next):hover {
  color: white;
}

</style>
