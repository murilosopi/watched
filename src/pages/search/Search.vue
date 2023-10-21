<template>
  <div id="search">
    <div class="row border-bottom border-dark">
      <ResultFilter class="col-11" />
      <SortingMenu class="col" />

      <hr />

      <ResultGroup title="Perfis">
        <ul class="list-unstyled">
          <li class="col-md-3 col-sm-4 col-5" v-for="user in users" :key="user.id">
            <router-link :to="`/usuario/${user.tag}`" class="text-light text-center">
              <UserAvatar :username="user.tag" />
              <Title class="h5 mt-2">@{{ user.tag }}</Title>
            </router-link>
          </li>

          <template v-if="!users.length">
            <li class="col-md-3 col-sm-4 col-5" v-for="i in 10" :key="i">
              <UserAvatar username=""/>
              <div class="row">
                <div class="placeholder mt-3 py-3 rounded px-3 col-8 mx-auto"></div>
              </div>
            </li>
          </template>


        </ul>
      </ResultGroup>

      <ResultGroup title="Filmes">
        <MoviesPanel :movies="movies" :inline="true"/>
      </ResultGroup>

    </div>
  </div>
</template>

<script>
import ResultFilter from "./ResultFilter.vue";
import SortingMenu from "@/components/SortingMenu.vue";
import UserAvatar from "@/components/UserAvatar.vue";
import ResultGroup from "@/components/ResultGroup.vue";
import MoviesPanel from "@/components/MoviesPanel.vue";
import Title from "@/components/Title.vue";

import PageMixin from "@/mixins/PageMixin";

export default {
  mixins: [PageMixin],

  components: {
    ResultFilter,
    SortingMenu,
    UserAvatar,
    ResultGroup,
    MoviesPanel,
    Title
  },
  props: {
    search: String,
  },
  data() {
    return {
      users: [],

      movies: [],
    };
  },
  methods: {
    doSearch() {
      const params = { pesquisa: this.search };
      this.$api.get('/pesquisar-filmes', { params }).then(res => {
        const response = res.data;

        if(response.dados && response.dados.length) {
          this.movies = [...response.dados];
        } else {
          this.notFound();
        }
      });
    },

    notFound() {
      this.notifyUser({
        icon: "emoji-astonished-fill",
        title: "Ops",
        text: "não foram encontrado resultados...",
        class: "warning",
      });
      this.$router.back();
    }

  },
  created() {
    this.changeFavicon("pesquisa", "svg");
    this.changePageTitle(`Pesquisa - ${this.search}`);
    this.doSearch();
  },
  watch: {
    search() {
      this.movies = [];
      this.doSearch();
    }
  }
};
</script>