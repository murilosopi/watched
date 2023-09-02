<template>
  <div class="d-flex align-items-center">
    <ul class="list-unstyled d-inline-flex gap-1 me-2" :style="{cursor: edit ? 'pointer' : 'auto'}">
      <li
        v-for="v in 5"
        :key="v"
        @click="change(v)"
        @dblclick="change(v, true)"
      >
        <i v-if="v <= value" class="bi bi-star-fill"></i>

        <template v-else>
          <i
            v-if="v == Math.ceil(value) && value - Math.floor(value) != 0"
            class="bi bi-star-half"
          ></i>
          <i v-else class="bi bi-star"></i>
        </template>
      </li>
    </ul>
    <!-- Avaliação média -->
    <p class="me-auto me-sm-4">{{ value }}</p>
  </div>
</template>

<script>
export default {
  props: {
    value: [Number, String],
    edit: {
      type: Boolean,
      default: false,
    },
  },
  methods: {
    change(rating, float = false) {
      if (float) rating -= 0.5;

      if (this.edit) this.$emit("change", rating);
    },
  },
};
</script>

<style>
</style>