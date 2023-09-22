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

          
      <form @submit.prevent="submit">
        <div class="row justify-content-center">
          <div class="col-md-10 col-lg-7 col-xl-5">
            <InputCustom>
              <i class="bi bi-person-circle" slot="icon"></i>
              <input type="text" placeholder="Usuário" slot="input" class="form-control" v-model="username" @keypress.enter.prevent>
            </InputCustom>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-10 col-lg-7 col-xl-5">
            <InputCustom>
              <i class="bi bi-lock-fill" slot="icon"></i>
              <input type="password" placeholder="Senha" slot="input" class="form-control" v-model="password" @keypress.enter.prevent="submit">
            </InputCustom>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-10 col-lg-7 col-xl-5">
            <div class="d-flex">
              <ButtonCustom class="me-2" @click.native="back">
                Voltar
              </ButtonCustom>
              <ButtonCustom variant="azul" class="ms-2" type="submit">
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
    ...mapActions('auth', {
      auth: 'doLogin'
    }),
    
    ...mapActions('notification', {
      notifyUser: 'addNotification'
    }),

    back() {
      router.go(-1)
    },

    submit() {
      if(this.isValid) {
        this.login();
      } else {
        this.notifyUser({
          icon: 'exclamation-diamond',
          title: 'Atenção',
          text: "preencha os campos necessários...",
          class: 'warning'
        })
      }
    },

    login() {
      this.auth({ username: this.username, password: this.password })
          .then(success => {
            if(success) {
              this.notifyUser({
                icon: 'box-arrow-in-left',
                text: "Login realizado com sucesso!",
                class: 'success'
              })
            } else {
              this.notifyUser({
                icon: 'x-circle',
                tite: 'Ops!',
                text: "As credenciais estão incorretas...",
                class: 'danger'
              })
            }
          })
    }
  },

  computed: {
    isValid() {
      return this.username.length && this.password.length;
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