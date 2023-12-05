<template>
  <Dialog class="modal-change-avatar" :customHeader="true">
    <Title tag="h2" class="h1 w-100 text-center" slot="header">
      <i class="bi bi-award"></i>
      Assine Já!!
    </Title>
    <div slot="content" class="p-4">
      <p class="fw-bold text-center fs-5">Conheça nosso plano de assinatura mensal e desfrute do seu lado cinéfilo!</p>
      <hr class="w-50 border border-white opacity-75 mx-auto">
      <ul class="benefit-list list-unstyled text-center opacity-75 d-flex flex-column gap-3"> 
        <li class="benefit-item">
          <span class="benefit-text">Postagens com + caracteres </span>
          <i class="bi bi-blockquote-left fs-4"></i>
        </li>
        <li class="benefit-item">
          <span class="benefit-text">Impulsionar suas postagens</span>
          <i class="bi bi-chevron-up text-primary fs-4"></i>
        </li>
        <li class="benefit-item">
          <span class="benefit-text">Selo de verificação</span>
          <i class="bi bi-ticket-perforated text-warning fs-4"></i>
        </li>
        <li class="benefit-item">
          <span class="benefit-text">Edição de resenhas </span>
          <i class="bi bi-pencil-fill text-info fs-4"></i>
        </li>
        <li class="benefit-item">
          <span class="benefit-text">Sem anúncios</span>
          <i class="bi bi-ban text-danger fs-4"></i>
        </li>
      </ul>

      <p class="offer rounded fw-bold text-center fs-5">Por apenas R$ 19,90 ao mês</p>
    </div>
    <div slot="footer">
      <button class="bg-transparent border-0 outline-0 text-white-50" data-bs-dismiss="modal">
        Ignorar
      </button>
    </div>
  </Dialog>
</template>

<script>
import Dialog from "@/components/Dialog.vue";
import Title from "@/components/Title.vue";

export default {
  components: { Dialog, Title }
};
</script>

<style scoped>

.benefit-item {
  display: flex;
  justify-content: space-between;
  border-bottom: 3px dashed white;
}

.benefit-text {
  font-weight: bold;
  font-size: 1.2rem;
}

.offer {
  background: rgba(74, 74, 74, 0.65); 
  padding: 1rem;
}
</style>
