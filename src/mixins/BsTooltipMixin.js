import { Tooltip } from "bootstrap";
export default {
  methods: {
    initTooltips() {
      const tooltipTriggerList = this.$el.querySelectorAll(
        '[data-bs-toggle="tooltip"]'
      );
      tooltipTriggerList.forEach(
        (tooltipTriggerEl) => new Tooltip(tooltipTriggerEl)
      );
    },
  },
  updated() {
    this.initTooltips();
  },
  mounted() {
    this.initTooltips();
  },
};
