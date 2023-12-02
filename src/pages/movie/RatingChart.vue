<template>
  <DarkBox class="rating-measurer p-4" variant="gray">
    <ul class="d-flex flex-column list-unstyled gap-2">
      <li
        class="row align-items-center"
        v-for="(rating, stars) in ratings"
        :key="stars"
      >
        <div class="col-2">
          <InteractiveIcon tag="span" :inline="true" class="gap-2 ms-auto">
            {{ rating.stars }}
            <i class="bi bi-star"></i>
          </InteractiveIcon>
        </div>
        <div
          class="col"
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          :data-bs-title="`${
            rating.total == 0
              ? 'Nenhum usuário avaliou'
              : rating.total == 1
              ? '1 usuário avaliou'
              : `${rating.total} usuários avaliaram`
          } com ${rating.stars} estrela${rating.stars >= 1 ? 's' : ''}.`"
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
import BsTooltipMixin from "@/mixins/BsTooltipMixin";
import ReviewMixin from "@/mixins/ReviewMixin";
export default {
  components: { DarkBox, ProgressBar, InteractiveIcon },
  mixins: [BsTooltipMixin, ReviewMixin],
  props: ["movie"],

  computed: {
    ratings() {
      return [...this.starRating].reverse().map((r, i) => {
        r.color = this.getVariantStyle(i + 1);
        r.stars = 5 - i;
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
  },
};
</script>

<style></style>
