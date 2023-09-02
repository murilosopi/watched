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
          <BadgeList :badges="genresBadges" />
          <div class="d-flex">
            <!-- Contagem de estrelas pela avaliação média -->
            <StarRating :value="movie.rating" />
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
          <InteractiveIcon>
            <i class="bi bi-heart"></i>
            0
          </InteractiveIcon>
          <!-- Marcar/desmarcar assistido -->
          <InteractiveIcon>
            <i class="bi bi-camera-reels"></i>
            0
          </InteractiveIcon>
          <!-- salvar/removerSalvoFilme -->
          <InteractiveIcon>
            <i class="bi bi-bookmark-star"></i>
            0
          </InteractiveIcon>
        </div>
      </div>
    </DarkBox>

    <div class="row">
      <div class="col">
        <MovieDetails v-if="movieHasLoaded" :movie="{ ...this.movie }" />
      </div>

      <div class="col-4 d-md-flex d-none px-0">
        <DarkBox class="ms-lg-5 p-4 h-100 w-100">
          <StreamingList :id="id" />
        </DarkBox>
      </div>
    </div>

    <div class="row py-5 px-2">
      <ReviewSection />
    </div>
  </main>
</template>

<script>
import PageMixin from "@/mixins/PageMixin";
import MoviePoster from "@/components/MoviePoster.vue";
import InteractiveIcon from "@/components/InteractiveIcon.vue";
import DarkBox from "@/components/DarkBox.vue";
import BadgeList from "@/components/BadgeList.vue";
import MovieDetails from "@/components/MovieDetails.vue";
import StreamingList from "@/components/StreamingList.vue";
import StarRating from "@/components/StarRating.vue";
import ReviewSection from '@/pages/movie/Review.vue';


export default {
  components: {
    MoviePoster,
    InteractiveIcon,
    DarkBox,
    BadgeList,
    MovieDetails,
    StreamingList,
    StarRating,
    ReviewSection
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
      genres: [],
    };
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
            };
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

    getMovieGenres() {
      const params = { id: this.id };
      this.$api
        .get("/obter-generos-filme", { params })
        .then((res) => {
          const response = res.data.dados;
          const success = res.data.sucesso;

          if (success) {
            this.genres = response.map((genre) => genre.nome);
          }
        })
        .catch(() => {});
    },

    submitReview() {
      console.log(this.review);
    }
  },

  computed: {
    movieHasLoaded() {
      return this.movie.title ? true : false;
    },

    genresBadges() {
      return this.genres ? this.genres.map((genre) => ({ text: genre })) : [];
    },
  },

  beforeRouteEnter(to, from, next) {
    next((page) => {
      page.changeFavicon("filme", "svg");
      page.changePageTitle("Filme");
    });
  },

  created() {
    this.getMovieDetails();
    this.getMovieRating();
    this.getMovieGenres();
  },
};
</script>

<style>
@import url(../../assets/styles/layout/l-movie.css);
</style>