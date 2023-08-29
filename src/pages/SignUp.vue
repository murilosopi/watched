<template>
  <div id="login">
    <div class="text-center">
      <Title class="display-3"> Crie Sua Conta </Title>
      <p>
        Se você já tiver uma conta,
        <router-link to="/login">
          <a class="text-light">entre aqui</a> </router-link
        >.
      </p>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-7">
        <InputCustom>
          <i class="bi bi-person-circle" slot="icon"></i>
          <input
            v-model="usuario.nome"
            type="text"
            placeholder="Nome"
            slot="input"
            class="form-control"
          />
        </InputCustom>
      </div>
      
      <div class="col-md-5">
        <InputCustom>
          <i class="bi bi-person-circle" slot="icon"></i>
          <input
            v-model="usuario.user"
            type="text"
            placeholder="Usuário"
            slot="input"
            class="form-control"
          />
        </InputCustom>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col">
        <InputCustom>
          <i class="bi bi-person-circle" slot="icon"></i>
          <input
            v-model="usuario.email"
            type="text"
            placeholder="E-mail"
            slot="input"
            class="form-control"
          />
        </InputCustom>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md">
        <InputCustom>
          <i class="bi bi-person-circle" slot="icon"></i>
          <input
            v-model="usuario.senha"
            type="password"
            placeholder="Senha"
            slot="input"
            class="form-control"
          />
        </InputCustom>
      </div>

      <div class="col-md">
        <InputCustom>
          <i class="bi bi-person-circle" slot="icon"></i>
          <input
            v-model="usuario.senhaConfirmacao"
            type="password"
            placeholder="Confirme sua senha"
            slot="input"
            class="form-control"
          />
        </InputCustom>
      </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-6 col-lg-4 col-xl-3">  
          <ButtonCustom class="me-2" @click.native="voltar">
            Voltar
          </ButtonCustom>
        </div>
        <div class="col-6 col-lg-4 col-xl-3">
          <ButtonCustom variant="azul" @click.native="cadastrar()"> Cadastrar </ButtonCustom>
        </div>
    </div>
  </div>
</template>

<script>
import InputCustom from "@/components/InputCustom.vue";
import Title from "@/components/Title.vue";
import ButtonCustom from "@/components/ButtonCustom.vue";
import PageMixin from "@/mixins/PageMixin";
import router from "@/routes";

export default {
  components: {
    InputCustom,
    Title,
    ButtonCustom,
  },
  mixins: [PageMixin],
  methods: {
    voltar() {
      router.go(-1);
    },
    cadastrar() {
      
    }
  },
  data() {
    return {
      usuario: {}
    }
  },
  created() {
    this.alterarFavicon('login-sign-up', 'svg');
    this.alterarTitle('Crie Sua Conta');
  },
};
</script>

<style>
</style>