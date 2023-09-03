<template>
    <div class="line-box mt-4" :class="{'line-box-error': variant == 'error'}">
      <div class="line mb-3 w-50"></div>
      <div class="line mb-3 w-100"></div>
      <div class="line w-75"></div>
    </div>
</template>

<script>
export default {
  props: ['variant']
};
</script>

<style>
.line-box {
  width: 60%;
}

.line-box .line {
  border-top-right-radius: 1rem;
  border-bottom-right-radius: 1rem;
  height: 8px;
  overflow-x: hidden !important;
}

.line-box .line:nth-child(1) {
  background-color: var(--cor-ciano);
}

.line-box .line:nth-child(2) {
  background-color: var(--cor-amarelo);
}

.line-box .line:nth-child(3) {
  background-color: var(--cor-vermelho);
}

.line-box.line-box-error .line::after {
  content: "";
  display: block;
  position: absolute;
  width: 40vw;
  height: 40vw;
  background-repeat: no-repeat;
}

.line-box.line-box-error .line:nth-child(1)::after {
  background-image: url("../../public/assets/img/linebox/after-azul.svg");
  left: 30%;
  top: 2rem;
}

.line-box.line-box-error .line:nth-child(2)::after {
  background-image: url("../../public/assets/img/linebox/after-amarelo.svg");
  left: 60%;
  top: 3rem;
}

.line-box.line-box-error .line:nth-child(3)::after {
  background-image: url("../../public/assets/img/linebox/after-vermelho.svg");
  left: 45%;
  top: 6rem;
}
</style>
