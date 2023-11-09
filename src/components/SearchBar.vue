<template>
  <form
    action="pesquisar"
    id="form-search"
    @keypress.enter.prevent="submit"
    @submit.prevent="submit"
  >
    <div class="input-group search-box w-100">
      <input
        type="search"
        autocomplete="off"
        name="pesquisa"
        :placeholder="placeholder || ''"
        class="flex-grow-1 px-sm-3 px-2"
        v-model="search"
      />
      <button type="submit" class="px-3">
        <i class="bi bi-search"></i>
      </button>
    </div>
  </form>
</template>

<script>
import router from '@/routes';
export default {
  props: ['value', 'placeholder'],
  data() {
    return {
      search: this.value || ''
    }
  },
  methods: {
    submit() {
      if(this.search.length) router.push(`/pesquisar/${this.search.replaceAll(' ', '-')}`).catch(()=>{});
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

</style>
