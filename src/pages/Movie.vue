<template>
  <main class="l-movie">
    <DarkBox class="row px-4 py-5 mb-5" id="article-movie">
      <div class="col-3 d-none d-md-block">
        <MoviePoster
          :url="movie.url"
          :title="movie.title"
          tag="figure"
          class="m-auto"
        ></MoviePoster>
      </div>

      <div class="col order-1 order-md-0">
        <div class="col p-0">
          <h2 class="h1 title">{{ movie.title }}</h2>
          <p>{{ movie.synopsis }}</p>
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
            <p class="me-auto me-sm-4">{{ movie.rating }}</p>
            <!-- Duração -->
            <p>
              <i class="bi bi-clock"></i>
              {{ movie.minutes | duration }}
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

    <MovieDetails v-if="movieHasLoaded" :movie="{...this.movie}" />
  </main>
</template>

<script>
import PageMixin from "@/mixins/PageMixin";
import MoviePoster from "@/components/MoviePoster.vue";
import IconButton from "@/components/IconButton.vue";
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
    duration(value) {
      if (value < 60) {
        return `${value}min`;
      }

      let hours = parseInt(value / 60);
      let minutes = value % 60;

      return `${hours}h${minutes}min`;
    },
  },
  props: ["id"],
  data() {
    return {
      movie: {},
    };
  },
  created() {
    this.changeFavicon("filme", "svg");
    this.changePageTitle("Filme");
    this.getMovieDetails();
    this.getMovieRating();
  },
  methods: {
    getMovieDetails() {
      const params = { id: this.id };
      this.$api
        .get("/detalhes-filme", { params })
        .then((res) => {
          const response = res.data.dados;
          const success = res.data.sucesso;

          if (success) {
            this.movie = {
              title: response.titulo,
              url: response.cartaz,
              synopsis: response.sinopse,
              minutes: response.duracaoMin,
              rating: this.rating,
              originalTitle: response.tituloOriginal,
              release: response.anoLancamento,
              cast: response.elenco,
              director: response.direcao,
              screenwriter: response.roteiro,
              distribution: response.distribuicao,
              language: response.idioma,
              country: response.pais,
            }
          } else {
            // to do: lançar erros p/ exibir feedback visual
          }

          this.changePageTitle(this.movie.title);
        })
        .catch(() => {});
    },

    getMovieRating() {
      const params = { id: this.id };
      this.$api
        .get("/obter-nota-filme", { params })
        .then((res) => {
          const response = res.data;

          if (response.sucesso) {
            this.movie.rating = Number(response.dados.nota).toFixed(1);
          }
        })
        .catch(() => {});
    },
  },

  computed: {
    movieHasLoaded() {
      return this.movie.title ? true : false;
    }
  },
};
</script>

<style>
@import url(../assets/styles/layout/l-movie.css);
</style>