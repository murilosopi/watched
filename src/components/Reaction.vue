<template>
  <div class="row justify-content-center align-items-center">
    <div class="col-lg-4 col-3" v-for="emoji in emojis" :key="emoji.value">
      <InteractiveIcon class="mx-auto" tag="label" :for="emoji.value">
        <i
          class="bi fs-2"
          :class="
            isReactionChecked(emoji.value) ? `${emoji.icon}-fill` : emoji.icon
          "
        ></i>
        {{ emoji.value | capitalize }}
      </InteractiveIcon>

      <input
        type="checkbox"
        v-model="reactions"
        :id="emoji.value"
        :value="emoji.value"
        hidden
        @change="updateReactions"
        :checked="isReactionChecked(emoji.value)"
      />
    </div>
  </div>
</template>

<script>
import InteractiveIcon from "./InteractiveIcon.vue";
export default {
  props: ["value"],
  filters: {
    capitalize(name) {
      const first = name.charAt(0);
      return name.replace(first, first.toUpperCase());
    },
  },
  data() {
    return {
      reactions: this.value,
      emojis: [
        { icon: "bi-emoji-frown", value: "triste" },
        { icon: "bi-emoji-neutral", value: "tedioso" },
        { icon: "bi-emoji-smile", value: "satisfeito" },
        { icon: "bi-emoji-laughing", value: "animado" },
        { icon: "bi-emoji-dizzy", value: "amei" },
        { icon: "bi-emoji-heart-eyes", value: "abismado" },
      ],
    };
  },
  methods: {
    updateReactions() {
      this.$emit("change", this.reactions);
    },

    isReactionChecked(reaction) {
      return this.value.some((r) => r == reaction);
    },
  },
  components: {
    InteractiveIcon,
  },
  updated() {
    this.reactions = this.value;
  },
};
</script>

<style>
</style>