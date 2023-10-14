<template>
  <form
    action="pesquisar"
    class="d-none d-sm-flex flex-grow-1 mx-3 mx-md-5"
    id="form-search"
    @keypress.enter.prevent="submit"
    @submit.prevent="submit"
  >
    <div class="input-group search-box w-100">
      <input
        type="search"
        autocomplete="off"
        name="pesquisa"
        placeholder="Busque por filmes e usuários..."
        class="flex-grow-1"
        v-model="search"
      />
      <button type="submit">
        <i class="bi bi-search"></i>
      </button>
    </div>
  </form>
</template>

<script>
import router from '@/routes';
export default {
  props: ['value'],
  data() {
    return {
      search: this.value || ''
    }
  },
  methods: {
    submit() {
      if(this.search.length) router.push(`/pesquisar/${this.search.replaceAll(' ', '-')}`)
    }
  }
};
</script>

<style>
.search-box {
  color: white;
}

.search-box input,
.search-box button {
  color: inherit;
  background-color: #383737;
  border: none;
  outline: none;
  border-radius: 0.5rem;

  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
}

.search-box input {
  padding-left: 2rem;
  padding-right: 2rem;
}

.search-box button {
  padding-left: 1rem;
  padding-right: 1rem;
}
</style>
