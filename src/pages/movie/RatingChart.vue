<template>
  <DarkBox class="rating-measurer p-4" variant="gray">
    <ul class="d-flex flex-column list-unstyled gap-2">
      <li
        class="row align-items-center"
        v-for="(rating, stars) in ratings"
        :key="stars"
      >
        <div class="col-2">
          <InteractiveIcon :inline="true" class="gap-2 ms-auto">
            {{ 5 - stars }}
            <i class="bi bi-star"></i>
          </InteractiveIcon>
        </div>
        <div
          class="col"
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          :data-bs-title="`${rating.total} usuários avaliaram com ${
            stars + 1
          } estrela${ stars+1 >= 1 ? 's' : '' }.`"
        >
          <ProgressBar
            :progress="rating.percentage"
            class="w-100 pointer"
            :variant="rating.color"
          />
        </div>
      </li>
    </ul>
  </DarkBox>
</template>

<script>
import DarkBox from "@/components/DarkBox.vue";
import InteractiveIcon from "@/components/InteractiveIcon.vue";
import ProgressBar from "@/components/ProgressBar.vue";
import { Tooltip } from "bootstrap";
export default {
  components: { DarkBox, ProgressBar, InteractiveIcon },
  data() {
    return {
      starRating: [
        { percentage: 40, total: 400 },
        { percentage: 20, total: 200 },
        { percentage: 25, total: 250 },
        { percentage: 10, total: 100 },
        { percentage: 5, total: 50 },
      ],
    };
  },

  computed: {
    ratings() {
      return this.starRating.map((r, i) => {
        r.color = this.getVariantStyle(i + 1);
        return r;
      });
    },
  },

  methods: {
    getVariantStyle(rating) {
      switch (rating) {
        case 1:
          return "cyan";
        case 2:
          return "cyan-muted";
        case 3:
          return "yellow";
        case 4:
          return "yellow-muted";
        case 5:
          return "red";
        default:
          return "light";
      }
    },

    enableTooltips() {
      const tooltipTriggerList = this.$el.querySelectorAll(
        '[data-bs-toggle="tooltip"]'
      );

      if (tooltipTriggerList && tooltipTriggerList.length) {
        tooltipTriggerList.forEach(
          (tooltipTriggerEl) => new Tooltip(tooltipTriggerEl)
        );
      }
    },
  },

  mounted() {
    this.enableTooltips();
  },

  updated() {
    this.enableTooltips();
  },
};
</script>

<style></style>
