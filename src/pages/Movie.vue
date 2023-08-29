<template>
  <div class="movie">
    <DarkBox class="row px-4 py-5 mb-5" id="article-movie">
      <!-- Cartaz do filme -->
      <div class="col-3 d-none d-md-block">
        <MoviePoster
          :url="'https://s2.glbimg.com/Zo7GePN37wWm8PSsRQDuWVyJSgo=/e.glbimg.com/og/ed/f/original/2019/03/25/spiderffh_tsrposter_london_breve.jpg'"
          :title="'lorem'"
          tag="figure"
          class="m-auto"
        ></MoviePoster>
      </div>

      <!-- Principais informações do filme -->
      <div class="col order-1 order-md-0">
        <div class="col p-0">
          <h2 class="h1 title">Lorem ipsum dolar</h2>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed veniam
            praesentium porro qui unde dignissimos repudiandae, voluptatum,
            corrupti sequi illum adipisci, iure ducimus placeat maiores et aut
            nulla hic aliquam?
          </p>

          <!-- Listagem de gêneros -->
          <BadgeList :badges="[]"/>

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
            <p class="me-auto me-sm-4">5.0</p>

            <!-- Duração -->
            <p>
              <i class="bi bi-clock"></i>
              2h10min
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
  </div>
</template>

<script>
import MoviePoster from "@/components/MoviePoster.vue";
import IconButton from "@/components/IconButton.vue";
import PageMixin from "@/mixins/PageMixin";
import DarkBox from "@/components/DarkBox.vue";
import BadgeList from "@/components/BadgeList.vue";
export default {
  components: {
    MoviePoster,
    IconButton,
    DarkBox,
    BadgeList
  },
  mixins: [PageMixin],
  created() {
    this.alterarFavicon("filme", "svg");
    this.alterarTitle("Filme");
  },
};
</script>

<style>
.dark-box {
  background-color: rgb(23, 23, 23);
}
</style>