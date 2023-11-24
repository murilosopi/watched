import Tooltip from "bootstrap";
export default {
    mounted() {
        const tooltipTriggerList = this.$el.querySelectorAll('[data-bs-toggle="tooltip"]')
        tooltipTriggerList.map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl))
    }
}