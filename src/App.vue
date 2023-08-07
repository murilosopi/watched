<template>
  <div id="app">
    <PageHeader />
    <InputCustom>
      <i class="bi bi-lock-fill" slot="icon"></i>

      <input
        type="password"
        class="form-control"
        name="senha"
        placeholder="Senha"
        slot="input"
      />
    </InputCustom>
  </div>
</template>

<script>
import PageHeader from "@/components/PageHeader.vue";
import InputCustom from "@/components/InputCustom.vue";
export default {
  name: "App",
  components: {
    PageHeader,
    InputCustom,
  },
};
</script>

<style>
@import url(./assets/styles/base/colors.css);
@import url(./assets/styles/base/fonts.css);
@import url(./assets/styles/base/normalize.css);

@import url(./assets/styles/layout/l-poster.css);
</style>
