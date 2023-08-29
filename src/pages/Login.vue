<template>
  <div id="login">

    <div class="text-center">

      <Title class="display-3">
        Entre na sua conta
      </Title>
      <p>
        Se você ainda não tiver uma conta,
        <router-link to="/cadastro">
          <a class="text-light">cadastre-se aqui</a>
        </router-link>.
      </p>
    </div>

          
      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-7 col-xl-5">
          <InputCustom>
            <i class="bi bi-person-circle" slot="icon"></i>
            <input type="text" placeholder="Usuário" slot="input" class="form-control">
          </InputCustom>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-7 col-xl-5">
          <InputCustom>
            <i class="bi bi-lock-fill" slot="icon"></i>
            <input type="password" placeholder="Senha" slot="input" class="form-control">
          </InputCustom>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-7 col-xl-5">
          <div class="d-flex">
            <ButtonCustom class="me-2" @click.native="voltar">
              Voltar
            </ButtonCustom>
            <ButtonCustom variant="azul" class="ms-2">
              Entrar
            </ButtonCustom>
          </div>
        </div>
      </div>
    
  </div>
</template>

<script>

import InputCustom from '@/components/InputCustom.vue';
import Title from '@/components/Title.vue';
import ButtonCustom from '@/components/ButtonCustom.vue';
import router from '@/routes';
import PageMixin from '@/mixins/PageMixin.js';

export default {
  components: {
    InputCustom,
    Title,
    ButtonCustom
  },
  mixins: [PageMixin],
  methods: {
    voltar() {
      router.go(-1)
    }
  },
  created() {
    this.alterarFavicon('login-sign-up', 'svg');
    this.alterarTitle('Entre na Sua Conta');
  },
}
</script>

<style>

</style>