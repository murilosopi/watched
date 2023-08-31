export default {
  methods: {
    changeFavicon(icone, tipo) { 
      const favicon = document.querySelector("link[rel~='icon']");
      favicon.href = `/favicons/${icone}.${tipo}`;
    },
    changePageTitle(title = '') {
      const el = document.querySelector("title");
      el.text = title.length ? `${title} - Watched` : 'Watched';
    }
  }
};