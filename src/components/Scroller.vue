<template>
  <div class="scroller">
    
    <div class="scroller-target">
      <slot></slot>
    </div>

    <button
      class="scroller-prev me-auto"
      type="button"
      v-show="scrollLeft"
      @mousedown.left="prevScrollPressing"
      @mouseup="clearTimer"
      @touchstart.prevent="prevScrollPressing"
      @touchend="clearTimer"
      @touchcancel="clearTimer"
    >
      <i class="bi bi-chevron-compact-left"></i>
    </button>
    <button
      class="scroller-next ms-auto"
      type="button"
      v-show="scrollLeft < maxScrollLeft"
      @mousedown.left ="nextScrollPressing"
      @mouseup="clearTimer"
      @touchstart.prevent="nextScrollPressing"
      @touchend="clearTimer"
      @touchcancel="clearTimer"
    >
      <i class="bi bi-chevron-compact-right"></i>
    </button>
  </div>
</template>

<script>
export default {

  data() {
    return {
      timerPressing: null,
      scrollLeft: 0,
      maxScrollLeft: 0
    }
  },

  methods: {
    nextScroll() {
      this.scrollLeft += 250;

      if(this.scrollLeft > this.maxScrollLeft) {
        this.scrollLeft = this.maxScrollLeft;
        this.clearTimer();
      }
    },

    prevScroll() {
      const minScroll = 250;

      if(this.scrollLeft < minScroll) {
        this.scrollLeft = 0;
        this.clearTimer();
      } else {
        this.scrollLeft -= minScroll;
      } 
    }, 
    prevScrollPressing() {
      this.scrollLeft -= 100
      this.timerPressing = setInterval(() => {
        this.prevScroll();
      }, 300);
    }, 
    nextScrollPressing() {
      this.scrollLeft += 100
      this.timerPressing = setInterval(() => {
        this.nextScroll();
      }, 300);
    },

    clearTimer() {
      clearInterval(this.timerPressing);
    },
  },

  watch: {
    scrollLeft(value) {
      this.container.scrollLeft = value;

      if(value < 0) {
        this.clearTimer();
        this.scrollLeft = 0;
      }
    },
  },

  mounted() {
    this.container = this.$el.querySelector('.scroller-target > *');

    this.maxScrollLeft = this.container.scrollWidth - this.container.clientWidth;

    window.document.addEventListener('mouseup', this.clearTimer);
  },

  beforeDestroy() {
    window.document.removeEventListener('mouseup', this.clearTimer);
  },

  updated() {
    this.maxScrollLeft = this.container.scrollWidth - this.container.clientWidth;
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
  justify-content: flex-start;
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
