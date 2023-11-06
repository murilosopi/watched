<template>
  <div class="dropdown" data-bs-theme="dark">
    <InteractiveIcon class="toggler" data-bs-auto-close="outside" @click.native="toggleDropdown" data-bs-toggle="dropdown">
      <i class="bi bi-sort-down fs-4"></i>
    </InteractiveIcon>
    <ul class="dropdown-menu">
      <li>
        <Title tag="label" class="dropdown-item">
          <i class="me-2 bi bi-bar-chart-line"></i>
          Maior Relevância
          <input
            type="radio"
            v-model="sortBy"
            value="relevance"
            class="d-none"
          />
        </Title>
      </li>
      <li>
        <Title tag="label" class="dropdown-item">
          <i class="me-2 bi bi-stars"></i>
          Mais Recentes
          <input type="radio" v-model="sortBy" value="recent" class="d-none" />
        </Title>
      </li>
      <li>
        <Title tag="label" class="dropdown-item">
          <i class="me-2 bi bi-clock-history"></i>
          Mais Antigos
          <input type="radio" v-model="sortBy" value="old" class="d-none" />
        </Title>
      </li>
    </ul>
  </div>
</template>

<script>
import InteractiveIcon from "@/components/InteractiveIcon.vue";
import Title from "@/components/Title.vue";
import { Dropdown } from "bootstrap";
export default {
  components: {
    InteractiveIcon,
    Title
  },
  data() {
    return {
      sortBy: null,
    };
  },
  methods: {
    toggleDropdown() {
      this.dropdown.toggle()
    }
  },
  watch: {
    sortBy() {
      this.$emit('change', this.sortBy);
    }
  },
  created() {
    this.sortBy = 'relevance'
  },
  mounted() {
    this.dropdown = new Dropdown(this.$el.querySelector('.toggler'))
  }
};
</script>

<style>
.active,
.dropdown-item:has(input:checked) {
  color: black;
  background-color: white;
}

.dropdown-menu {
  background-color: var(--cor-dark);
}

.dropdown-menu .dropdown-item:is(:active) {
  background-color: transparent !important;
  color: white !important;
}
</style>