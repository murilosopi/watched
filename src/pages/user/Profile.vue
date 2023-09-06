<template>
  <div class="user-profile">
    <DarkBox class="p-4">
      <div class="row">
        <div class="col-9 col-sm-8 col-md-6 col-lg-3 mb-4 mb-lg-0 mx-auto">
          <UserAvatar :username="username" />
        </div>

        <article class="col-lg-6 my-auto">
          <Title tag="h2"> @{{ username }} </Title>

          <div class="col-5" v-if="false">
            <ButtonCustom class="position-relative">
              Adicione um texto sobre você
              <span
                class="position-absolute top-0 start-100 translate-middle p-2 bg-danger rounded-circle"
              ></span>
            </ButtonCustom>
          </div>
          <template v-else>
            <p class="text-break w-100" :class="{placeholder: !alreadyLoaded}" style="white-space: pre-wrap;">
              {{ biography }}
            </p>
            <div class="col-7">
              <ButtonCustom>
                Alterar
                <i class="bi bi-pencil-square fs-5"></i>
              </ButtonCustom>
            </div>
          </template>
        </article>

        <UserStats :username="username"/>
      </div>
    </DarkBox>
  </div>
</template>

<script>
import PageMixin from "@/mixins/PageMixin";
import DarkBox from "@/components/DarkBox.vue";
import UserAvatar from "@/components/UserAvatar.vue";
import ButtonCustom from "@/components/ButtonCustom.vue";
import Title from "@/components/Title.vue";
import UserStats from "./UserStats.vue"
export default {
  mixins: [PageMixin],
  components: {
    DarkBox,
    UserAvatar,
    ButtonCustom,
    Title,
    UserStats
  },

  props: ["username"],

  computed: {
    alreadyLoaded() {
      return false;
    }
  },

  beforeRouteEnter(to, from, next) {
    next((page) => {
      page.changeFavicon("usuario", "svg");
    });
  },
};
</script>

<style></style>
