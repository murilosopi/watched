<template>
  <div class="upload-image p-5 pointer text-center" :class="variant" @click="$refs.input.click()">
    <div
      class="upload-image-icon opacity-50 text-black"
    >
      <i class="bi bi-file-earmark-arrow-up h1"></i>
    </div>

    <input class="d-none" type="file" ref="input" @change="handlerChange" />
  </div>
</template>

<script>

export default {
    props: ['variant'],
    methods: {
        handlerChange() {
            const fileList = this.$refs.input.files;
            this.$emit("newFile", fileList[0]);
            this.$refs.input.value = "";
        },
    },
};
</script>

<style scoped>
.upload-image {
  border: none;
  outline: none;

  display: flex;
  align-items: center;
  justify-content: center;
  background: rgb(198, 198, 198);
  background: radial-gradient(
    circle,
    rgba(198, 198, 198, 1) 0%,
    rgba(136, 136, 136, 1) 32%,
    rgba(94, 94, 94, 1) 100%
  );
}

.upload-image-icon {
  transition: 0.2s;
}

.upload-image:hover .upload-image-icon {
  transform: scale(1.18);
}
</style>
