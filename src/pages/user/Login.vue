<template>
  <main>
    <div class="text-center">
      <Title class="display-3"> Entre na sua conta </Title>
      <p>
        Se você ainda não tiver uma conta,
        <router-link to="/cadastro">
          <a class="text-light">cadastre-se aqui</a> </router-link
        >.
      </p>
    </div>

    <form @submit.prevent="submit">
      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-7 col-xl-5">
          <InputCustom class="mb-3">
            <i class="bi bi-person-circle" slot="icon"></i>
            <input
              type="text"
              placeholder="Usuário"
              slot="input"
              class="form-control"
              v-model="username"
              @keypress.enter.prevent
            />
          </InputCustom>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-7 col-xl-5">
          <InputCustom class="mb-3" :button="true">
            <i class="bi bi-lock-fill" slot="icon"></i>
            <input
              placeholder="Senha"
              :type="passwordVisible ? 'text' : 'password'"
              slot="input"
              class="form-control"
              v-model="password"
              @keypress.enter.prevent="submit"
            />
            <InteractiveIcon
              class="opacity-75"
              slot="button"
              type="button"
              @click.native="passwordVisible = !passwordVisible"
            >
              <i
                class="bi"
                :class="{
                  'bi-eye-slash': passwordVisible,
                  'bi-eye': !passwordVisible,
                }"
              ></i>
            </InteractiveIcon>
          </InputCustom>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-7 col-xl-5">
          <div class="d-flex">
            <ButtonCustom class="me-2" @click.native="back" type="button">
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
import InputCustom from "@/components/InputCustom.vue";
import Title from "@/components/Title.vue";
import ButtonCustom from "@/components/ButtonCustom.vue";
import PageMixin from "@/mixins/PageMixin.js";
import InteractiveIcon from "@/components/InteractiveIcon.vue";
import router from "@/routes";
import Swal from "sweetalert2";

export default {
  components: {
    InputCustom,
    Title,
    ButtonCustom,
    InteractiveIcon,
  },
  data() {
    return {
      username: "",
      password: "",
      passwordVisible: false,
    };
  },
  mixins: [PageMixin],
  methods: {
    back() {
      router.go(-1);
    },

    submit() {
      if (this.isValid) {
        this.login();
      } else {
        this.notifyUser({
          icon: "exclamation-diamond",
          title: "Atenção",
          text: "preencha os campos necessários...",
          class: "warning",
        });
      }
    },

    login() {
      Swal.fire({
        title: "Carregando...",
        html: `
        <p>Aguarde alguns instantes, estamos validando suas informações.</p>
        <div class="pb-4">
          <div class="spinner-grow text-light" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <div class="spinner-grow text-light" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <div class="spinner-grow text-light" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>  
        </div>`,
        allowEscapeKey: false,
        allowOutsideClick: false,
        showConfirmButton: false,
      });

      this.auth({ username: this.username, password: this.password }).then(
        (response) => {
          Swal.close();

          if (response.success) {
            this.notifyUser({
              icon: "box-arrow-in-left",
              text: "Login realizado com sucesso!",
              class: "success",
            });
            router.push("/");
          } else if (response.descricao == "validacao") {
            Swal.fire({
              title:
                '<i class="bi bi-envelope-check"></i> Verificação de E-mail',
              text: "Por favor, insira abaixo o token que te enviamos em seu e-mail: ",
              input: "text",
              inputLabel: "Seu Token",
              inputValidator: async (token) => {
                if (!token) {
                  return "Preencha seu token!";
                }

                const { sucesso: valid } = await this.checkToken({
                  token,
                  username: this.username,
                  password: this.password,
                });

                if (!valid) {
                  return "Token incorreto!";
                } else {
                  this.notifyUser({
                    icon: "box-arrow-in-left",
                    text: "Acesso autorizado!",
                    class: "success",
                  });
                }
              },
            });
          } else {
            this.notifyUser({
              icon: "x-circle",
              tite: "Ops!",
              text: "As credenciais estão incorretas...",
              class: "danger",
            });
          }
        }
      );
    },
  },

  computed: {
    isValid() {
      return this.username.length && this.password.length;
    },
  },
  created() {
    this.changeFavicon("login-sign-up", "svg");
    this.changePageTitle("Entre na Sua Conta");

    if(this.userLogged) {
      router.push('/');
    }
  },
  watch: {
    userLogged() {
      if(this.userLogged) {
        router.push('/');
      }
    }
  }
};
</script>

<style></style>
