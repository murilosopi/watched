<template>
  <div>
    <button type="button" @click="$refs.input.click()">Nova Imagem</button>

    <input class="d-none" type="file" ref="input" @change="handlerChange" />
  </div>
</template>

<script>
export default {
  methods: {
    handlerChange() {
      const fileList = this.$refs.input.files;

      this.$emit("newFile", fileList[0]);

      this.$refs.input.value = "";
    },
  },
};
</script>

<style></style>
