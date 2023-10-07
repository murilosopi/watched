<template>
  <Scroller>
    <ul class="user-reviews list-unstyled flex-nowrap justify-content-start align-items-center">
      <li
        v-for="review in reviews"
        :key="review.id"
        class="col-xl-6 col-lg-7 col-md-8 col-12 me-4"
      >
        <DarkBox class="row py-3 rounded">
          <div class="col-2 d-flex" v-if="review.reaction">
            <InteractiveIcon
              tag="span"
              class="m-auto"
              :title="
                review.reaction | reactionName
              "
            >
              <i class="bi bi-emoji-frown display-4"></i>
            </InteractiveIcon>
          </div>
          <div class="col">
            <div class="px-3">
                <h5 class="h6">
                <router-link :to="`/filme/${review.movieId}`" class="text-light fw-normal">
                  {{ review.movieTitle }}
                </router-link>
              </h5>
              <p class="small text-white-50">{{ review.text }}</p>
            </div>
          </div>
        </DarkBox>
      </li>
    </ul>
  </Scroller>
</template>

<script>
import InteractiveIcon from "@/components/InteractiveIcon.vue";
import DarkBox from "@/components/DarkBox.vue";
import Scroller from "@/components/Scroller.vue";
export default {
  components: {
    InteractiveIcon,
    DarkBox,
    Scroller,
  },

  props: {
    reviews: Array,
  },

  filters: {
    reactionName(value) {
      return value ? value.charAt(0).toUpperCase() + value.slice(1) : '';
    }
  }
};
</script>

<style></style>
