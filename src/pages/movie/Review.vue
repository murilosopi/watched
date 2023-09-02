<template>
  <section class="col">
    <Title tag="h3" class="text-center d-none">
      <i class="bi bi-chat-left-text"></i>&nbsp; Que tal compartilhar abaixo a
      sua opinião? :)
    </Title>
    <hr class="w-25 mx-auto" />
    <DarkBox variant="gray" class="row px-md-5 px-3 py-5">
      <form @submit.prevent="submitReview">
        <div class="row">
          <fieldset class="col d-flex">
            <p class="me-3">Avalie o filme:</p>
            <StarRating
              :edit="true"
              v-model="review.rating"
              @change="review.rating = $event"
            />
          </fieldset>
        </div>
        <div class="row text-center justify-content-center">
          <div class="col-lg order-lg-1">
            <InputCustom :icon="false">
              <textarea
                v-model="review.text"
                slot="input"
                rows="10"
                class="form-control fs-6"
                placeholder="Conta pra gente como foi o filme :)"
              ></textarea>
            </InputCustom>
          </div>
          <div class="col-lg-5 order-lg-0">
            <Reaction
              v-model="review.reactions"
              @change="review.reactions = $event"
            />
          </div>
        </div>
      </form>
    </DarkBox>
  </section>
</template>

<script>
import Title from "@/components/Title.vue";
import StarRating from "@/components/StarRating.vue";
import InputCustom from "@/components/InputCustom.vue";
import Reaction from "@/components/Reaction.vue";
import DarkBox from "@/components/DarkBox.vue";

export default {
  components: {
    Title,
    StarRating,
    InputCustom,
    Reaction,
    DarkBox
  },
  data() {
    return {
      review: {
        rating: 0,
        reactions: []
      },
    }
  }
};
</script>

<style>
</style>