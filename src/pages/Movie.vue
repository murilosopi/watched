<template>
  <div class="movie">
    <DarkBox class="row px-4 py-5 mb-5" id="article-movie">
      <!-- Cartaz do filme -->
      <div class="col-3 d-none d-md-block">
        <MoviePoster
          :url="movie.cartaz"
          :title="movie.titulo"
          tag="figure"
          class="m-auto"
        ></MoviePoster>
      </div>
      <!-- Principais informações do filme -->
      <div class="col order-1 order-md-0">
        <div class="col p-0">
          <h2 class="h1 title">{{ movie.titulo }}</h2>
          <p>{{ movie.sinopse }}</p>
          <!-- Listagem de gêneros -->
          <BadgeList :badges="[]" />
          <div class="d-flex">
            <!-- Contagem de estrelas pela avaliação média -->
            <ul class="list-unstyled d-inline-flex gap-1 me-2">
              <li><i class="bi bi-star-fill"></i></li>
              <li><i class="bi bi-star-fill"></i></li>
              <li><i class="bi bi-star-fill"></i></li>
              <li><i class="bi bi-star-half"></i></li>
              <li><i class="bi bi-star"></i></li>
            </ul>
            <!-- Avaliação média -->
            <p class="me-auto me-sm-4">{{ movie.nota }}</p>
            <!-- Duração -->
            <p>
              <i class="bi bi-clock"></i>
              {{ movie.duracaoMin | duracao }}
            </p>
          </div>
        </div>
      </div>
      <div class="order-sm-0 order-1 col-sm-2 ps-5 p-md-0 mt-2 mt-sm-0">
        <div class="d-flex flex-wrap justify-content-end gap-3">
          <!-- Curtir/descurtir -->
          <IconButton>
            <i class="bi bi-heart"></i>
            0
          </IconButton>
          <!-- Marcar/desmarcar assistido -->
          <IconButton>
            <i class="bi bi-camera-reels"></i>
            0
          </IconButton>
          <!-- salvar/removerSalvoFilme -->
          <IconButton>
            <i class="bi bi-bookmark-star"></i>
            0
          </IconButton>
        </div>
      </div>
    </DarkBox>
    <MovieDetails :movie="movie" />
  </div>
</template>

<script>
import MoviePoster from "@/components/MoviePoster.vue";
import IconButton from "@/components/IconButton.vue";
import PageMixin from "@/mixins/PageMixin";
import DarkBox from "@/components/DarkBox.vue";
import BadgeList from "@/components/BadgeList.vue";
import MovieDetails from "@/components/MovieDetails.vue";
export default {
  components: {
    MoviePoster,
    IconButton,
    DarkBox,
    BadgeList,
    MovieDetails,
  },
  mixins: [PageMixin],
  filters: {
    duracao(valor) {
      if (valor < 60) {
        return `${valor}min`;
      }

      let horas = parseInt(valor / 60);
      let minutos = valor % 60;

      return `${horas}h${minutos}min`;
    },
  },
  props: ["id"],
  data() {
    return {
      movie: {},
    };
  },
  created() {
    this.alterarFavicon("filme", "svg");
    this.alterarTitle("Filme");
    this.obterDetalhesFilme();
    this.obterNotaFilme();
  },
  methods: {
    obterDetalhesFilme() {
      const params = { id: this.id };
      this.$api
        .get("/detalhes-filme", { params })
        .then((res) => {
          const response = res.data;

          if (response.sucesso) {
            this.movie = { ...response.dados, nota: this.movie.nota };
          }

          this.alterarTitle(this.movie.titulo);
        })
        .catch(() => {});
    },

    obterNotaFilme() {
      const params = { id: this.id };
      this.$api
        .get("/obter-nota-filme", { params })
        .then((res) => {
          const response = res.data;

          if (response.sucesso) {
            this.movie.nota = Number(response.dados.nota).toFixed(1);
          }
        })
        .catch(() => {});
    },
  },
};
</script>

<style>
.dark-box {
  background-color: rgb(23, 23, 23);
}
</style>