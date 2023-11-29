<template>
  <DarkBox class="reaction-measurer p-4" variant="gray">
    <ul class="row list-unstyled row-gap-3">
      <li class="col-sm-6" v-for="reaction in reactions" :key="reaction.id">
        <div class="row align-items-center">
          <div class="col-2 pe-0">
            <InteractiveIcon tag="span" :inline="true" class="gap-2 ms-auto">
              <i
                class="reaction-measurer-icon bi"
                :class="`bi-${reaction.icon}`"
              ></i>
            </InteractiveIcon>
          </div>
          <div class="col ps-0 ps-sm-2 ps-md-3 text-center">
            <Title tag="h4" class="h6 fw-bold">
              {{ reaction.name }}
            </Title>
            <div
              class="small pointer"
              data-bs-toggle="tooltip"
              data-bs-placement="top"
              :data-bs-title="`${reaction.total} usuários reagiram`"
            >
              {{ reaction.percentage }}%
              <ProgressBar
                :progress="reaction.percentage"
                class="mt-1 w-100"
              />
            </div>
          </div>
        </div>
      </li>
    </ul>
  </DarkBox>
</template>

<script>
import DarkBox from "@/components/DarkBox.vue";
import InteractiveIcon from "@/components/InteractiveIcon.vue";
import ProgressBar from "@/components/ProgressBar.vue";
import Title from "@/components/Title.vue";
import BsTooltipMixin from "@/mixins/BsTooltipMixin";

export default {
  mixins: [BsTooltipMixin],
  props: ['movie'],
  data() {
    return {
      reactions: [
        {
          name: "triste",
          icon: "emoji-frown",
          id: 1,
          total: 0,
          percentage: 25,
        },
        {
          name: "tedioso",
          icon: "emoji-neutral",
          id: 2,
          total: 0,
          percentage: 12,
        },
        {
          name: "satisfeito",
          icon: "emoji-smile",
          id: 3,
          total: 0,
          percentage: 20,
        },
        {
          name: "animado",
          icon: "emoji-laughing",
          id: 4,
          total: 0,
          percentage: 34,
        },
        {
          name: "abismado",
          icon: "emoji-dizzy",
          id: 5,
          total: 0,
          percentage: 3,
        },
        {
          name: "amei",
          icon: "emoji-heart-eyes",
          id: 6,
          total: 0,
          percentage: 5,
        },
      ],
    };
  },
  components: { ProgressBar, DarkBox, InteractiveIcon, Title },
};
</script>

<style scoped>
.reaction-measurer-icon {
  font-size: calc(20px + 2vw);
}
</style>
