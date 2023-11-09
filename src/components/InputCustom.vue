<template>
  <div class="input-group input-custom">
    <div class="input-group-text" v-if="icon">
        <slot name="icon"></slot>
    </div>
    <slot name="input"></slot>
    <div class="input-group-text" v-if="button">
        <slot name="button"></slot>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    icon: {
      type: Boolean,
      default: true,
    },
    button: {
      type: Boolean,
      default: false,
    }
  }
};
</script>

<style>
.input-custom :is(.input-group-text, .form-control) {
  border: none!important;
  outline: none!important;
  padding-top: 0.7rem!important;
  padding-bottom: 0.7rem!important;
  background-color: rgb(33, 33, 33) !important;
}

.input-custom :is(.input-group-text, .form-control):not(.rounded-pill) {
  border-radius: 0!important;
}

.input-custom :is(.input-group-text, .form-control):not(.border-0, .border-bottom-0) {
  border-bottom: 1.5px solid white!important;
}

.input-custom .input-group-text,
.input-custom .form-control,
.input-custom .form-control::placeholder,
.input-custom .form-floating label {
  color: rgba(255, 255, 255, 0.6)!important;
}

.input-custom .form-control:focus {
  box-shadow: none!important;
}
</style>
