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

    <form @submit.prevent="signUp" @keypress.enter.prevent="signUp">
      <div class="row justify-content-center">
        <div class="col-md-7">
          <InputCustom class="mb-3">
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
          <InputCustom class="mb-3">
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
          <InputCustom class="mb-3">
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
          <InputCustom class="mb-3">
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
          <InputCustom class="mb-3">
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
import router from "@/routes";

export default {
  components: {
    InputCustom,
    Title,
    ButtonCustom,
  },
  mixins: [PageMixin],
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
      if(this.validate()) {
        const params = {
          nome: this.name,
          user: this.tag,
          email: this.email,
          senha : this.password
        }

        this.$api.post('/usuario/cadastrar', params)
          .then(res => {
            const response = res.data;
            
            if(response.sucesso) {
              this.notifyUser({
                icon: "check",
                title: "Sucesso",
                text: "usuário cadastro!",
                class: "success",
              });

              this.auth({ username: this.tag, password: this.password })
                .then(success => {
                  if(success) {
                    router.push('/');
                  }
                });
            } else {
              this.notifyUser({
                icon: "x-octagon",
                title: "Erro",
                text: "não foi possível efetuar o cadastro...",
                class: "danger",
              });
            }
          });
      }
    },
    
    validatePassword(password) {
      return /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/.test(password);
    },

    validateEmail(email) {
      return /\S+@\S+\.\S+/.test(email);
    },

    validate() {
      if (
        !this.tag ||
        !this.name ||
        !this.email ||
        !this.password ||
        !this.passwordConfirmation
      ) {
        this.notifyUser({
          icon: "exclamation-diamond",
          title: "Atenção",
          text: "os campos não foram preenchidos corretamente!",
          class: "warning",
        });
        return false;
      }

      if(!this.validateEmail(this.email)) {
        this.notifyUser({
          icon: "exclamation-diamond",
          title: "Atenção",
          text: "o e-mail fornecido é inválido!",
          class: "warning",
        });
        return false;
      }

      if (this.password != this.passwordConfirmation) {
        this.notifyUser({
          icon: "exclamation-diamond",
          title: "Atenção",
          text: "as senhas passadas são diferentes!",
          class: "warning",
        });
        return false;
      }

      if(!this.validatePassword(this.password)) {
        this.notifyUser({
          icon: "exclamation-diamond",
          title: "Senha Fraca",
          text: "sua senha deve ter no mínimo 8 caracteres contendo: letras maiúscula e minúscula, números e caracteres especiais!",
          class: "warning",
        });
        return false;
      }

      return true;
    },
    // reset() {
    //   this.tag = '';
    //   this.name = '';
    //   this.email = '';
    //   this.password = '';
    //   this.passwordConfirmation = '';
    // }
  },
  created() {
    this.changeFavicon("login-sign-up", "svg");
    this.changePageTitle("Crie Sua Conta");
  },
};
</script>

<style></style>
