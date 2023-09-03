<template>
  <div class="row justify-content-center align-items-center">
    <div class="col-lg-4 col-3">
      <InteractiveIcon class="mx-auto" tag="label" for="smile">
        <i class="bi fs-2 bi-emoji-smile"></i>
        Satisfeito
      </InteractiveIcon>
    </div>

    <div class="col-lg-4 col-3">
      <InteractiveIcon class="mx-auto" tag="label" for="laughing">
        <i class="bi fs-2 bi-emoji-laughing"></i>
        Animado
      </InteractiveIcon>
    </div>

    <div class="col-lg-4 col-3">
      <InteractiveIcon class="mx-auto" tag="label" for="heart-eyes">
        <i class="bi fs-2 bi-emoji-heart-eyes"></i>
        Amei
      </InteractiveIcon>
    </div>

    <div class="col-lg-4 col-3">
      <InteractiveIcon class="mx-auto" tag="label" for="dizzy">
        <i class="bi fs-2 bi-emoji-dizzy"></i>
        Abismado
      </InteractiveIcon>
    </div>

    <div class="col-lg-4 col-3">
      <InteractiveIcon class="mx-auto" tag="label" for="neutral">
        <i class="bi fs-2 bi-emoji-neutral"></i>
        Tedioso
      </InteractiveIcon>
    </div>

    <div class="col-lg-4 col-3">
      <InteractiveIcon class="mx-auto" tag="label" for="frown">
        <i class="bi fs-2 bi-emoji-frown"></i>
        Triste
      </InteractiveIcon>
    </div>


    <input @change="changeReactions" type="checkbox" v-model="reactions" id="smile" value="smile" hidden>
    <input @change="changeReactions" type="checkbox" v-model="reactions" id="laughing" value="laughing" hidden>
    <input @change="changeReactions" type="checkbox" v-model="reactions" id="heart-eyes" value="heart-eyes" hidden>
    <input @change="changeReactions" type="checkbox" v-model="reactions" id="dizzy" value="dizzy" hidden>
    <input @change="changeReactions" type="checkbox" v-model="reactions" id="neutral" value="neutral" hidden>
    <input @change="changeReactions" type="checkbox" v-model="reactions" id="frown" value="frown" hidden>
  </div>
</template>

<script>
import InteractiveIcon from './InteractiveIcon.vue';
export default {
  props: ['value'],
  data() {
    return {
      reactions: [...this.value]
    }
  },
  watch: {
    reactions() {
      this.$emit('change', this.reactions);
    }
  },
  methods: {
    changeReactions(event) {
      const el = event.target;
      const icon = document.querySelector(`label[for="${el.id}"] i`);

      if(!el.checked) {
        icon.className = icon.className.replace('-fill', '')
      } else if(this.reactions.length <= 3) {
        icon.className = `${icon.className}-fill`;
      } else {
        this.reactions.pop();
      }
    }
  },
  components: {
    InteractiveIcon
  }
};
</script>

<style>
</style>