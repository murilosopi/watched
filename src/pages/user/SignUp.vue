<template>
  <main>
    <div class="text-center">
      <Title class="display-3"> Crie Sua Conta </Title>
      <p>
        Se você já tiver uma conta,
        <router-link to="/login">
          <a class="text-light">entre aqui</a> </router-link
        >.
      </p>
    </div>

    <form @submit.prevent="signUp" @keypress.enter.prevent>
      <div class="row justify-content-center">
        <div class="col-md-7">
          <InputCustom>
            <i class="bi bi-person-fill" slot="icon"></i>
            <input
              v-model="name"
              type="text"
              placeholder="Nome"
              slot="input"
              class="form-control"
            />
          </InputCustom>
        </div>

        <div class="col-md-5">
          <InputCustom>
            <i class="bi bi-person-badge-fill" slot="icon"></i>
            <input
              v-model="tag"
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
            <i class="bi bi-envelope-fill" slot="icon"></i>
            <input
              v-model="email"
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
            <i class="bi bi-lock-fill" slot="icon"></i>
            <input
              v-model="password"
              type="password"
              placeholder="Senha"
              slot="input"
              class="form-control"
            />
          </InputCustom>
        </div>
        <div class="col-md">
          <InputCustom>
            <i class="bi bi-lock-fill" slot="icon"></i>
            <input
              v-model="passwordConfirmation"
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
          <ButtonCustom class="me-2" @click.native.prevent="back">
            Voltar
          </ButtonCustom>
        </div>
        <div class="col-6 col-lg-4 col-xl-3">
          <ButtonCustom variant="azul" type="submit"> Cadastrar </ButtonCustom>
        </div>
      </div>
    </form>
  </main>
</template>

<script>
import InputCustom from "@/components/InputCustom.vue";
import Title from "@/components/Title.vue";
import ButtonCustom from "@/components/ButtonCustom.vue";
import PageMixin from "@/mixins/PageMixin";
import NotificationMixin from "@/mixins/NotificationMixin";
import router from "@/routes";

export default {
  components: {
    InputCustom,
    Title,
    ButtonCustom,
  },
  mixins: [PageMixin, NotificationMixin],
  data() {
    return {
      name: "",
      tag: "",
      email: "",
      password: "",
      passwordConfirmation: "",
    };
  },
  methods: {
    back() {
      router.go(-1);
    },
    signUp() {
      this.validate();
    },
    validate() {
      if (
        !this.name ||
        !this.tag ||
        !this.name ||
        !this.email ||
        !this.password ||
        !this.tag ||
        this.passwordConfirmation
      ) {
        this.notifyUser({
          icon: "exclamation-diamond",
          title: "Atenção",
          text: "os campos não foram preenchidos corretamente!",
          class: "warning",
        });
        return;
      }

      if (this.password != this.passwordConfirmation) {
        this.notifyUser({
          icon: "exclamation-diamond",
          title: "Atenção",
          text: "as senhas passadas são diferentes!",
          class: "warning",
        });
        return;
      }
    },
  },
  created() {
    this.changeFavicon("login-sign-up", "svg");
    this.changePageTitle("Crie Sua Conta");
  },
};
</script>

<style></style>
