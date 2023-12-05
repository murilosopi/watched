<template>
  <ul class="list-unstyled row">
    <li v-for="(review, index) in reviewsList" :key="review.id" class="col-lg-6 mb-4 px-0 px-lg-3"
      :class="index % 2 == 0 ? 'ps-lg-0' : 'pe-lg-0'">
      <DarkBox class="ps-4 p-3">
        <Comment :comment="review" @delete="deleteReview(review)" @report="reportReview"/>
      </DarkBox>
    </li>
  </ul>
</template>

<script>
import Comment from "@/components/Comment";
import DarkBox from '@/components/DarkBox.vue';
import ReviewMixin from "@/mixins/ReviewMixin";
import Swal from 'sweetalert2';
export default {
  components: {
    Comment,
    DarkBox
  },
  methods: {
    async reportReview() {
      let { value } = await Swal.fire({
        input: "textarea",
        inputLabel: "Denunciar",
        inputPlaceholder: "Descreva o motivo da sua denúncia...",
        inputAttributes: {
          "aria-label": "Descreva o motivo da sua denúncia"
        },
        showCancelButton: true,
        inputValidator(value) {
          if(value.length < 15) {
            return 'A sua denúncia deve conter, no mínimo, 15 caracteres.'
          }
        }
      });

      if(value) Swal.fire('Denúncia Registrada', 'Sua denúncia foi registrada e logo será analisada pela nossa equipe.', 'info')
    }
  },
  mixins: [ReviewMixin],
  props: {
    reviews: Array,
  }
};
</script>

<style></style>
