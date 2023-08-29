export default {
  methods: {
    alterarFavicon(icone, tipo) { 
      const favicon = document.querySelector("link[rel~='icon']");
      favicon.href = `/favicons/${icone}.${tipo}`;
    },
    alterarTitle(title = '') {
      const el = document.querySelector("title");
      el.text = title.length ? `${title} - Watched` : 'Watched';
    }
  }
};