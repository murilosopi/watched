<template>
  <main id="config">
    <InteractiveIcon :inline="true" @click.native="$router.back()">
      <i class="bi bi-chevron-left me-2"></i>
      Voltar
    </InteractiveIcon>
    <Title tag="h2" class="h1 mt-3">Configurações</Title>

    <ListGroup>
      <ListGroupItem>
        Alterar Avatar
      </ListGroupItem>
      <ListGroupItem>
        Mudar Privacidade
      </ListGroupItem>
      <ListGroupItem>
        Tornar-se Premium
      </ListGroupItem>
      <ListGroupItem>
        Sair
      </ListGroupItem>
    </ListGroup>
  </main>
</template>
  
  <script>
import InteractiveIcon from "@/components/InteractiveIcon.vue";
import Title from "@/components/Title.vue";
import ListGroup from '@/components/ListGroup.vue';
import ListGroupItem from '@/components/ListGroupItem.vue';

export default { components: { Title, InteractiveIcon, ListGroup, ListGroupItem } };
</script>
<style scoped>

</style>