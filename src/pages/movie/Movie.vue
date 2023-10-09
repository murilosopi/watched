<template>
  <main class="l-movie">
    <DarkBox class="row px-4 py-5 mb-5" id="article-movie">
      <div class="col-3 d-none d-md-block" :class="{placeholder: !movieHasLoaded}">
        <MoviePoster
          :url="movie.url || ''"
          :title="movie.title || ''"
          tag="figure"
          class="m-auto"
        ></MoviePoster>
      </div>

      <div class="col order-1 order-md-0">
        <div class="col p-0">
          <h2 class="h1 title w-100" :class="{placeholder: !movieHasLoaded}">{{ movie.title || '' }}</h2>
          <p class="w-100" :class="{'placeholder py-5': !movieHasLoaded}">{{ movie.synopsis || '' }}</p>
          <!-- Listagem de gêneros -->
          <BadgeList :badges="genresBadges" class="w-100" :class="{placeholder: !genresBadges.length}"/>
          <div class="d-flex align-items-center" :class="{placeholder: !movieHasLoaded}">
            <!-- Contagem de estrelas pela avaliação média -->
            <StarRating :value="movie.rating || 0" />
            <!-- Duração -->
            <p class="m-0 ms-md-4 ms-auto">
              <i class="bi bi-clock"></i>
              {{ movie.minutes || 0 | duration }}
            </p>
          </div>
        </div>
      </div>

      <div class="order-sm-0 order-1 col-sm-2 ps-5 p-md-0 mt-2 mt-sm-0">
        <div class="d-flex flex-wrap justify-content-end gap-3" :class="{placeholder: !movieHasLoaded}">
          <!-- Curtir/descurtir -->
          <InteractiveIcon>
            <i class="bi bi-heart fs-4"></i>
            0
          </InteractiveIcon>
          <!-- Marcar/desmarcar assistido -->
          <InteractiveIcon>
            <i class="bi bi-camera-reels fs-4"></i>
            0
          </InteractiveIcon>
          <!-- salvar/removerSalvoFilme -->
          <InteractiveIcon>
            <i class="bi bi-bookmark-star fs-4"></i>
            0
          </InteractiveIcon>
        </div>
      </div>
    </DarkBox>

    <div class="row">
      <div class="col">
        <MovieDetails :id="id" />
      </div>

      <div class="col-4 d-md-flex d-none px-0">
        <StreamingList :id="id" />
      </div>
    </div>

    <div class="row py-5">
      <ReviewSection :movie="id" />
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
import StreamingList from "@/pages/movie/StreamingList.vue";
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
        .get("/filme", { params })
        .then((res) => {
          const response = res.data.dados;
          const success = res.data.sucesso;

          if (success) {
            this.movie = {
              title: response.titulo,
              url: response.cartaz,
              synopsis: response.sinopse,
              minutes: response.duracaoMin,
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