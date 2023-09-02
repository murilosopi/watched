<template>
  <div class="input-group input-custom mb-3">
    <div class="input-group-text" v-if="icon">
        <slot name="icon"></slot>
    </div>
    <slot name="input"></slot>
  </div>
</template>

<script>
export default {
  props: {
    icon: {
      type: Boolean,
      default: true,
    }
  }
};
</script>

<style>
.input-custom .input-group-text,
.input-custom .form-control {
  border: none!important;
  border-radius: 0!important;
  border-bottom: 1.5px solid white!important;
  outline: none!important;
  padding: 0.7rem!important;
  background-color: rgb(33, 33, 33) !important;
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
