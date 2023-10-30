<template>
  <div class="row h-50 justify-content-center align-items-center">
    <div class="col-lg-4 col-3" v-for="emoji in emojis" :key="emoji.id">
      <InteractiveIcon
        class="mx-auto"
        :for="`emoji-reaction-${emoji.id}`"
        :class="{ disabled: disabled && !isReactionChecked(emoji.id) }"
        @click.native.prevent="checkReaction(emoji.id)"
      >
        <i
          class="bi fs-2"
          :class="{
            [`bi-${emoji.icon}`]: !isReactionChecked(emoji.id),
            [`bi-${emoji.icon}-fill`]: isReactionChecked(emoji.id),
          }"
        ></i>
        {{ emoji.value | capitalize }}
      </InteractiveIcon>
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
      reaction: this.value,
      emojis: [],
    };
  },
  methods: {

    checkReaction(id) {
      let value = id;
      if(this.isReactionChecked(id)) value = '';

      this.$emit('change', value);
    },

    isReactionChecked(reaction) {
      return this.value == reaction;
    },

    getReactions() {
      this.$api
        .get("/obter-icones-reacoes")
        .then((res) => {
          const response = res.data;

          if (response.sucesso) {
            this.emojis = response.dados.map((reaction) => {
              return {
                icon: reaction.icone,
                id: reaction.id,
                value: reaction.descricao,
              };
            });
          }
        })
        .catch(() => {});
    },
  },
  components: {
    InteractiveIcon,
  },
  computed: {
    disabled() {
      return `${this.value}`.length > 0;
    },
  },
  updated() {
    this.reactions = this.value;
  },
  created() {
    this.getReactions();
  },
};
</script>

<style>
.disabled {
  opacity: 0.35;
}
</style>