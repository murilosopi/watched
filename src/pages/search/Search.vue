<template>
  <div id="search">
    <div class="row border-bottom border-dark">
      <ResultFilter class="col-11" />
      <SortingMenu class="col" />

      <hr />

      <div class="row gx-0">
        <div class="col-1 result-title-wrapper">
          <Title class="result-title display-4" tag="h2"> Perfis </Title>
        </div>
        <Scroller class="mt-5 col">
          <ul class="list-unstyled">
            <li
              class="col-md-3 col-sm-4 col-5"
              v-for="user in users"
              :key="user.id"
            >
              <router-link
                :to="`/usuario/${user.tag}`"
                class="text-light text-center"
              >
                <UserAvatar :username="user.tag" />
                <h3 class="h6 text-uppercase mt-2">@{{ user.tag }}</h3>
              </router-link>
            </li>
          </ul>
        </Scroller>
      </div>
    </div>
  </div>
</template>

<script>
import ResultFilter from "./ResultFilter.vue";
import SortingMenu from "@/components/SortingMenu.vue";
import UserAvatar from "@/components/UserAvatar.vue";
import Scroller from "@/components/Scroller.vue";
import Title from "@/components/Title.vue";

export default {
  components: {
    ResultFilter,
    SortingMenu,
    UserAvatar,
    Scroller,
    Title,
  },
  props: {
    search: String,
  },
  data() {
    return {
      users: [
        { tag: "kksopi", id: 1 },
        { tag: "kksopi", id: 2 },
        { tag: "kksopi", id: 3 },
        { tag: "kksopi", id: 4 },
        { tag: "kksopi", id: 5 },
        { tag: "kksopi", id: 6 },
        { tag: "kksopi", id: 7 },
        { tag: "kksopi", id: 8 },
        { tag: "kksopi", id: 9 },
        { tag: "kksopi", id: 10 },
        { tag: "kksopi", id: 11 },
        { tag: "kksopi", id: 12 },
      ],
    };
  },
};
</script>

<style scoped>
.result-title-wrapper {
  display: flex;
  align-items: center;
}

.result-title {
  writing-mode: vertical-rl;
  text-orientation: sideways;
  rotate: 180deg;
  margin: 0 auto !important;
  opacity: 0.5;
}
</style>