<template>
  <main>

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

          
      <form @submit.prevent="login">
        <div class="row justify-content-center">
          <div class="col-md-10 col-lg-7 col-xl-5">
            <InputCustom>
              <i class="bi bi-person-circle" slot="icon"></i>
              <input type="text" placeholder="Usuário" slot="input" class="form-control" v-model="username">
            </InputCustom>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-10 col-lg-7 col-xl-5">
            <InputCustom>
              <i class="bi bi-lock-fill" slot="icon"></i>
              <input type="password" placeholder="Senha" slot="input" class="form-control" v-model="password">
            </InputCustom>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-10 col-lg-7 col-xl-5">
            <div class="d-flex">
              <ButtonCustom class="me-2" @click.native="back">
                Voltar
              </ButtonCustom>
              <ButtonCustom variant="azul" class="ms-2">
                Entrar
              </ButtonCustom>
            </div>
          </div>
        </div>
      </form>
    
    </main>
</template>

<script>

import InputCustom from '@/components/InputCustom.vue';
import Title from '@/components/Title.vue';
import ButtonCustom from '@/components/ButtonCustom.vue';
import router from '@/routes';
import PageMixin from '@/mixins/PageMixin.js';
import { mapActions } from 'vuex';

export default {
  components: {
    InputCustom,
    Title,
    ButtonCustom
  },
  data() {
    return {
      username: '',
      password: '',
    }
  },
  mixins: [PageMixin],
  methods: {
    ...mapActions('auth', ['doLogin']),
    back() {
      router.go(-1)
    },
    login() {
      this.doLogin({ username: this.username, password: this.password });
    }
  },
  created() {
    this.changeFavicon('login-sign-up', 'svg');
    this.changePageTitle('Entre na Sua Conta');
  },
}
</script>

<style>

</style>