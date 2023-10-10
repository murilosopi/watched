<template>
  <section class="col">
    <Title tag="h3" class="text-center">
      <i class="bi bi-chat-left-text"></i>&nbsp; Que tal compartilhar abaixo a
      sua opinião? :)
    </Title>
    <hr class="w-25 mx-auto" />
    <ReviewForm :movie="movie"/>
    <ReviewsList class="mt-5" :reviews="list" />
  </section>
</template>

<script>
import Title from "@/components/Title.vue";
import ReviewsList from "./ReviewsList.vue";
import ReviewForm from "./ReviewForm.vue";

export default {
  components: {
    Title,
    ReviewsList,
    ReviewForm
  },

  props: ['movie'],

  data() {
    return {
      list: [],
    }
  },

  methods: {

    getReviews() {
      const params = { filme: this.movie }
      this.$api
        .get('/obter-resenhas-filme', { params })
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