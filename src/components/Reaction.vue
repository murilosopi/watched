<template>
  <div class="row justify-content-center align-items-center">
    <div class="col-lg-4 col-3" v-for="emoji in emojis" :key="emoji.id">
      <InteractiveIcon class="mx-auto" tag="label" :for="`emoji-reaction-${emoji.id}`" :class="{disabled: disabled && !isReactionChecked(emoji.value)}">
        <i
          class="bi fs-2"
          :class="{
            [`bi-${emoji.icon}`]: !isReactionChecked(emoji.value),
            [`bi-${emoji.icon}-fill`]: isReactionChecked(emoji.value)
          }"
        ></i>
        {{ emoji.value | capitalize }}
      </InteractiveIcon>

      <input
        type="checkbox"
        v-model="reactions"
        :id="`emoji-reaction-${emoji.id}`"
        :value="emoji"
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
      emojis: [],
    };
  },
  methods: {
    updateReactions(event) {
      if(!this.disabled || this.isReactionChecked(event.target.value)) {
        this.$emit("change", this.reactions);
      }
    },

    isReactionChecked(reaction) {
      return this.value.some((r) => r.value == reaction);
    },

    getReactions() {
      this.$api
        .get('/obter-icones-reacoes')
        .then(res => {
          const response = res.data;

          if(response.sucesso) {
            this.emojis = response.dados.map(reaction => {
              return {
                icon: reaction.icone,
                id: reaction.id,
                value: reaction.descricao
              }
            });
          }
        })
        .catch(() => {});
    }
  },
  components: {
    InteractiveIcon,
  },
  computed: {
    disabled() {
      return this.value.length === 1;
    }
  },
  updated() {
    this.reactions = this.value;
  },
  created() {
    this.getReactions();
  }
};
</script>

<style>
.disabled {
  opacity: 0.35;
}
</style>