<template>
  <main class="l-movie">
    <DarkBox class="row px-4 py-5 mb-5" id="article-movie">
      <div
        class="col-3 d-none d-md-block"
      >
        <MoviePoster
          :url="details.url || ''"
          :title="details.title || ''"
          tag="figure"
          class="m-auto w-100"
          :class="{ placeholder: !movieHasLoaded }"
        ></MoviePoster>
      </div>

      <div class="col order-1 order-md-0">
        <div class="col p-0">
          <h2 class="h1 title w-100" :class="{ placeholder: !movieHasLoaded }">
            {{ details.title || "" }}
          </h2>
          <p class="w-100" :class="{ 'placeholder py-5': !movieHasLoaded }">
            {{ details.synopsis || "" }}
          </p>
          <!-- Listagem de gêneros -->
          <BadgeList
            :badges="genresBadges"
            class="w-100"
            :class="{ placeholder: !genresBadges.length }"
          />
          <div
            class="d-flex align-items-center"
            :class="{ placeholder: !movieHasLoaded }"
          >
            <!-- Contagem de estrelas pela avaliação média -->
            <StarRating :value="details.rating || 0" />
            <!-- Duração -->
            <p class="m-0 ms-md-4 ms-auto">
              <i class="bi bi-clock"></i>
              {{ details.minutes || 0 | duration }}
            </p>
          </div>
        </div>
      </div>

      <div class="order-sm-0 order-1 col-sm-2 ps-5 p-md-0 mt-2 mt-sm-0">
        <div
          class="d-flex flex-wrap justify-content-end gap-3"
          :class="{ placeholder: !movieHasLoaded }"
        >
          <!-- Curtir/descurtir -->
          <InteractiveIcon @click.native="captureLiked(id)">
            <i
              class="bi fs-4"
              :class="{
                'bi-heart': !liked,
                'bi-heart-fill': liked,
              }"
            ></i>
            {{ totalLiked }}
          </InteractiveIcon>
          <!-- Marcar/desmarcar assistido -->
          <InteractiveIcon @click.native="captureWatched(id)">
            <i
              class="bi fs-4"
              :class="{
                'bi-camera-reels': !watched,
                'bi-camera-reels-fill': watched,
              }"
            ></i>
            {{ totalWatched }}
          </InteractiveIcon>
          <!-- salvar/removerSalvoFilme -->
          <InteractiveIcon @click.native="captureSaved(id)">
            <i class="bi fs-4"
             :class="{
              'bi-bookmark-star': !saved,
              'bi-bookmark-star-fill': saved,
             }"></i>
            {{ totalSaved }}
          </InteractiveIcon>
        </div>
      </div>
    </DarkBox>

    <div class="row">
      <div class="col">
        <MovieDetails :id="id" :details="details" v-if="movieHasLoaded" />
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
import ReviewSection from "@/pages/movie/Review.vue";
import MovieInteractionMixin from "@/mixins/MovieInteractionMixin";

export default {
  components: {
    MoviePoster,
    InteractiveIcon,
    DarkBox,
    BadgeList,
    MovieDetails,
    StreamingList,
    StarRating,
    ReviewSection,
  },

  mixins: [PageMixin, MovieInteractionMixin],

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
      details: {},

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
            this.details = {
              originalTitle: response.tituloOriginal,
              release: response.anoLancamento,
              cast: response.elenco,
              director: response.direcao,
              screenwriter: response.roteiro,
              distribution: response.distribuicao,
              language: response.idioma,
              country: response.pais,
              title:  response.titulo,
              url:  response.cartaz,
              synopsis:  response.sinopse,
              genres:  response.generos,
              minutes:  response.duracaoMin
            }

            this.changePageTitle(this.details.title);

          } else {
            this.$router.push('/erro');
          }
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
            this.details.rating = Number(response.dados.nota).toFixed(1);
          }
        })
        .catch(() => {});
    },
  },

  computed: {
    movieHasLoaded() {
      return this.details.title ? true : false;
    },

    genresBadges() {
      return this.details.genres ? this.details.genres.map((genre) => ({ text: genre.name })) : [];
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
    this.getInteractionValues();
  },
};
</script>

<style>
@import url(../../assets/styles/layout/l-movie.css);
</style>