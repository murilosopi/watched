<template>
  <div class="d-flex align-items-center">
    <ul class="list-unstyled d-inline-flex gap-1 me-2 star-rating-list mb-0" :class="{edit}">
      <li
        class="star-rating-item"
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
    <p class="m-0">{{ value | rating }}</p>
  </div>
</template>

<script>
export default {
  filters: {
    rating(value) {
      return Number(value).toFixed(1);
    }
  },
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
.star-rating-list {
  font-size: 1.15rem; 
}

.star-rating-list.edit {
  cursor: pointer;
}

.star-rating-list.edit .star-rating-item:hover {
  transform: scale(1.05);
}
</style>