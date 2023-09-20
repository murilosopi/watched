<template>
  <section class="col">
    <Title tag="h3" class="text-center">
      <i class="bi bi-chat-left-text"></i>&nbsp; Que tal compartilhar abaixo a
      sua opinião? :)
    </Title>
    <hr class="w-25 mx-auto" />
    <DarkBox variant="gray" class="row px-md-5 px-3 py-5">
      <form @submit.prevent="submitReview">
        <div class="row text-center justify-content-center">
          <div class="col-lg order-lg-1">
            <div class="row mb-3">
              <fieldset class="col d-flex justify-content-between align-items-start">
                <p class="m-0 me-3">Avalie o filme:</p>
                <StarRating
                  :edit="true"
                  v-model="review.rating"
                  @change="review.rating = $event"
                />
              </fieldset>
            </div>
            <InputCustom :icon="false">
              <textarea
                v-model="review.text"
                slot="input"
                rows="10"
                class="form-control fs-6"
                :maxlength="800"
                @input="verifyTextSize"
                placeholder="Conta pra gente como foi o filme :)"
              ></textarea>
            </InputCustom>

            <p class="small text-white-50 text-end">
              {{ review.text.length }}/800
            </p>
          </div>
          <div class="col-lg-5 order-lg-0">
            <Reaction 
              class="mt-0 mt-lg-5"
              v-model="review.reactions"
              @change="review.reactions = $event"
            />
          </div>
        </div>

        <div class="col-lg-7 ms-auto mt-3 mt-lg-0 px-3">
          <div class="row gap-2">
            <div class="col-sm col-lg-7 p-0 order-sm-1">
              <ButtonCustom>Publicar</ButtonCustom>
            </div>
            <div class="col-sm p-0 order-sm-0">
              <ButtonCustom variant="azul" @click.native.prevent="resetReview">Limpar</ButtonCustom>
            </div>
          </div>
        </div>
      </form>
    </DarkBox>

    <ReviewsList class="mt-5" :reviews="list" />
  </section>
</template>

<script>
import Title from "@/components/Title.vue";
import StarRating from "@/components/StarRating.vue";
import InputCustom from "@/components/InputCustom.vue";
import Reaction from "@/components/Reaction.vue";
import DarkBox from "@/components/DarkBox.vue";
import ReviewsList from "./ReviewsList.vue";
import ButtonCustom from "@/components/ButtonCustom.vue";

export default {
  components: {
    Title,
    StarRating,
    InputCustom,
    Reaction,
    DarkBox,
    ReviewsList,
    ButtonCustom
  },

  props: ['movie'],

  data() {
    return {
      list: [],
      review: {
        rating: 0,
        reactions: [],
        text: '',
      },
    }
  },

  methods: {
    verifyTextSize() {
      if(this.review.text.length >= 800) {
        this.review.text = this.review.text.slice(0, 800)
      }
    },

    submitReview() {
      const params = {
        ...this.review,
        movie: this.movie
      };
      this.$api
        .post('/registrar-resenha', params)
        .then(res => {
          const response = res.data.sucesso;

          if(response) {
            this.resetReview();
            this.getReviews();
            // show success message
          }
        })
    },

    resetReview() {
      this.review = {
        rating: 0,
        reactions: [],
        text: '',
        movie: this.$route.params.id
      };
    },

    getReviews() {
      const params = { filme: this.movie }
      this.$api
        .get('/obter-resenhas-por-filme', { params })
        .then(res => {
          const response = res.data;
          
          if(response.sucesso) {
            this.list = response.dados.map((review => {
              return {
                user: review.username,
                rating: Number(review.nota),
                text: review.descricao,
                date: '01/01/2023',
              }
            }));
          }

        });
    }
  },
  
  created() {
    this.getReviews();
  }
};
</script>

<style>
</style>